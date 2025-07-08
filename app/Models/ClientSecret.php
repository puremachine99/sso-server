<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSecret extends Model
{
    protected $table = 'oauth_client_secrets';

    protected $primaryKey = 'client_id';

    public $incrementing = false;

    protected $fillable = ['client_id', 'secret'];
}
