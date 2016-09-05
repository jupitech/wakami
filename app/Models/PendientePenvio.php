<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendientePenvio extends Model
{
                  //  use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pendiente_penvio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_orden','id_orden','id_proenvio','id_producto','cantidad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
}
