<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportChatMessage extends Model
{
    use HasFactory;
    protected $table = 'report_chat_messages';
    protected $guarded = [];
    
}
