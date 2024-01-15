<?php

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
        Schema::create('notification_sellers', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->foreignIdFor(User::class,'seller_id');
            $table->string('title');
            $table->string('status')->default(0)->comment('0=unread, 1=readable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_sellers');
    }
};
