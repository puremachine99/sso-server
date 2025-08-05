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
    public function hcpm()
    {
        return \App\Models\HcpmUser::where('email', $this->email)->first();
    }

    public function syncHcpmStatus(): void
    {
        // Ambil user HCPM dan pastikan relasi terminationDetails ikut dimuat
        $hcpmUser = \App\Models\HcpmUser::with('terminationDetails')
            ->where('email', $this->email)
            ->first();

        // Jika user ditemukan, ambil status dari accessor. Jika tidak, tandai Unknown
        $this->hcpm_status = $hcpmUser?->status ?? 'Unknown';

        // Simpan perubahan
        $this->save();
    }

}
