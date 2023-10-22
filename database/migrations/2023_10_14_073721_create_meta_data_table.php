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
        Schema::create('meta_data', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('meta_taggable_id');
            $table->string('meta_taggable_type');
            $table->string('meta_title')->nullable();
            $table->string('meta_tags')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('facebook_meta_tags')->nullable();
            $table->text('facebook_meta_description')->nullable();
            $table->string('facebook_meta_image')->nullable();
            $table->string('twitter_meta_tags')->nullable();
            $table->text('twitter_meta_description')->nullable();
            $table->string('twitter_meta_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_data');
    }
};
