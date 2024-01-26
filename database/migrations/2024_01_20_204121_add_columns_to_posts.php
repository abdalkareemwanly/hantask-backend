<?php

use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Country;
use App\Models\ServiceCity;
use App\Models\Subcategory;
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
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignIdFor(Category::class,'category_id')->after('id');
            $table->foreignIdFor(Subcategory::class,'subcategory_id')->after('category_id');
            $table->foreignIdFor(ChildCategory::class,'childCategory_id')->after('subcategory_id');
            $table->foreignIdFor(Country::class,'country_id')->after('childCategory_id');
            $table->foreignIdFor(ServiceCity::class,'city_id')->after('country_id');
            $table->string('budget')->after('description');
            $table->string('dead_line')->after('budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
