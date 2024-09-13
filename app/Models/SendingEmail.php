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
        'mail_form',
        'mail_content_id',
        'wait_minute',
        'user_id',
    ];

    /**
     * The roles that belong to the SendingEmail
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function mail_content()
    {
        return $this->hasMany(MailContent::class, 'id', 'mail_content_id');
    }


}
