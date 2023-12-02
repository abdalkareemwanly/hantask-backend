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
        Schema::create('media_uploads', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->text('title');
            $table->text('path');
            $table->text('alt')->nullable();
            $table->text('size')->nullable();
            $table->text('dimensions')->nullable();
            if (!Schema::hasColumn('media_uploads','type')){
                $table->string('type',10)->default('admin');
            }
            if (!Schema::hasColumn('media_uploads','user_id')){
                $table->unsignedBigInteger('user_id')->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};
