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
        Schema::create('edit_service_histories', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('service_id');
            $table->bigInteger('seller_id');
            $table->string('service_title');
            $table->longText('service_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_service_histories');
    }
};
