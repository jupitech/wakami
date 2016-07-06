<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
     use HasRoleAndPermission;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
     
      public function PerfilUsuario(){
        return $this->hasOne('App\Models\UserProfile','user_id','id');
    }
     public function getUserProfile(){
        return \App\Models\UserProfile::where('user_id',$this->id)->first();
    }
     
     public function RolUsuario(){
        return $this->hasOne('\App\Models\RoleUser','user_id','id')->with("ElRol");
    }
    public function getRolNombre(){
        return \App\Models\Roles::where('id',$this->RolUsuario->role_id)->first()->name;
    }
}
