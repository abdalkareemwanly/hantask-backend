<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $guarded = [];

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function reportMessage()
    {
        return $this->hasMany(ReportMessage::class,'report_id');
    }
}
