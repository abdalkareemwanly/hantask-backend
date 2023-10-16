<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdditional extends Model
{
    use HasFactory;
    protected $table = 'order_additionals';
    protected $guarded = [];
}
