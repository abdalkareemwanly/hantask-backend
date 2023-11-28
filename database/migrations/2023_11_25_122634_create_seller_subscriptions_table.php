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
        Schema::create('seller_subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->foreignIdFor(Subscription::class,'subscription_id');
            $table->foreignIdFor(User::class,'seller_id');
            $table->string('type')->nullable();
            $table->string('connect')->default(0);
            $table->double('price')->default(0);
            $table->bigInteger('initial_connect')->default(0);
            $table->bigInteger('initial_service')->default(0);
            $table->bigInteger('initial_job')->default(0);
            $table->double('initial_price')->default(0);
            $table->double('total')->default(0);
            $table->timestamp('expire_date')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('manual_payment_image')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_subscriptions');
    }
};
