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
        Schema::create('post_approvals', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('post_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('buyer_id');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_approvals');
    }
};
