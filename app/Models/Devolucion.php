<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
        //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'devolucion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desde_sucursal','desde_user','hacia','fecha_entrega','descripcion','estado_devolucion','desde_consignacion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];


    public function DSucursal(){
        return $this->hasOne('App\Models\Sucursales','id','desde_sucursal');
    }

     public function DConsignacion(){
        return $this->hasOne('App\Models\Consignacion','id','desde_consignacion')->with("InfoCliente");
    }

      public function DUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','desde_user');
    }
}
