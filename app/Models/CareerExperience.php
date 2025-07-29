<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerExperience extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'career_experiences';

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'start_date',
        'end_date',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
