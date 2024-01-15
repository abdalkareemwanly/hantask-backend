<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $guarded = [];
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
    public function postApprove()
    {
        return $this->belongsTo(PostApprov::class,'postApprove_id');
    }
}
