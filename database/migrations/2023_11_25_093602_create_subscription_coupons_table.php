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
        Schema::create('subscription_coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('coupon_id');
            $table->string('name');
            $table->string('amount');
            $table->string('currency');
            $table->string('status')->default(0)->comment('0=archived, 1=unArchived');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_coupons');
    }
};
