<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
        Schema::create('post_approvs', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->foreignIdFor(User::class,'buyer_id');
            $table->foreignIdFor(Post::class,'post_id');
            $table->foreignIdFor(Comment::class,'comment_id');
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_approvs');
    }
};
