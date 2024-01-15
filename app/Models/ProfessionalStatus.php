<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalStatus extends Model
{
    use HasFactory;
    protected $table = 'professional_statuses';
    protected $guarded = [];
    public function profileVerify()
    {
        return $this->hasMany(ProfileVerify::class,'professional_status_id');
    }
}
