<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierrePago extends Model
{
     //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cierre_pago';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cierre','id_tpago','monto_sis', 'monto_fisico', 'monto_diferencia', 'conversion', 'monto_fisicod'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    protected $hidden = ['created_at','updated_at'];
}
