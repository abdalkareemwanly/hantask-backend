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
        Schema::create('serviceadditionals', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('service_id');
            $table->bigInteger('seller_id');
            $table->string('additional_service_title')->nullable();
            $table->double('additional_service_price')->nullable();
            $table->integer('additional_service_quantity')->nullable();
            $table->string('additional_service_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serviceadditionals');
    }
};
