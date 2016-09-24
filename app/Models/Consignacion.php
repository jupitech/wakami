<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignacion extends Model
{
    
           //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consignacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cliente','estado_consignacion','created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];


    public function InfoCliente(){
        return $this->hasOne('App\Models\Clientes','id','id_cliente');
    }
}
