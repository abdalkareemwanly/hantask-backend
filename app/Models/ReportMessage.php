<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMessage extends Model
{
    use HasFactory;
    protected $table = 'report_messages';
    protected $guarded = [];
    public function report()
    {
        return $this->belongsTo(Report::class,'report_id');
    }
}
