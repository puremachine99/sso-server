<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'emergency_details';

    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'phone',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
