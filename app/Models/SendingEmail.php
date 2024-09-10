<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendingEmail extends Model
{
    use HasFactory;
    protected $table = 'sending_emails';
    protected $fillable = [
        'mails',
        'send_time',
        'status',
        'mail_content_id',
        'user_id',
    ];
}
