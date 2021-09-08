<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Comentars extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_artikel','id_user','isi'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * 
     */
    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'id_artikel', 'id');
    }
    public function pengguna()
    {
        return $this->belongsTo('App\User','id_user','provider_id');
    }


}
