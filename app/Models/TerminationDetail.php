<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerminationDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'termination_details';

    protected $fillable = [
        'user_id',
        'termination_type',
        'termination_date',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
