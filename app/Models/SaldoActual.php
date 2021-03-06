<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoActual extends Model
{
        //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'saldo_actual';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_sucursal','id_user', 'efectivo', 'fecha'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
        protected $hidden = ['created_at','updated_at'];

            public function Sucursal(){
        return $this->hasOne('\App\Models\Sucursales','id','id_sucursal');
    }

    public function Deposito(){
        return $this->hasMany('\App\Models\SaldoDeposito','id_saldo','id');
    }
}
