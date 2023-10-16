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
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('category_id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->text('slug')->nullable();
            $table->longText('blog_content');
            $table->string('image');
            $table->string('author')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('views')->nullable();
            $table->string('visibility')->nullable();
            $table->string('featured')->nullable();
            $table->string('schedule_date')->nullable();
            $table->string('tag_name')->nullable();
            $table->enum('status', ['publish', 'draft','archive','schedule']);
            $table->longText('tag_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
