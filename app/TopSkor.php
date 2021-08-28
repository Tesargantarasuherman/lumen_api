<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class TopSkor extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pemain','nama_tim','jumlah_gol','id_turnamen'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * 
     */
    public function pertandingan()
    {
        return $this->belongsTo('App\Pertandingan', 'id_pertandingan', 'id');
    }
    public function pemain()
    {
        return $this->belongsTo('App\Tim', 'id_pertandingan', 'id');
    }

}