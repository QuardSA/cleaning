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
            $table->foreignId('user')->constrained()->onDelete('cascade');
            $table->foreignId('service')->constrained()->onDelete('cascade');
            $table->foreignId('status')->constrained('orderstatuses')->onDelete('cascade');
            $table->string('phone',12);
            $table->string('address',100);
            $table->integer('square');
            $table->integer('cost');
            $table->date('date');
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
