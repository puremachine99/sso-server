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
    public function getJobTitlesStrukturalAttribute(): ?string
    {
        return $this->jobTitles
            ->firstWhere('jenis_jabatan', 'Struktural')
                ?->nama_jabatan;
    }

    public function getJobTitlesFungsionalAttribute(): ?string
    {
        return $this->jobTitles
            ->firstWhere('jenis_jabatan', 'Fungsional')
                ?->nama_jabatan;
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
    public function jobTitles()
    {
        return $this->setConnection('hcpm') // koneksi lintas DB
            ->belongsToMany(
                \App\Models\JobTitle::class,
                'user_job_title', // nama pivot
                'user_id',
                'job_title_id'
            )
            ->withPivot(['jenis_jabatan']) // opsional
            ->withTimestamps();
    }
}
