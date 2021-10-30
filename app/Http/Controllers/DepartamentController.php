<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departament;

class DepartamentController extends Controller
{
    public function index()
   {
    $departaments=\DB::table('departaments AS d1')
    ->join('departaments AS d2','d2.id','=','d1.father_departament_id')
    
->get();

       dd($departaments);
       return view('admin.departaments.index')->with(compact('departaments'));
   }
   public function store(Request $request )
   {
       $rules = [
           'name'=>'required|max:25|min:3|unique:departaments',
           
       ];
       $messages= [
        'name.required'=>'No se ha ingresado un nombre',
        'name.max'=>'El nombre de departamento no puede tener mas de 25 caracteres',
        'name.min'=>'El nombre de departamento no puede tener menos de 3 caracteres',
        'name.unique'=>'El nombre que ha elejido ya esta en uso',
       ];
       $this->validate($request, $rules, $messages);
       $departaments= new Departament();
       $departaments->name= $request->input('name');
       $departaments->father_departament_id= $request->input('padre');
       $departaments->save();

       return back()->with('notification','El departamento ha sido registrado exitosamente');
   }
}
