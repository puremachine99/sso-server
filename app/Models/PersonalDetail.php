<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'personal_details';

    protected $fillable = [
        'user_id',
        'ktp',
        'npwp',
        'address',
        'city',
        'province',
        'zip_code'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
