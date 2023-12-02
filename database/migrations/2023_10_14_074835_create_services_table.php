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
        Schema::create('services', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('child_category_id')->nullable();
            $table->bigInteger('seller_id');
            $table->bigInteger('service_city_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('image')->nullable();
            $table->text('image_gallery')->nullable();
            $table->longText('video')->nullable();
            $table->bigInteger('status');
            $table->bigInteger('is_service_online')->default(0);
            $table->double('price')->default(0);
            $table->double('tax')->default(0);
            $table->double('view')->default(0);
            $table->bigInteger('sold_count')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->integer('admin_id')->nullable();
            $table->string('guard_name')->nullable();
            $table->double('online_service_price')->default(0);
            $table->bigInteger('delivery_days')->default(0);
            $table->bigInteger('revision')->default(0);
            $table->tinyInteger('is_service_all_cities')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
