<?php

namespace App\Http\Livewire;

use App\Models\Sale as Venta;
use App\Models\Product;
use Livewire\Component;
use App\Models\SaleDetail;
use App\Models\Denomination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class Sale extends Component
{
    public $total, $itemQuantity, $cash, $change;

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'remove-item' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];
    public function mount()
    {
        $this->cash = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {
        $denominations = Denomination::orderBy('value', 'desc')->get();
        $cart = Cart::getContent()->sortBy('name');

        return view('livewire.sales.component', compact('denominations','cart'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function ACash($value)
    {
        $this->cash += ($value == 0 ? $this->total : $value );
        $this->change = ($this->cash - $this->total);
    }

    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null || empty($product)) {
            $this->emit('scan-notfound', 'El producto no está registrado');
        }else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }

            if ($product->stock < 1) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemQuantity = Cart::getTotalQuantity();

            $this->emit('scan-ok', 'Producto agregado');

        }
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);

        return ($exist) ? true : false;
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

         if ($exist) {
             $title = 'Cantidad actualizada';
         } else {
             $title = 'Producto agregado';
         }
        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        $this->total = Cart::getTotal();
        $this->itemQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);

    }

    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }

        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }
        $this->removeItem($productId);

        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity - 1);

        if ($newQty > 0) {
            Cart::add($item->id, $item->name,$item->price, $newQty,$item->attributes[0]);
        }
        $this->total = Cart::getTotal();
        $this->itemQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada');
    }
    public function clearCart()
    {
        Cart::clear();
        $this->cash = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vacío');

    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');
            return;
        }
        if ($this->cash <= 0) {
            $this->emit('sale-error', 'Ingrese el efectivo');
            return;
        }
        if ($this->total > $this->cash) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');
            return;
        }

        DB::beginTransaction();

        try {
            $sale = Venta::create([
                'total' => $this->total,
                'items' => $this->itemQuantity,
                'cash' => $this->cash,
                'change' => $this->change,
                'user_id' => Auth::id()
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id
                    ]);
                    //update stock
                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }
            DB::commit();

            Cart::clear();
            $this->cash = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Venta registrada con éxito');
            $this->emit('print-ticket', $sale->id);

        } catch (\QueryException $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }
}
