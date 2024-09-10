<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailDelivaryDetail extends Model
{
    use HasFactory;
    protected $table = 'mail_delivary_details';
    protected $fillable = [
        'sender',
        'receiver',
        'status',
        'user_id',
    ];
}
