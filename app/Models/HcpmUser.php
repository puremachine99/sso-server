<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class HcpmUser extends Authenticatable
{
    protected $connection = 'hcpm'; // <- koneksi ke database kedua
    protected $table = 'users';     // <- nama tabel di hcpm

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'permissions',
        'department_id',
    ];
}