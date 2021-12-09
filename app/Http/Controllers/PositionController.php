<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    //
    public function index()
    {
     $positions=Position::all();
 
        
        return view('positions.index')->with(compact('positions'));
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
        $positions->name= $request->input('name');
       
        $positions->save();
       
 
        return back()->with('notification','La informacion se ha registrado exitosamente');
    }
}
