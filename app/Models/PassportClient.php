<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client;
class PassportClient extends Client
{
    protected $fillable = [
        'name',
        'redirect_uris',
        'grant_types',
        'revoked',
        'icon_path',
    ];

    protected $casts = [
        'grant_types' => 'array',
        'redirect_uris' => 'array',
        'revoked' => 'boolean',
    ];
}
