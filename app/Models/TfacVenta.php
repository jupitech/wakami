<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TfacVenta extends Model
{
            /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tfac_venta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ventas','tipo_factura'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
