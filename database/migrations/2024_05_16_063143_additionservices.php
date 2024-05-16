<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additionalservices', function (Blueprint $table) {
            $table->id();
            $table->string('titleadditionalservices',100);
            $table->float('work_time');
            $table->double('cost',100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('additionalservices');
    }
};
