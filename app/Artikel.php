<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Artikel extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_penulis','judul','deskripsi','id_kategori'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function pengguna(){ 
        return $this->hasOne('App\User','id', 'id_penulis'); 
    }

}
