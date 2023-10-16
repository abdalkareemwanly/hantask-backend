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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('service_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('buyer_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('post_code');
            $table->string('address');
            $table->bigInteger('city');
            $table->bigInteger('area');
            $table->bigInteger('country');
            $table->string('date');
            $table->string('schedule');
            $table->double('package_fee');
            $table->double('extra_service');
            $table->double('sub_total');
            $table->double('tax');
            $table->double('total');
            $table->string('coupon_code')->nullable();
            $table->string('coupon_type')->nullable();
            $table->double('coupon_amount')->nullable();
            $table->string('commission_type')->nullable();
            $table->double('commission_charge')->nullable();
            $table->double('commission_amount')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('status')->nullable()->comment('0=pending, 1=active, 2=completed, 3=delivered, 4=cancelled');
            $table->integer('order_complete_request')->default(0);
            $table->integer('is_order_online')->default(0);
            $table->integer('cancel_order_money_return')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('order_note')->nullable();
            $table->string('order_from_job')->nullable();
            $table->bigInteger('job_post_id')->nullable();
            $table->string('manual_payment_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
