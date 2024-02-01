<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function images()
    {
        return $this->hasMany(ImagePost::class,'post_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function postApprovs()
    {
        return $this->hasMany(PostApprov::class,'post_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }
    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class,'childCategory_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function city()
    {
        return $this->belongsTo(ServiceCity::class,'city_id');
    }
    public function view()
    {
        return $this->hasMany(View::class,'post_id');
    }
}
