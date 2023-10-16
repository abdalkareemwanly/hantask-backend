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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->text('title')->nullable();
            $table->text('via')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('user_agent')->nullable();
            $table->longText('description')->nullable();
            $table->text('subject')->nullable();
            $table->string('status')->nullable();
            $table->string('priority')->nullable();
            $table->string('department')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('buyer_id')->nullable();
            $table->bigInteger('seller_id')->nullable();
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
