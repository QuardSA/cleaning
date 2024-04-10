<?php

use Database\Seeders\OrderStatusSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orderstatuses', function (Blueprint $table) {
            $table->id();
            $table->string('titlestatus',100);
            $table->timestamps();
        });
        Artisan::call('db:seed', ['--class'=>OrderStatusSeeder::class]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderstatuses');
    }
};
