<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use HasFactory,Notifiable;
    protected $connection='mysql2';
    protected $table ='sub_profile';
    protected $fillable=['cellno','sub_name','gender','first_call_dt','last_call_dt',
        'province','city','village','district','location_id','crop_id','category','location','age',
        'occupation','feedback','srvc_id','created_at','updated_at','updated_by'];
}
