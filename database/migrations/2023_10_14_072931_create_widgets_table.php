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
        Schema::create('widgets', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('widget_area')->nullable();
            $table->integer('widget_order')->nullable();
            $table->string('widget_location')->nullable();
            $table->text('widget_name');
            $table->longText('widget_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
