<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationBackground extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'education_backgrounds';

    protected $fillable = [
        'user_id',
        'institution',
        'major',
        'degree',
        'start_year',
        'end_year'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
