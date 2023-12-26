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
        Schema::create('job_requests', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('seller_id');
            $table->bigInteger('buyer_id');
            $table->bigInteger('job_post_id');
            $table->tinyInteger('is_hired')->default(0);
            $table->double('expected_salary')->nullable();
            $table->string('cover_letter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requests');
    }
};
