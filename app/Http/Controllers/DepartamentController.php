<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departament;
use App\Models\Folder;
class DepartamentController extends Controller
{
    public function index()
   {
    $departaments=\DB::table('departaments AS d1')
    ->join('departaments AS d2','d2.id','=','d1.father_departament_id')
    ->select('d1.*', 'd2.name as father_departament')->orderBy('updated_at','DESC')
->get();

       
       return view('admin.departaments.index')->with(compact('departaments'));
   }
   public function store(Request $request )
   {
       $rules = [
           'name'=>'required|max:75|min:3|unique:departaments',
           'identifier'=>'required|max:10|min:1|unique:departaments'
           
       ];
       $messages= [
        'name.required'=>'No se ha ingresado un nombre',
        'name.max'=>'El nombre de departamento no puede tener mas de 75 caracteres',
        'name.min'=>'El nombre de departamento no puede tener menos de 3 caracteres',
        'name.unique'=>'El nombre que ha elejido ya esta en uso',
        'identifier.required'=>'No se ha ingresado un identificador',
        'identifier.max'=>'El identificador de departamento no puede tener mas de 10 caracteres',
        'identifier.min'=>'El identificador de departamento no puede tener menos de 1 caracteres',
        'identifier.unique'=>'El identificador que ha elejido ya esta en uso',
       ];
       $this->validate($request, $rules, $messages);
       $departaments= new Departament();
       $departaments->name= $request->input('name');
       $departaments->father_departament_id= $request->input('padre');
       $departaments->identifier= strtoupper($request->input('identifier'));
       $departaments->save();

    $folder= new Folder();
    $folder->name= 'Unidad de '.$request->input('name');
    $folder->father_folder_id= 1;
    $folder->departament_id= $departaments->id;
    $folder->save();       

       return back()->with('notification','El departamento ha sido registrado exitosamente');
   }
   public function edit($id)
   {
       
       $departament=Departament::find($id);
       $father_departaments=Departament::all();
       return view('admin.departaments.edit')->with(compact('departament'))->with(compact('father_departaments'));
   }
   public function update($id, Request $request)
   {
    $departament= Departament::find($id);
    $rules = [
        'name'=>'required|max:75|min:3|unique:departaments,name,'.$departament->id,
        'identifier'=>'required|max:10|min:1|unique:departaments,identifier,'.$departament->id
        
    ];
    $messages= [
     'name.required'=>'No se ha ingresado un nombre',
     'name.max'=>'El nombre de departamento no puede tener mas de 75 caracteres',
     'name.min'=>'El nombre de departamento no puede tener menos de 3 caracteres',
     'name.unique'=>'El nombre que ha elejido ya esta en uso',
     'identifier.required'=>'No se ha ingresado un identificador',
     'identifier.max'=>'El identificador de departamento no puede tener mas de 10 caracteres',
     'identifier.min'=>'El identificador de departamento no puede tener menos de 1 caracteres',
     'identifier.unique'=>'El identificador que ha elejido ya esta en uso',
    ];
    $this->validate($request, $rules, $messages);
   
      
    $departament->name= $request->input('name');
    $departament->father_departament_id= $request->input('padre');
    $departament->identifier=strtoupper($request->input('identifier'));
    $departament->save();
       
    return back()->with('notification','El departamento ha sido modificado exitosamente');
   }
   public function delete($id){
    $departament =Departament::find($id);
    $departament->delete();
    return back()->with('notification','El departamento ha sido dado de baja exitosamente');
       }
       public function restore($id){
        $departament =Departament::onlyTrashed()->findOrFail($id);
        $departament->restore();
        return back()->with('notification','El departamento ha sido restaurado exitosamente');
           }
}
