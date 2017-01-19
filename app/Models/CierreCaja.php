<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
      //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cierre_caja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_sucursal','id_user','saldo_efectivo','estado_caja','created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
      protected $hidden = ['updated_at'];
}
