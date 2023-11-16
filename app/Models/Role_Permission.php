<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_Permission extends Model
{
    use HasFactory;
    protected $table = 'role__permissions';
    protected $guarded = [];
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function permisision()
    {
        return $this->belongsTo(Permission::class,'permission_id');
    }
}
