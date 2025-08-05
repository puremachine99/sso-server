<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel\Concerns\HasAvatars;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasAvatar
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, HasAvatars;

    protected $fillable = [
        'name',
        'email',
        'password',
        'source',
        'avatar_url',
        'hcpm_status', // pastikan ini ada di DB dan $fillable
    ];
    protected $with = ['terminationDetails'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }

    // Ambil data user dari HCPM, asumsikan email sebagai kunci
    public function hcpm(): ?\App\Models\HcpmUser
    {
        return \App\Models\HcpmUser::with('terminationDetails')
            ->where('email', $this->email)
            ->first();
    }

    public function syncHcpmStatus(): void
    {
        $hcpmUser = \App\Models\HcpmUser::with('terminationDetails')
            ->where('email', $this->email)
            ->first();

        $status = $hcpmUser?->status ?? 'Unknown';

        if ($this->hcpm_status !== $status) {
            $this->hcpm_status = $status;
            $this->save();
        }
    }


}
