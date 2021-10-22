<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
class EnviarDocController extends Controller
{
    

    
    public function getEnviar(){
        $users=User::all();


        return  view('Enviar')->with (compact('users'));
    }
    public function postEnviar(Request $request){

        $rules=[

'nombre'=> 'required|min:3',
'archivo'=> 'required|mimes:pdf'

        ];

        $messages=[
            'nombre.required'=>'No ha introducido un nombre para el archivo ',
            'nombre.min'=>'El nombre debe tener mas de 3 caracteres',
            'archivo.required'=>'No se ha se leccionado un archivo para subir',
            'archivo.mimes'=>'El archivo debe estar en formato PDF'

        ];
        $this->validate($request, $rules, $messages);

        //Obteniendo pdf
        $filepdf=$request->file("archivo");
        $nombrepdf="pdf_".time().".".$filepdf->guessExtension();
        $rutapdf=public_path("pdf/".$nombrepdf);
        copy($filepdf,$rutapdf);
        //Fin Obteniendo pdf 
        //Enviando datos a la base
        $doc =new Document();
        $doc->name= $request->input('nombre');
        $doc->path= $rutapdf;
        $doc->user_id= auth()->user()->id;
        $doc->save();
        //Fin Enviando datos a la base
        $activador=1;
        $docSubido=$doc->id;
       
        return  view('FirmaElectronica/Firmar')->with (compact('activador'))->with (compact('docSubido'));
    }

    public function MostrarDocumentos(){

        $documents= document::all();
        return view('Documentos')->with(compact('documents'));

    }
    public function BandejaSalida(){
        $usr=Auth::user()->id;
        
        $documents= document::where('user_id',$usr)->get();
        return view('Documentos')->with(compact('documents'));

    }
    public function VisualizarDocumento($id){

        $documento= document::find($id);
        $pathToFile=$documento->path;
        return response()->file($pathToFile);
    }
    
   
}
