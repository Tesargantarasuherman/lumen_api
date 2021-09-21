<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Chat extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pengechat','isi_chat','id_yangdichat'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * 
     */
    public function tim()
    {
        return $this->belongsTo('App\Tim', 'id_tim', 'id');
    }


}
