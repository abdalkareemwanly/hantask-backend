<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }
    public function child_category()
    {
        return $this->belongsTo(ChildCategory::class,'child_category_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
    public function service_city()
    {
        return $this->belongsTo(ServiceCity::class,'service_city_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class,'service_id');
    }
}
