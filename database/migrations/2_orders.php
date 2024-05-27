<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('service')->constrained('services')->onDelete('cascade');
            $table->foreignId('status')->constrained('orderstatuses')->onDelete('cascade');
            $table->string('phone', 16);
            $table->string('address', 100);
            $table->integer('square');
            $table->integer('cost');
            $table->float('work_time');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
