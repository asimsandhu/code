<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginDetail extends Model
{
    use HasFactory;

    protected $table = 'login_details';
    protected $primaryKey = 'session_id';
    protected $fillable = ['user_id','login_dt','logout_dt','session_id','total_time'];

    public function users()
    {
        return $this->hasOne('App\Models\User');

    }

}
