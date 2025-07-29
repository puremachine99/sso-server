<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'salary_details';

    protected $fillable = [
        'user_id',
        'base_salary',
        'bonus',
        'deduction',
        'effective_date'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
