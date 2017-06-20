<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
      //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cierre_caja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_sucursal','id_user','saldo_efectivo','estado_caja','total_saldo','justficacion','created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
      protected $hidden = ['updated_at'];

    public function Sucursal(){
        return $this->hasOne('\App\Models\Sucursales','id','id_sucursal');
    }

   public function PerfilUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','id_user');
    }

    public function CierrePago(){
        return $this->hasMany('App\Models\CierrePago','id_cierre','id');
    }

}
