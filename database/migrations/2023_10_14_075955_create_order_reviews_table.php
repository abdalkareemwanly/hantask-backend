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
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('order_id')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('service_id');
            $table->bigInteger('seller_id');
            $table->bigInteger('buyer_id');
            $table->double('rating');
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->bigInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
