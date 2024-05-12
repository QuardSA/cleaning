<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Order;

class ReportImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        Order::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ]);
    }
}
