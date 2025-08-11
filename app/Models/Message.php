<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'body',
        'direction',
        'twilio_sid',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];
}
