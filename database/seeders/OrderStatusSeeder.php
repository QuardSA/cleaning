<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();
        DB::table('orderstatuses')->insert([
            ['titlestatus'=>'Новое','created_at'=>$date,'updated_at'=>$date],
            ['titlestatus'=>'Принято','created_at'=>$date,'updated_at'=>$date],
            ['titlestatus'=>'Отклонено','created_at'=>$date,'updated_at'=>$date],
            ['titlestatus'=>'Отменено пользователем','created_at'=>$date,'updated_at'=>$date],
            ['titlestatus'=>'Выполнено','created_at'=>$date,'updated_at'=>$date],
        ]);
    }
}
