<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcpmUser extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'permissions',
        'department_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
    ];

    protected $appends = ['status']; // supaya bisa diakses via ->status (juga di Filament column)

    // === Relasi detail info users ===
    public function smartnakamaProfile()
    {
        return $this->hasOne(SmartnakamaProfile::class, 'user_id');
    }

    public function jobDetail()
    {
        return $this->hasOne(JobDetail::class, 'user_id');
    }

    public function userJobTitles()
    {
        return $this->hasMany(UserJobTitle::class, 'user_id');
    }

    public function salaryDetails()
    {
        return $this->hasMany(SalaryDetail::class, 'user_id');
    }

    public function terminationDetails()
    {
        return $this->hasMany(TerminationDetail::class, 'user_id');
    }

    public function careerCycles()
    {
        return $this->hasMany(CareerCycle::class, 'user_id');
    }

    public function personalDetails()
    {
        return $this->hasMany(PersonalDetail::class, 'user_id');
    }

    public function contactDetails()
    {
        return $this->hasMany(ContactDetail::class, 'user_id');
    }

    public function emergencyDetails()
    {
        return $this->hasMany(EmergencyDetail::class, 'user_id');
    }

    public function educationBackgrounds()
    {
        return $this->hasMany(EducationBackground::class, 'user_id');
    }

    public function careerExperiences()
    {
        return $this->hasMany(CareerExperience::class, 'user_id');
    }

    public function competencySpecifications()
    {
        return $this->hasMany(CompetencySpecification::class, 'user_id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'user_id');
    }

    // === Relasi Umum ===
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function jobTitles()
    {
        return $this->belongsToMany(JobTitle::class, 'user_job_title', 'user_id', 'job_title_id')
            ->withTimestamps();
    }

    public function strukturalTitle()
    {
        return $this->jobTitles()
            ->where('jenis_jabatan', 'Struktural')
            ->limit(1);
    }

    public function fungsionalTitle()
    {
        return $this->jobTitles()
            ->where('jenis_jabatan', 'Fungsional')
            ->limit(1);
    }

    // === Status Aktif atau Tidak ===
    public function isActive(): bool
    {
        return $this->terminationDetails->isEmpty();
    }

    public function getStatusAttribute(): string
    {
        if ($this->terminationDetails->isEmpty()) {
            return 'Active';
        }

        $latest = $this->terminationDetails->sortByDesc('created_at')->first();

        return match (strtolower($latest->status)) {
            'on_leave' => 'On_Leave',
            'terminated' => 'Terminated',
            default => 'Terminated',
        };
    }
}
