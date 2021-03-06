<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacConsignacion extends Model
{
    
           //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fac_consignacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_consignacion','id_ventas','estado_factura'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

}
