<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PorcentajeCliente extends Model
{
       //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'porcentaje_cliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cliente','tipo_cliente','porcentaje'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
