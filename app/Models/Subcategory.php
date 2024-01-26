<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function child_categories()
    {
        return $this->hasMany(ChildCategory::class,'sub_category_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class,'subcategory_id');
    }
    public function buyerJobs()
    {
        return $this->hasMany(BuyerJob::class,'subcategory_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class,'subcategory_id');
    }
}
