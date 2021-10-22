<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
   public function index()
   {
       $users= User::all();
       return view('admin.users.index')->with(compact('users'));
   }
   public function store(Request $request )
   {
       $rules = [
           'identification'=>'required|max:25|unique:users',
           'nombres'=>'required|max:255',
           'apellidos'=>'required|max:255',
           'email'=>'required|email|max:255|unique:users',
           'contrasena'=>'required|min:6',
           'rol'=>'in:0,1,2'
       ];
       $messages= [
        'identification.required'=>'No se ha ingresado una identification',
        'identification.max'=>'No se ha ingresado una identification valida',
        'identification.unique'=>'La identification ingresada ya existe ',
        'nombres.required'=>'No se han ingresado los nombres del usuario',
        'nombres.max'=>'No se ha ingresado un nombre valido',
        'apellidos.required'=>'No se han ingresado los apellidos del usuario',
        'apellidos.max'=>'No se ha ingresado apellidos validos',
        'email.required'=>'No se ha ingresado un correo electronico',
        'email.email'=>'No se ha ingresado un correo electronico valido',
        'email.max'=>'No se ha ingresado un correo electronico valido',
        'email.unique'=>'El correo electronico ingresado ya existe ',
        'contrasena.required'=>'No se ha ingresado una contraseña',
        'contrasena.min'=>'No se ha ingresado una contrasena valida',
        'rol.in'=>'No se ha ingresado un rol valido',
       ];
       $this->validate($request, $rules, $messages);
       $user= new User();
       $user->identification= $request->input('identification');
       $user->name =$request->input('nombres');
       $user->lastname =$request->input('apellidos');
       $user->email =$request->input('email');
       $user->password = bcrypt($request->input('contrasena'));
       $user->rol =$request->input('rol');
       $user->save();

       return back()->with('notification','El usuario ha sido registrado exitosamente');
   }
   public function edit($id)
   {
       $user= User::find($id);
       
       return view('admin.users.edit')->with(compact('user'));
   }
   public function update($id, Request $request)
   {
    $rules = [
        'identification'=>'required|max:25',
        'nombres'=>'required|max:255',
        'apellidos'=>'required|max:255',
        'email'=>'required|email|max:255',
        'contrasena'=>'nullable|min:6',
        'rol'=>'in:0,1,2'
    ];
    $messages= [
     'identification.required'=>'No se ha ingresado una identification',
     'identification.max'=>'No se ha ingresado una identification valida',
     'nombres.required'=>'No se han ingresado los nombres del usuario',
     'nombres.max'=>'No se ha ingresado un nombre valido',
     'apellidos.required'=>'No se han ingresado los apellidos del usuario',
     'apellidos.max'=>'No se ha ingresado apellidos validos',
     'email.required'=>'No se ha ingresado un correo electronico',
     'email.email'=>'No se ha ingresado un correo electronico valido',
     'email.max'=>'No se ha ingresado un correo electronico valido',
     
     'rol.in'=>'No se ha ingresado un rol valido',
    ];
    $this->validate($request, $rules, $messages);
    $user= User::find($id);
      
       $user->name =$request->input('nombres');
       $user->lastname =$request->input('apellidos');
      $pasword= $request->input('contrasena');
      if($pasword)
      {
        $user->password = bcrypt($pasword);
      }
       
       $user->rol =$request->input('rol');
       $user->save();
       
    return back()->with('notification','El usuario ha sido modificado exitosamente');
   }
}
