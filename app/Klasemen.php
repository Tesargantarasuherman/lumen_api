<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Klasemen extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tim','poin','id_turnamen'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function turnamen()
    {
        return $this->belongsTo('App\Turnamen', 'id_turnamen', 'id');
    }
    public function tim()
    {
        return $this->belongsTo('App\Tim', 'id_tim', 'id');
    }

}
