<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class FolderController extends Controller
{
    public function index()
    {
     $folders=Folder::all();
        
        return view('admin.folders.index')->with(compact('folders'));
    }
    public function store(Request $request )
    {
        $rules = [
            'name'=>'required|max:25|min:3',
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un nombre',
         'name.max'=>'El nombre de carpeta no puede tener mas de 25 caracteres',
         'name.min'=>'El nombre de carpeta no puede tener menos de 3 caracteres',
         
        ];
        $this->validate($request, $rules, $messages);
        $folders= new Folder();
        $folders->name= $request->input('name');
        $folders->father_folder_id= $request->input('padre');
        $folders->save();
 
        return back()->with('notification','La carpeta ha sido registrado exitosamente');
    }
}
