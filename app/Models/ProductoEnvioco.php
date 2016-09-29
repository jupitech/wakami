<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoEnvioco extends Model
{
         //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto_envioco';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_orden','id_producto','precio_producto','cantidad','subtotal','estado_producto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    
     public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto');
    }
       public function PendienteProducto(){
        return $this->hasOne('\App\Models\PendientePenvio','id_proenvio','id');
    }
}
