<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
      //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ajuste_inventario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_producto','id_user','stock_anterior','stock_actual','stock_restante','tipo_stock','justificacion','id_sucursal','id_consignacion','created_at'];

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
     public function Sucursal(){
        return $this->hasOne('\App\Models\Sucursales','id','id_sucursal');
    }
     public function Consignacion(){
        return $this->hasOne('\App\Models\Consignacion','id','id_consignacion')->with("InfoCliente");
    }
}
