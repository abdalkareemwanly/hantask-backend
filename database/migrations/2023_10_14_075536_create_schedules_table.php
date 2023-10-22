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
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('day_id');
            $table->bigInteger('seller_id');
            $table->string('schedule');
            $table->bigInteger('status')->nullable();
            $table->string('allow_multiple_schedule')->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
