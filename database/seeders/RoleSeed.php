<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();
        DB::table('roles')->insert([
            ['titlerole'=>'Пользователь','created_at'=>$date,'updated_at'=>$date],
            ['titlerole'=>'Администратор','created_at'=>$date,'updated_at'=>$date],
        ]);
    }
}
