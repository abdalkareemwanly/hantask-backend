<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeleted extends Model
{
    use HasFactory;
    protected $table = 'user_deleted';
    protected $guarded = [];
}
