<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'job_titles';

    protected $fillable = [
        'job_title', 'jenis_jabatan', // sesuai kolom yang kamu pakai
    ];

    public function users()
    {
        return $this->belongsToMany(HcpmUser::class, 'user_job_title', 'job_title_id', 'user_id')
            ->withTimestamps();
    }
}
