<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerCycle extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'career_cycles';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'status',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
