<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerJob extends Model
{
    use HasFactory;
    protected $table = 'buyer_jobs';
    protected $guarded = [];
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
        return $this->belongsTo(ChildCategory::class,'child_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function city()
    {
        return $this->belongsTo(ServiceCity::class,'city_id');
    }
}
