<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaCredito extends Model
{
             /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alerta_credito';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_credito','fecha_credito','estado_alerta'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];

       public function Credito(){
        return $this->hasOne('App\Models\CreditosVentas','id','id_credito')->with("Ventas");
    }
}
