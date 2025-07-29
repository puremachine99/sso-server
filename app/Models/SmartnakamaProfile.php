<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartnakamaProfile extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'smartnakama_profiles';

    protected $fillable = [
        'user_id',
        'nip',
        'nik',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'marital_status',
        'blood_type',
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
