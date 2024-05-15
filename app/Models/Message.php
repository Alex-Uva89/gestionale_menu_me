<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'attachment',
        'is_read',
        'read_at',
        'sent_at',
        'received_at',
        'deleted_at',
    ];
}
