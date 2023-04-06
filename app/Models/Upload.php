<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_original_name', 'file_title', 'file_path', 'user_id', 'extension', 'type', 'file_size',
    ];
    
}
