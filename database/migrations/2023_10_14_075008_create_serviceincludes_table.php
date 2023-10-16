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
        Schema::create('serviceincludes', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('service_id');
            $table->bigInteger('seller_id');
            $table->string('include_service_title');
            $table->double('include_service_price');
            $table->integer('include_service_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serviceincludes');
    }
};
