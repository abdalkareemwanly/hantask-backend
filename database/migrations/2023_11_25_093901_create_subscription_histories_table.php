<?php

use App\Models\Subscription;
use App\Models\User;
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
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->foreignIdFor(Subscription::class,'subscription_id');
            $table->foreignIdFor(User::class,'seeler_id');
            $table->string('type')->nullable();
            $table->bigInteger('connect')->default(0);
            $table->double('price')->default(0);
            $table->string('coupon_code')->nullable();
            $table->string('coupon_type')->nullable();
            $table->string('coupon_amount')->default(0);
            $table->double('price_with_discount')->default(0);
            $table->tinyInteger('expire_date')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_histories');
    }
};
