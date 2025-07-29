<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'job_details';

    public function user()
    {
        return $this->belongsTo(HcpmUser::class, 'user_id');
    }
}
