<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManyEmployeess extends Model
{
    use HasFactory;
    protected $table = 'many_employeesses';
    protected $guarded = [];
    public function profileVerify()
    {
        return $this->hasMany(ProfileVerify::class,'many_employee_id');
    }
}
