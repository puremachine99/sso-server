<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'certifications';

    protected $fillable = [
        'user_id',
        'certificate_name',
        'issuer',
        'issue_date',
        'expire_date'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
