<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    use HasFactory;
    protected $table = 'mail_contents';
    protected $fillable = [
        'mail_subject',
        'mail_body',
        'mail_files',
        'user_id',
    ];

    protected $casts = [
        'mail_files' => 'array',
    ];
}
