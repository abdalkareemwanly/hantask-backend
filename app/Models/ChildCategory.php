<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;
    protected $table = 'child_categories';
    protected $guarded = [];
    public function child_categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function child_subcategories()
    {
        return $this->belongsTo(Subcategory::class,'sub_category_id');
    }
}
