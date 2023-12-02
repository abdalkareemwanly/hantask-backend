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
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('seller_id');
            $table->double('amount');
            $table->string('payment_gateway')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->text('seller_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending 1=complete, 2=cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
    }
};
