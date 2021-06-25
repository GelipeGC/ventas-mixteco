<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Denomination;
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
            $this->emit('scan-notfound', 'El producto no está registrado')
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
        $this->itemsQuantity = Cart::getTotalQuantity();
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
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }
}
