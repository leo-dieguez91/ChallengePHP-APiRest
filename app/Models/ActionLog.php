<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = [
        'user_id',
        'service',
        'request_body',
        'response_code',
        'response_body',
        'ip_address'
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 