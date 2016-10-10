<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
         //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ventas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serie_factura','correlativo','id_cliente','total','fecha_factura','id_sucursal','id_user','id_porcliente','estado_ventas','dte','cae'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

    public function PagoVenta(){
        return $this->hasOne('App\Models\TpagoVenta','id_ventas','id');
    }

      public function InfoClientes(){
        return $this->hasOne('App\Models\Clientes','id','id_cliente')->with("PorcentajeCliente");
    }

    public function FacVenta(){
        return $this->hasOne('App\Models\TfacVenta','id_ventas','id');
    }
        public function NombreSucursal(){
        return $this->hasOne('App\Models\Sucursales','id','id_sucursal');
    }
        public function PerfilUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','id_user');
    }
        public function DescuentosVentas(){
        return $this->hasOne('App\Models\DescuentosVentas','id_ventas','id');
    }
    public function ConsignacionVentas(){
        return $this->hasOne('App\Models\FacConsignacion','id_ventas','id');
    }
}
