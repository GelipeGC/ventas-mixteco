<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;

class Cashout extends Component
{
    public $fromDate, $toDate, $userId, $total, $items, $sales, $details;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userId = 0;
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }
    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.cashout.component', compact('users'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function Consult()
    {
        $dateInitial = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $dateFinish = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->sales = Sale::whereBetween('created_at', [$dateInitial, $dateFinish])
                            ->where('status', 'PAID')
                            ->where('user_id', $this->userId)
                            ->get();
        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;

    }
    public function viewDetails(Sale $sale)
    {
        $dateInitial = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $dateFinish = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->details = Sale::join('sale_details as d','d.sale_id','sales.id')
                                ->join('products as p','p.id','d.product_id')
                                ->select('d.sale_id','p.name as product','d.quantity','d.price')
                                ->whereBetween('sales.created_at', [$dateInitial, $dateFinish])
                                ->where('sales.status', 'PAID')
                                ->where('sales.user_id', $this->userId)
                                ->where('sales.id', $sale->id)
                                ->get();
        $this->emit('show-modal','Open modal');

    }
    public function Print()
    {
        # code...
    }
}
