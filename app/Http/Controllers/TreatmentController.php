<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;

class TreatmentController extends Controller
{
    //
    public function index()
    {
     $treatments=Treatment::withTrashed()->get();
 
        
        return view('Treatments.index')->with(compact('treatments'));
    }
    public function store(Request $request )
    {
        $rules = [
            'name'=>'required|max:25|min:2|unique:treatments',
            'abbreviation'=>'required|max:25|min:1'
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un tratamiento o titulo',
         'name.max'=>'El texto no puede tener mas de 25 caracteres',
         'name.min'=>'El texto  no puede tener menos de 2 caracteres',
         'name.unique'=>'El trato o titulo elejido ya esta en uso',

         'abbreviation.required'=>'No se ha ingresado una abreviacion',
         'abbreviation.max'=>'El texto no puede tener mas de 25 caracteres',
         'abbreviation.min'=>'El texto  no puede tener menos de 1 caracteres',
         
        ];
        $this->validate($request, $rules, $messages);
        $treatments= new Treatment();
        $treatments->name= $request->input('name');
        $treatments->abbreviation= strtoupper($request->input('abbreviation'));
        $treatments->save();
       
 
        return back()->with('notification','La informacion se ha registrado exitosamente');
    }
    public function edit($id)
    {
        
        $treatment=Treatment::find($id);
        
        return view('Treatments.edit')->with(compact('treatment'));
    }
    public function update($id, Request $request)
    {
        $treatments= Treatment::find($id);
        $rules = [
            'name'=>'required|max:25|min:2|unique:treatments,name,'.$treatments->id,
            'abbreviation'=>'required|max:25|min:1'
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un tratamiento o titulo',
         'name.max'=>'El texto no puede tener mas de 25 caracteres',
         'name.min'=>'El texto  no puede tener menos de 2 caracteres',
         'name.unique'=>'El trato o titulo elejido ya esta en uso',

         'abbreviation.required'=>'No se ha ingresado una abreviacion',
         'abbreviation.max'=>'El texto no puede tener mas de 25 caracteres',
         'abbreviation.min'=>'El texto  no puede tener menos de 1 caracteres',
         
        ];
     $this->validate($request, $rules, $messages);
     $treatments= Treatment::find($id);
        $treatments->name= $request->input('name');
        $treatments->abbreviation= strtoupper($request->input('abbreviation'));
        $treatments->save();
        
     return back()->with('notification','La informacion ha sido modificado exitosamente');
    }
    public function delete($id){
        $treatment =Treatment::find($id);
        $treatment->delete();
        return back()->with('notification','La informacion ha sido dado de baja exitosamente');
           }
           public function restore($id){
            $treatment =Treatment::onlyTrashed()->findOrFail($id);
            $treatment->restore();
            return back()->with('notification','La informacion ha sido restaurado exitosamente');
               }
}
