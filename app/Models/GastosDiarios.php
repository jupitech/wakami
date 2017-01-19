<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastosDiarios extends Model
{
       //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gastos_diarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cierre','descripcion','referencia','gasto', 'created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
       protected $hidden = ['updated_at'];
}
