<?php

namespace App\Exports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;

class ReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Created at',
            'Updated at'
        ];
    }
}
