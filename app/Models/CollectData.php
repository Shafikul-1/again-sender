<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectData extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'allInfo' => 'array',
    ];
}
