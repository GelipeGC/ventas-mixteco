<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sale extends Component
{
    public function render()
    {
        return view('livewire.sales.component')
                ->extends('layouts.theme.app')
                ->section('content');
    }
}
