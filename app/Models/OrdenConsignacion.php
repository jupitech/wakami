<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenConsignacion extends Model
{
                //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orden_consignacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_consignacion','id_user','fecha_entrega','total_compra','estado_orden','created_at','updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   

      public function NombreConsignacion(){
        return $this->hasOne('App\Models\Consignacion','id','id_consignacion')->with("InfoCliente");
    }
    
        public function PerfilUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','id_user');
    }
}
