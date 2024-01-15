<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $guarded = [];
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
