<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFiles extends Model
{
    use HasFactory;
    protected $table = 'user_files';
    protected $fillable = ['file_name', 'user_id'];
}
