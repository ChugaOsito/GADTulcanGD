<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Departament;

class FolderController extends Controller
{
    public function index()
    {

        $folders=\DB::table('folders AS d1')
    ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')->orderBy('updated_at','DESC')
->get();

//     $folders=Folder::all();
    $departaments=Departament::all();
        return view('admin.folders.index')->with(compact('folders'))->with(compact('departaments'));
    }
    public function store(Request $request )
    {
        $rules = [
            'name'=>'required|max:75|min:3',
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un nombre',
         'name.max'=>'El nombre de carpeta no puede tener mas de 75 caracteres',
         'name.min'=>'El nombre de carpeta no puede tener menos de 3 caracteres',
         
        ];
        $this->validate($request, $rules, $messages);
        $folders= new Folder();
        $folders->name= $request->input('name');
        $folders->departament_id= $request->input('departament');
        $folders->father_folder_id= $request->input('padre');
        $folders->save();
 
        return back()->with('notification','La carpeta ha sido registrado exitosamente');
    }
    public function edit($id)
    {
        $folder=Folder::find($id);
        $departaments=Departament::all();
        $father_folders=Folder::all();
        return view('admin.folders.edit')->with(compact('folder'))->with(compact('departaments'))->with(compact('father_folders'));
    }
    public function update($id, Request $request)
    {
        $rules = [
            'name'=>'required|max:75|min:3',
            
        ];
        $messages= [
         'name.required'=>'No se ha ingresado un nombre',
         'name.max'=>'El nombre de carpeta no puede tener mas de 75 caracteres',
         'name.min'=>'El nombre de carpeta no puede tener menos de 3 caracteres',
         
        ];
        $this->validate($request, $rules, $messages);
        $folders=  Folder::find($id);
        $folders->name= $request->input('name');
        $folders->departament_id= $request->input('departament');
        $folders->father_folder_id= $request->input('padre');
        $folders->save();
        
     return back()->with('notification','La carpeta ha sido modificado exitosamente');
    }

}
