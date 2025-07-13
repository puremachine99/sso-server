<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClientSecret extends Model
{
    protected $table = 'oauth_client_secrets';
    protected $primaryKey = 'client_id';
    public $incrementing = false;

    protected $fillable = [
        'client_id',
        'secret',
        'icon_path',
    ];

    protected $casts = [
        'client_id' => 'string',
    ];

    public function client()
    {
        return $this->belongsTo(\Laravel\Passport\Client::class, 'client_id');
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon_path
            ? asset('storage/' . $this->icon_path)
            : null;
    }

    protected static function booted()
    {
        static::deleting(function (ClientSecret $secret) {
            if ($secret->icon_path && Storage::disk('public')->exists($secret->icon_path)) {
                Storage::disk('public')->delete($secret->icon_path);
            }
        });
    }
}
