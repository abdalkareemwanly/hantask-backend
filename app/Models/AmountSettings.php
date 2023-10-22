<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountSettings extends Model
{
    use HasFactory;
    protected $table = 'amount_settings';
    protected $guarded = [];
}
