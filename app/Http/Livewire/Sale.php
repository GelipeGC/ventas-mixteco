<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Traits\CartTrait;
use App\Models\SaleDetail;
use App\Models\Denomination;
use App\Models\Sale as Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class Sale extends Component
{
    use CartTrait;

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
        $this->codeScan($barcode, $cant);
    }

    public function increaseQty(Product $product, $cant = 1)
    {
        $this->IncreaseQuantity($product, $cant);

    }

    public function updateQty(Product $product, $cant = 1)
    {
        if ($cant <= 0) {
            $this->removeItem($product->id);
        }else {
            $this->updateQuantity($product, $cant);
        }
    }

    public function decreaseQty($productId)
    {
        $this->decreaseQuantity($productId);
    }

    public function clearCart()
    {
        $this->trashCart();
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
