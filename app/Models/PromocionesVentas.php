<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocionesVentas extends Model
{
     //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promociones_ventas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ventas','id_producto','id_linea','promocion','id_promocion','created_at','estado_promocion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

    public function Ventas(){
        return $this->hasOne('\App\Models\Ventas','id','id_ventas');
    }

     public function NombrePromocion(){
        return $this->hasOne('\App\Models\Promociones','id','id_promocion');
    }

    public function NombreLinea(){
        return $this->hasOne('\App\Models\LineaProducto','id','id_linea');
    }

     public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto');
    }
}
