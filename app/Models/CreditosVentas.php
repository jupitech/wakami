<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditosVentas extends Model
{
       //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'creditos_ventas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ventas','dias_credito','fecha_limite','estado_credito'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

        public function Ventas(){
        return $this->hasOne('App\Models\Ventas','id','id_ventas')->with("PagoVenta","InfoClientes","PerfilUsuario","DescuentosVentas","PromocionesVentas","NombreSucursal");
    }
}
