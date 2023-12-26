<?php

use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Country;
use App\Models\ServiceCity;
use App\Models\Subcategory;
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
        Schema::create('buyer_jobs', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->foreignIdFor(Category::class,'category_id');
            $table->foreignIdFor(Subcategory::class,'subcategory_id');
            $table->foreignIdFor(ChildCategory::class,'child_category_id');
            $table->foreignIdFor(User::class,'buyer_id');
            $table->foreignIdFor(Country::class,'country_id');
            $table->foreignIdFor(ServiceCity::class,'city_id');
            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->string('image');
            $table->string('status')->default(0);
            $table->string('is_job_on')->default(1);
            $table->string('is_job_online')->default(0);
            $table->double('price')->default(0);
            $table->bigInteger('view')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_jobs');
    }
};
