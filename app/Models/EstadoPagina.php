<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPagina extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'estado_pagina';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','nombre','estado'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
