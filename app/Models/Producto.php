<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
        //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo','codigo_barra','linea','nombre','costo','preciop','imagen_id','id_proveedor'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

       public function NombreLinea(){
        return $this->hasOne('\App\Models\LineaProducto','id','linea');
    }
       public function NombreImagen(){
        return $this->hasOne('\App\Models\GaleriaImagen','id','imagen_id');
    }
      public function NombreProveedor(){
        return $this->hasOne('\App\Models\Proveedores','id','id_proveedor');
    }


    public function StockProducto(){
        return $this->hasOne('\App\Models\StockProducto','id_producto','id');
    }
}
