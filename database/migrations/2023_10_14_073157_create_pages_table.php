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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->text('title');
            $table->text('slug')->nullable();
            $table->longText('page_content')->nullable();
            $table->string('visibility')->nullable();
            $table->string('status')->nullable();
            $table->string('back_to_top')->nullable();
            $table->string('page_builder_status')->nullable();
            $table->string('layout')->nullable();
            $table->string('sidebar_layout')->nullable();
            $table->string('navbar_variant')->nullable();
            $table->string('page_class')->nullable();
            $table->string('breadcrumb_status')->nullable();
            $table->string('footer_variant')->nullable();
            $table->string('widget_style')->nullable();
            $table->string('left_column')->nullable();
            $table->string('right_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
