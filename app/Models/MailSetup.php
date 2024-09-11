<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetup extends Model
{
    use HasFactory;
    protected $table = 'mailsetup';
    protected $fillable = [
        'mail_transport',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from',
        'mail_sender_name',
        'other_links',
        'user_id',
    ];

    protected $casts = [
        'other_links' => 'array'
    ];
}
