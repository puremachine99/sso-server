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
}
