<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];
    public function subCategories()
    {
        return $this->hasMany(Subcategory::class,'category_id');
    }
    public function child_categories()
    {
        return $this->hasMany(ChildCategory::class,'category_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class,'category_id');
    }
}
