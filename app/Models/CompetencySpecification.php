<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetencySpecification extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'competency_specifications';

    protected $fillable = [
        'user_id',
        'competency_name',
        'level',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
