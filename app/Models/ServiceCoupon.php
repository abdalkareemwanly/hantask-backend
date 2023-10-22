<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCoupon extends Model
{
    use HasFactory;
    protected $table = 'service_coupons';
    protected $fillable = [];
}
