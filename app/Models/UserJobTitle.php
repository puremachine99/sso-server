<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJobTitle extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'user_job_title';

    protected $fillable = ['user_id', 'job_title_id', 'jenis_jabatan'];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
