<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription_coupon extends Model
{
    use HasFactory;
    protected $table = 'subscription_coupons';
    protected $guarded = [];
    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }
}
