<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $connection = 'hcpm';
    protected $table = 'contact_details';

    protected $fillable = [
        'user_id',
        'phone',
        'email_alt',
        'linkedin',
        'telegram'
    ];

    public function user()
    {
        return $this->belongsTo(HcpmUser::class);
    }
}
