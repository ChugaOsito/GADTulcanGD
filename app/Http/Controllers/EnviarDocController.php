<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Folder;
use App\Models\Annex;
use App\Models\Transaction;
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
        //Enviando datos a la base tabla documento
        $doc =new Document();
        $doc->name= $request->input('nombre');
        $doc->path= $rutapdf;
        
        $doc->save();
        //Fin Enviando datos a tabla de documento
        //Inicio Enviar datos a la tabla de transaccion
        //Emisor
        $transaccion= new Transaction();
        $transaccion->user_id= auth()->user()->id;
        $transaccion->document_id=$doc->id;
        $transaccion->type="E";
        $transaccion->save();
        //Receptor
        $transaccion= new Transaction();
        $transaccion->user_id= $request->input('receptor'); ;
        $transaccion->document_id=$doc->id;
        $transaccion->type="R";
        $transaccion->save();
        //Fin enviar datos tabla de transaccion
        $activador=1;
        $docSubido=$doc->id;
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido])->with (compact('activador'));
    }

    public function MostrarDocumentos($id){

       

        $documents= \DB::table('documents')->where('folder_id', '=', $id)->get();
        $folders= \DB::table('folders')->where('father_folder_id', '=', $id)->get();
        
        return view('Documentos')->with(compact('documents'))->with(compact('folders'));

    }
    public function BandejaSalida(){
        /*
         $usuarios= \DB::table('users')->join('llamadas','users.id','=','llamadas.user_id')
        ->select('users.id AS cedula','users.name','llamadas.*')-> get();
        */
        $documents=\DB::table('documents')->join('transactions','documents.id','=','transactions.document_id')
        ->where('transactions.user_id', '=', Auth::user()->id)
        ->where('transactions.type', '=', "E")
        ->get();
        
    
        return view('Documentos')->with(compact('documents'));

    }
    public function BandejaEntrada(){
        /*
         $usuarios= \DB::table('users')->join('llamadas','users.id','=','llamadas.user_id')
        ->select('users.id AS cedula','users.name','llamadas.*')-> get();
        */
        $documents=\DB::table('documents')->join('transactions','documents.id','=','transactions.document_id')
        ->where('transactions.user_id', '=', Auth::user()->id)
        ->where('transactions.type', '=', "R")
        ->get();
        
    
        return view('Documentos')->with(compact('documents'));

    }
    public function VisualizarDocumento($id){

        $documento= document::find($id);
        $pathToFile=$documento->path;
        return response()->file($pathToFile);
    }
    
    public function EditorTexto(){

       return view('Documents.EditorTexto');
    }
    public function DocHtml(Request $request){
        $PDF=$request->input('exportar');
        dd($PDF);
        return view('Documents.EditorTexto');
     }
//Carpeta
     public function FormularioCarpeta($id){
        $folders=Folder::all();

        $identificador= $id;
        return  view('Documents.Folder')->with (compact('folders'))->with (compact('identificador'));
    }

    public function VincularCarpeta($id, Request $request){
        $document=Document::find($id);
        $document->folder_id=$request->input('carpeta');
        $document->save();
        $identificador=$id;
        return redirect()->route('Anexos', ['id' => $identificador]);
    }

    //Anexos

    public function FormularioAnexos($id){
        $annexes= \DB::table('annexes')->where('document_id', '=', $id)->get();

        $usuario= \DB::table('users')->join('transactions','users.id','=','transactions.user_id')
        ->where('document_id', '=', $id)
        ->where('type', '=', 'E')->first();
        return  view('annexes.index')->with (compact('annexes'))->with (compact('usuario'));
    }

    public function Anexos($id, Request $request){
       
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
                    //Enviando datos a la base tabla documento
                    $annex =new Annex();
                    $annex->name= $request->input('nombre');
                    $annex->path= $rutapdf;
                    $annex->document_id= $id;
                    $annex->save();

                    return redirect()->route('Anexos', ['id' => $id]);
    }

    public function VisualizarAnexo($id){

        $anexo= Annex::find($id);
        $pathToFile=$anexo->path;
        return response()->file($pathToFile);
    }

}
