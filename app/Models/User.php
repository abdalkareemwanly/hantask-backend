<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'users';
    protected $guarded = [];
    public function services()
    {
        return $this->hasMany(Service::class,'seller_id');
    }
}
