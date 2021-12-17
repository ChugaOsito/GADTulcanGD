<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    //
    
    public function index()
   {
    $types=Type::withTrashed()->get();

       
       return view('admin.type.index')->with(compact('types'));
   }
   public function store(Request $request )
   {
       $rules = [
           'name'=>'required|max:25|min:3|unique:types',
           
           
       ];
       $messages= [
        'name.required'=>'No se ha ingresado un tipo de documento',
        'name.max'=>'El tipo de documento no puede tener mas de 25 caracteres',
        'name.min'=>'El tipo de documento no puede tener menos de 3 caracteres',
        'name.unique'=>'El tipo de documento que ha elejido ya esta en uso',
       
       ];
       $this->validate($request, $rules, $messages);
       $types= new type();
       $types->name= $request->input('name');
      
       $types->save();

       return back()->with('notification','El tipo de documento ha sido registrado exitosamente');
   }
   public function edit($id)
   {
       
    $type= type::find($id);
       return view('admin.type.edit')->with(compact('type'));
   }
   public function update($id, Request $request)
   {
    $type= type::find($id);
    $rules = [
        'name'=>'required|max:25|min:3|unique:types,name,'.$type->id
        
    ];
    $messages= [
     'name.required'=>'No se ha ingresado un nombre',
     'name.max'=>'El tipo de documento no puede tener mas de 25 caracteres',
     'name.min'=>'El tipo de documento no puede tener menos de 3 caracteres',
     'name.unique'=>'El tipo de documento ya existe que ha elejido ya esta en uso',
    
    ];
    $this->validate($request, $rules, $messages);
    
      
    $type->name= $request->input('name');
      
    $type->save();
       
    return back()->with('notification','El tipo de documento ha sido modificado exitosamente');
   }
   public function delete($id){
    $type =Type::find($id);
    $type->delete();
    return back()->with('notification','La informacion ha sido dado de baja exitosamente');
       }
       public function restore($id){
        $type =Type::onlyTrashed()->findOrFail($id);
        $type->restore();
        return back()->with('notification','La informacion ha sido restaurado exitosamente');
           }
}
