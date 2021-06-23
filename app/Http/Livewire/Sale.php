<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;

class Sale extends Component
{
    public $total=10, $cart = [],$itemQuantity=5,$cash,$change;
    public function render()
    {
        $denominations = Denomination::all();

        return view('livewire.sales.component', compact('denominations'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
}
