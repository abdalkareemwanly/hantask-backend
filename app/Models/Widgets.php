<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    use HasFactory;
    protected $table = 'widgets';
    protected $guarded = [];
}
