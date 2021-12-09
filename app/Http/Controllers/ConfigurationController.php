<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    //
    public function edit($id)
   {
       $config= Configuration::find($id);
       
       return view('admin.DocumentSize.edit')->with(compact('config'));
   }
   public function update($id, Request $request)
   {
    $rules = [
        'size'=>'required'
    ];
    $messages= [
     'size.required'=>'No ha ingresado un tamaño de subida'
     
    ];
    $this->validate($request, $rules, $messages);
    $configuration= Configuration::find($id);
      
       $configuration->document_size =$request->input('size');
      
       $configuration->save();
       
    return back()->with('notification','El tamaño se ha modificado exitosamente');
   }
}
