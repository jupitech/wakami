<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoDeposito extends Model
{
        //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'saldo_deposito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_sucursal','id_user', 'id_saldo', 'monto','montosis','numero','descripcion','banco','fecha_deposito','estado_deposito'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
        protected $hidden = ['created_at','updated_at'];

    public function Sucursal(){
        return $this->hasOne('\App\Models\Sucursales','id','id_sucursal');
    }
    
    public function Saldo(){
        return $this->hasOne('\App\Models\SaldoActual','id','id_saldo');
    }
}
