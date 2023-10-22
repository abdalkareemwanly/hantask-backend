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
        Schema::create('page_builders', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('addon_name')->nullable();
            $table->string('addon_type')->nullable();
            $table->string('addon_namespace')->nullable();
            $table->string('addon_location')->nullable();
            $table->unsignedBigInteger('addon_order')->nullable();
            $table->unsignedBigInteger('addon_page_id')->nullable();
            $table->string('addon_page_type')->nullable();
            $table->longText('addon_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_builders');
    }
};
