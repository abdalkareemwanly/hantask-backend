<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVerify extends Model
{
    use HasFactory;
    protected $table = 'profile_verifies';
    protected $guarded = [];
    public function professionalStatus()
    {
        return $this->belongsTo(ProfessionalStatus::class,'professional_status_id');
    }
    public function manyEmployee()
    {
        return $this->belongsTo(ManyEmployeess::class,'many_employee_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
