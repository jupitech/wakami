<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
               //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto_venta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ventas','id_producto','cantidad','precio_producto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

    public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto')->with("StockProducto");
    }
    public function Venta(){
        return $this->hasOne('\App\Models\Ventas','id','id_ventas')->with("DescuentosVentas","PromocionesVentas");
    }
}
