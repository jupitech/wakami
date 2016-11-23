<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promociones extends Model
{
    
      //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promociones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','id_producto','id_linea','por_cantidad','porcentaje_producto','porcentaje_linea','tipo_promocion','fecha_inicio','fecha_fin','estado_promocion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

    public function NombreLinea(){
        return $this->hasOne('\App\Models\LineaProducto','id','id_linea');
    }

     public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto');
    }
}
