<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProducto extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_producto','stock','fecha_traslado','bodega_actual','act_su','act_co','id_user','estado_producto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
