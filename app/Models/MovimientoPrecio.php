<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoPrecio extends Model
{
          //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'movimiento_precio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_user','id_producto','precio_anterior','precio_actual','created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];
    
     public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto');
    }
     public function NombreUsuario(){
        return $this->hasOne('\App\Models\UserProfile','user_id','id_user');
    }
     
}
