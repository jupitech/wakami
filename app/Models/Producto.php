<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
        //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo','linea','nombre','costo','preciop','imagen_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

       public function NombreLinea(){
        return $this->hasOne('\App\Models\LineaProducto','id','linea');
    }
       public function NombreImagen(){
        return $this->hasOne('\App\Models\GaleriaImagen','id','imagen_id');
    }
}
