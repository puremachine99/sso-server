<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel\Concerns\HasAvatars;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
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
        'custom_fields',
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
            'custom_fields' => 'array',
        ];
    }
    protected static function booted(): void
    {
        static::saving(function ($user) {
            // Cek kalau password berubah (update/create)
            if ($user->isDirty('password')) {
                $plainPassword = $user->getOriginal('password') !== $user->password
                    ? $user->password
                    : null;

                if (
                    $plainPassword && (
                        strlen($plainPassword) < 8 ||
                        !preg_match('/[A-Z]/', $plainPassword) ||
                        !preg_match('/[0-9]/', $plainPassword)
                    )
                ) {
                    throw ValidationException::withMessages([
                        'password' => 'Password harus minimal 8 karakter, mengandung huruf besar dan angka.',
                    ]);
                }
            }
        });
    }
    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }

    // Ambil data user dari HCPM, asumsikan email sebagai kunci
    public function hcpm(): ?\App\Models\HcpmUser
    {
        return \App\Models\HcpmUser::with('jobDetail')
            ->where('email', $this->email)
            ->first();
    }

    public function syncHcpmStatus(): void
    {
        $hcpmUser = $this->hcpm();

        $status = $hcpmUser?->status ?? 'Unknown';

        if ($this->hcpm_status !== $status) {
            $this->hcpm_status = $status;
            $this->save();
        }
    }

}
