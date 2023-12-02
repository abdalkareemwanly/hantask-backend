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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('order_id');
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('seller_id');
            $table->bigInteger('buyer_id');
            $table->string('report_from')->nullable();
            $table->string('report_to')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
