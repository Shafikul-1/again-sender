<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'sender_company_logo',
        'sender_website',
        'sender_number',
        'user_id',
    ];

    protected $casts = [
        'other_links' => 'array'
    ];

    public function sending_emails()
    {
        return  $this->hasMany(SendingEmail::class, 'mailsetup_id', 'id')->where('user_id', Auth::user()->id);
    }
}
