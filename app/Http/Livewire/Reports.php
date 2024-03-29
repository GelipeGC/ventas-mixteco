<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use App\Models\SaleDetail;

class Reports extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType, $userId, $dateFrom, $dateTo, $saleId;

    public function mount()
    {
        $this->componentName = 'Reportes de ventas';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
    }
    public function render()
    {
        $this->salesByDate();
        $users = User::orderBy('name')->get();
        return view('livewire.reports.component', compact('users'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
    public function salesByDate()
    {
        if($this->reportType == 0) {//ventas del dia
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }
        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->emit('error-report', 'Por favor selecciona un rango de fechas');
            return;
        }
        if ($this->userId == 0) {
            $this->data = Sale::join('users as u','u.id','sales.user_id')
                                ->select('sales.*','u.name as user')
                                ->whereBetween('sales.created_at', [$from, $to])
                                ->get();
        } else {
            $this->data = Sale::join('users as u','u.id','sales.user_id')
                                ->select('sales.*','u.name as user')
                                ->whereBetween('sales.created_at', [$from, $to])
                                ->where('sales.user_id', $this->userId)
                                ->get();
        }
    }

    public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id','sale_details.product_id')
                                    ->select('sale_details.id','sale_details.price','sale_details.quantity','p.name as product')
                                    ->where('sale_details.sale_id', $saleId)
                                    ->get();
        $sum = $this->details->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $sum;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;
        $this->emit('show-modal','open modal details');
    }
}
