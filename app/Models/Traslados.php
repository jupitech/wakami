<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traslados extends Model
{
   
           //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'traslados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_producto','cantidad','desde_sucursal','desde_user','a_sucursal','a_user','fecha_entrega','descripcion','estado_traslado'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

    public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto');
    }

    public function DSucursal(){
        return $this->hasOne('App\Models\Sucursales','id','desde_sucursal');
    }

    public function HaSucursal(){
        return $this->hasOne('App\Models\Sucursales','id','a_sucursal');
    }

    public function DUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','desde_user');
    }

    public function HaUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','a_user');
    }


}
