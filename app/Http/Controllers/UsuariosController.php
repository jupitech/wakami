<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Bican\Roles\Models\Role;
use App\User;
use App\Models\UserProfile;
use App\Models\RoleUser;
use App\Models\Roles;

class UsuariosController extends Controller
{

    public function __contruct(){
        $this->middleware('role:admin|operativo');
    }
  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('admin.configuracion.usuarios');
    }
    
       public function indexusuarios()
    {
           //Traendo partidos que no han sido terminados en este dia
         $usuarios=User::with("PerfilUsuario","RolUsuario")->get();
         if(!$usuarios){
             return response()->json(['mensaje' =>  'No se encuentran usuarios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $usuarios],200);
    }

        public function indexroles()
    {
           //Traendo partidos que no han sido terminados en este dia
         $roles=Roles::all();
         if(!$roles){
             return response()->json(['mensaje' =>  'No se encuentran roles actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $roles],200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=User::create([
                  'name' => $request['name'],
                  'email' => $request['email'],
                  'password' => bcrypt($request['password'])
                        ]);
          $user->save();

         $userprofile=UserProfile::create([
                  'user_id' => $user->id,
                  'nombre' => $request['nombre'],
                  'apellido' => $request['apellido'],
                  'activo' => 1,
                        ]);
         $userprofile->save();

           $roleuser=RoleUser::create([
                'role_id' =>$request['role_id'],
                'user_id' =>$user->id,
            ]);
          $roleuser->save();

          return response()->json(["mensaje"=>"Usuario creado correctamente."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
