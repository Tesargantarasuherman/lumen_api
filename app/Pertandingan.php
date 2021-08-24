<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Pertandingan extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_turnamen','klub_home','klub_away','waktu_pertandingan','skor_home','skor_away','tanggal_pertandingan'
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
    public function klubHome()
    {
        return $this->belongsTo('App\Klasemen','klub_home','id');
    }
    public function klubAway()
    {
        return $this->belongsTo('App\Klasemen','klub_away','id');
    }

}
