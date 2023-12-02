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
        Schema::create('extra_services', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('order_id');
            $table->string('title');
            $table->unsignedBigInteger('quantity');
            $table->double('price');
            $table->string('payment_gateway')->nullable();
            $table->string('manual_payment_gateway_image')->nullable();
            $table->double('tax')->nullable();
            $table->double('commission_amount')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->unsignedBigInteger('status')->nullable()->comment('0=pending,1=accept,2=decline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_services');
    }
};
