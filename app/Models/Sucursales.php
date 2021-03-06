<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
           //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo_esta','nombre','ubicacion','id_user','id_user2','codigo_sat','serie','resolucion','fresolucion','codigo_satnce','serie_nce','resolucion_nce','fresolucion_nce','codigo_satnde','serie_nde','resolucion_nde','fresolucion_nde','telefono'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];


    public function PerfilUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','id_user');
    }

     public function PerfilUsuario2(){
        return $this->hasOne('App\Models\UserProfile','user_id','id_user2');
    }
}
