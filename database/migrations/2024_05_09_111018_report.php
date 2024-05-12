<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('file',100);
            $table->foreignId('user')->references('id')->on('users');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
