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
        Schema::create('order_includes', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('order_id');
            $table->string('title');
            $table->double('price');
            $table->double('quantity');
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_includes');
    }
};
