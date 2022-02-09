<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    //
    public function index()
    {
     $positions=Position::withTrashed()->get();
 
        
        return view('Positions.index')->with(compact('positions'));
    }
    public function store(Request $request )
    {
        $rules = [
            'name'=>'required|max:75|min:3|unique:treatments',
            
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un cargo',
         'name.max'=>'El texto no puede tener mas de 75 caracteres',
         'name.min'=>'El texto  no puede tener menos de 2 caracteres',
         'name.unique'=>'El cargo elejido ya esta en uso',

       
         
        ];
        $this->validate($request, $rules, $messages);
        $positions= new Position();
        $positions->name= strtoupper($request->input('name'));
       if ($request->has('representative')) {
        $positions->representative=1;
       }
        $positions->save();
       
 
        return back()->with('notification','La informacion se ha registrado exitosamente');
    }
    public function edit($id)
    {
        
        $positions=Position::find($id);
        
        return view('Positions.edit')->with(compact('positions'));
    }
    public function update($id, Request $request)
    {
        $rules = [
            'name'=>'required|max:75|min:3|unique:treatments',
            
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un cargo',
         'name.max'=>'El texto no puede tener mas de 75 caracteres',
         'name.min'=>'El texto  no puede tener menos de 2 caracteres',
         'name.unique'=>'El cargo elejido ya esta en uso',

       
         
        ];
        $this->validate($request, $rules, $messages);
        $position= Position::find($id);
        $position->name= strtoupper($request->input('name'));

        if ($request->has('representative')) {
            $position->representative=1;
           }else {
            $position->representative=0;
           }
        $position->save();
        
     return back()->with('notification','La informacion ha sido modificado exitosamente');
    }
    public function delete($id){
        $position =Position::find($id);
        $position->delete();
        return back()->with('notification','La informacion ha sido dado de baja exitosamente');
           }
           public function restore($id){
            $position =Position::onlyTrashed()->findOrFail($id);
            $position->restore();
            return back()->with('notification','La informacion ha sido restaurado exitosamente');
               }
}
