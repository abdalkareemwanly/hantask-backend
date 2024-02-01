<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $guarded = [];
    public function coupons()
    {
        return $this->hasMany(ServiceCoupon::class,'plan_id');
    }
}
