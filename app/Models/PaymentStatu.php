<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatu extends Model
{
    use HasFactory;
    protected $table = 'payment_status';
    protected $guarded = [];
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
