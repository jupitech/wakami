<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEnvio extends Model
{
                //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orden_envio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_sucursal','id_user','fecha_entrega','total_compra','estado_orden','created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

      public function NombreSucursal(){
        return $this->hasOne('App\Models\Sucursales','id','id_sucursal');
    }

  
}
