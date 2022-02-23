<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Departament;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function index()
    {
        $carpetas = \DB::table('folders AS d1')
        ->where('d1.father_folder_id','=',1)
        ->where('d1.departament_id','=',Auth::user()->departament_id)
        ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
    ->orderBy('updated_at','DESC')
->get();


        $folders=\DB::table('folders AS d1')
   ->where('d1.departament_id','=',Auth::user()->departament_id)
        ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
    ->orderBy('updated_at','DESC')
->get();

//     $folders=Folder::all();
    $departaments=Departament::all();
        return view('admin.folders.index')->with(compact('folders'))
        ->with(compact('carpetas'))
        ->with(compact('departaments'));
    }
    public function store(Request $request )
    {
        $rules = ['name'=>'required|max:75|min:3', ];
        $messages= ['name.required'=>'No se ha ingresado un nombre',
         'name.max'=>'El nombre de carpeta no puede tener mas de 75 caracteres',
         'name.min'=>'El nombre de carpeta no puede tener menos de 3 caracteres', ];
        $this->validate($request, $rules, $messages);
        $folders= new Folder();
        $folders->name= $request->input('name');
        $folders->departament_id= Auth::user()->departament_id;
        if($request->input('padre')==null)
        {
            $folders->father_folder_id= 1;
        }else{
            $folders->father_folder_id= $request->input('padre');
        }
            $folders->save();
         return back()->with('notification','La carpeta ha sido registrado exitosamente');
    }
    public function edit($id)
    {
        $carpetas = \DB::table('folders AS d1')
        ->where('d1.father_folder_id','=',1)
        ->where('d1.departament_id','=',Auth::user()->departament_id)
        ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
    ->orderBy('updated_at','DESC')
->get();
        $folder=Folder::find($id);
        if($folder->departament_id!=Auth::user()->departament_id){
return('Usted no tiene permisos para realizar esta operacion');
        }
        $departaments=Departament::all();
        $father_folders=\DB::table('folders AS d1')
        ->where('d1.departament_id','=',Auth::user()->departament_id)->get();
        return view('admin.folders.edit')->with(compact('folder'))->with(compact('departaments'))
        ->with(compact('carpetas'))
        ->with(compact('father_folders'));
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
        
        $folders->father_folder_id= $request->input('padre');
        $folders->save();
        
     return back()->with('notification','La carpeta ha sido modificado exitosamente');
    }
    public function delete($id){
        $folder =Folder::find($id);
        if($folder->departament_id!=Auth::user()->departament_id){
            return('Usted no tiene permisos para realizar esta operacion');
                    }
        $folder->delete();
        return back()->with('notification','La carpeta ha sido dado de baja exitosamente');
           }
           public function restore($id){
            $folder =Folder::onlyTrashed()->findOrFail($id);
            $folder->restore();
            return back()->with('notification','La carpeta ha sido restaurado exitosamente');
               }

}
