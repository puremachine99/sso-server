<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetHcpm extends Model
{
    protected $table = 'password_resets_hcpm';

    protected $fillable = [
        'email',
        'token_hash',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];
}
