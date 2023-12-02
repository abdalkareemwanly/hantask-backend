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
        Schema::create('report_chat_messages', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('report_id');
            $table->bigInteger('admin_id')->nullable();
            $table->bigInteger('seller_id')->nullable();
            $table->bigInteger('buyer_id')->nullable();
            $table->text('message')->nullable();
            $table->string('type')->nullable();
            $table->string('notify')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_chat_messages');
    }
};
