<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockConsignacion extends Model
{
                //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_consignacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_consignacion','id_producto','stock','estado_producto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    
    public function NombreProducto(){
        return $this->hasOne('\App\Models\Producto','id','id_producto')->with("NombreLinea","NombreImagen");
    }
}
