<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginLog extends Model
{
    use HasFactory;

    protected $table = 'login_logs'; // Optional kalau default

    protected $fillable = [
        'user_id',
        'email',
        'app_code',
        'ip_address',
        'user_agent',
        'logged_in_at',
        'login_type',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
    ];

    // Optional: casting ke lowercase / uppercase otomatis
    // protected $attributes = [
    //     'app_code' => 'portal',
    //     'login_type' => 'sso',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(); // avoid null user
    }
}
