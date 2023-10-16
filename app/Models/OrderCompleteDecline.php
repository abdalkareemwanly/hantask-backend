<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCompleteDecline extends Model
{
    use HasFactory;
    protected $table = 'order_complete_declines';
    protected $guarded = [];


}

