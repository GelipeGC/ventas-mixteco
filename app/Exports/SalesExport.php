<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class SalesExport implements FromCollection,WithHeadings, WithCustomStartCell,WithTitle, WithStyles
{
    protected $userId, $dateFrom, $dateTo, $reportType;

    function __construct($userId, $reportType, $dateFrom, $dateTo)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        if($this->reportType == 0) {//ventas del dia
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }
        if ($this->userId == 0) {
            $data = Sale::join('users as u','u.id','sales.user_id')
                                ->select('sales.id','sales.total','sales.items','sales.status','u.name as user','sales.created_at')
                                ->whereBetween('sales.created_at', [$from, $to])
                                ->get();
        } else {
            $data = Sale::join('users as u','u.id','sales.user_id')
                                ->select('sales.id','sales.total','sales.items','sales.status','u.name as user','sales.created_at')
                                ->whereBetween('sales.created_at', [$from, $to])
                                ->where('user_id', $this->userId)
                                ->get();
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'FOLIO',
            'IMPORTE',
            'ITEMS',
            'ESTATUS',
            'USUARIO',
            'FECHA'
        ];
    }
    public function startCell(): string
    {
        return 'A2';
    }
    public function styles(worksheet $sheet)
    {
        return [
            2 => [
                'font' => ['bold' => true]
            ]
        ];
    }
    public function title(): string
    {
        return 'Reporte de Ventas';
    }
}
