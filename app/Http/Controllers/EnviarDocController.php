<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Folder;
use App\Models\Departament;
use App\Models\Annex;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use PDF;
class EnviarDocController extends Controller
{
    

    
    public function getEnviar(){
        $id_departamento = Auth::user()->departament_id;
        
        $users=\DB::table('users')->where('departament_id', '=', $id_departamento)->get();
        
        $departaments=\DB::table('departaments')->where('father_departament_id', '=', $id_departamento)->get();
        
        return  view('Enviar')->with (compact('users'))->with (compact('departaments'));
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
        $doc->users()->attach($request->receptor, ['type' => "R",'process' =>$doc->id ]);
        $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$doc->id ]);
        //Fin Enviando datos a tabla de documento
        
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
        $documents=\DB::table('documents')->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('document_user.type', '=', "E")
        ->get();
        
    
        return view('Documentos')->with(compact('documents'));

    }
    public function BandejaEntrada(){
        /*
         $usuarios= \DB::table('users')->join('llamadas','users.id','=','llamadas.user_id')
        ->select('users.id AS cedula','users.name','llamadas.*')-> get();
        */
        $documents=\DB::table('documents')->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('document_user.type', '=', "R")
        ->get();
        
    
        return view('Documentos')->with(compact('documents'));

    }
    public function VisualizarDocumento($id){

        $documento= document::find($id);
        $pathToFile=$documento->path;
        return response()->file($pathToFile);
    }
    
    public function EditorTexto(){
        $id_departamento = Auth::user()->departament_id;
        
        $users=\DB::table('users')->where('departament_id', '=', $id_departamento)->get();
        
        $departaments=\DB::table('departaments')->where('father_departament_id', '=', $id_departamento)->get();
        
        return  view('Documents.EditorTexto')->with (compact('users'))->with (compact('departaments'));


       
    }
    public function DocHtml(Request $request){
        $rules=[

            'nombre'=> 'required|min:3',
            'cuerpo'=> 'required|min:3',
            'objeto'=> 'required|min:3',
                    ];
            
                    $messages=[
                        'objeto.required'=>'No ha introducido ningun objeto de documento ',
                        'cuerpo.required'=>'No ha introducido ningun cuerpo de documento ',
                        'nombre.required'=>'No ha introducido un nombre para el archivo ',
                        'nombre.min'=>'El nombre debe tener mas de 3 caracteres',
            
                    ];
                    $this->validate($request, $rules, $messages);
            
                    
        $id_receptores=$request->input('receptor');
        
        $cuerpo=$request->input('cuerpo');
        $objeto=$request->input('objeto');
        
        $nombre = Auth::user()->name;
        $apellido = Auth::user()->lastname;
        $i=0;
foreach($id_receptores as $id_receptor){
    $receptores[$i]=\DB::table('users')->where('id', '=', $id_receptor)->first();
    $i++;
}
        
        
        //Inicio transformar Html a pdf
        $pdf = PDF::loadView(
        'TextEditor.documento',
        ['receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido]
        );
    $output = $pdf->output();

    $nombrepdf="pdf_".time().".pdf";
        $rutapdf=public_path("pdf/".$nombrepdf);

    file_put_contents( "pdf/".$nombrepdf, $output);


       
        

        //Fin transformacion
        //Guardando en base de datos
                    
        
      
        
        //Enviando datos a la base tabla documento
        $doc =new Document();
        $doc->name= $request->input('nombre');
        $doc->path= $rutapdf;
        
        
        $doc->save();
        $doc->users()->attach($request->receptor, ['type' => "R",'process' =>$doc->id ]);
        $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$doc->id ]);
        //Fin Enviando datos a tabla de documento
        
        $activador=1;
        $docSubido=$doc->id;
        //Fin guardado en base de datos 
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido])->with (compact('activador'));

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

        $usuario= \DB::table('users')->join('document_user','users.id','=','document_user.user_id')
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
    //Inicio Responder
    public function getResponder($id){
        
        
        $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();
  
        
        return  view('Responder.Enviar')->with (compact('user'));
    }
    public function postResponder(Request $request, $id){
        $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();

        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();

        $rules=[


'archivo'=> 'required|mimes:pdf'

        ];

        $messages=[
           
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
        $doc->users()->attach($user->id, ['type' => "R",'process' =>$process->process ]);
        $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$process->process ]);
        //Fin Enviando datos a tabla de documento
        
        $activador=1;
        $docSubido=$doc->id;
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido])->with (compact('activador'));
    }
   //////////
   public function EditorTextoResponder($id){
    $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();
    
    return  view('Responder.EditorTexto')->with (compact('user'));


   
}
public function DocHtmlResponder(Request $request, $id){
    $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
    $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();

    $process=\DB::table('document_user')->where('document_id', '=', $id)->first();
    $rules=[

        'cuerpo'=> 'required|min:3',
        'objeto'=> 'required|min:3',
                ];
        
                $messages=[
                    'objeto.required'=>'No ha introducido ningun objeto de documento ',
                    'cuerpo.required'=>'No ha introducido ningun cuerpo de documento ',
                   
        
                ];
                $this->validate($request, $rules, $messages);
        
                
    $receptores[0]=$user;
    
    $cuerpo=$request->input('cuerpo');
    $objeto=$request->input('objeto');
    
    $nombre = Auth::user()->name;
    $apellido = Auth::user()->lastname;

   
    //Inicio transformar Html a pdf
    $pdf = PDF::loadView(
    'TextEditor.documento',
    ['receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido]
    );
$output = $pdf->output();

$nombrepdf="pdf_".time().".pdf";
    $rutapdf=public_path("pdf/".$nombrepdf);

file_put_contents( "pdf/".$nombrepdf, $output);


   
    

    //Fin transformacion
    //Guardando en base de datos
                
    
  
    
    //Enviando datos a la base tabla documento
    $doc =new Document();
    $doc->name= $request->input('nombre');
    $doc->path= $rutapdf;
    
    
    $doc->save();
    $doc->users()->attach($user->id, ['type' => "R",'process' =>$process->process ]);
    $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$process->process ]);
    //Fin Enviando datos a tabla de documento
    
    $activador=1;
    $docSubido=$doc->id;
    //Fin guardado en base de datos 
   
    return redirect()->route('FirmarDoc', ['id' => $docSubido])->with (compact('activador'));

 }

    //FinResponder
    public function Seguimiento($id){
        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();
        $id_documentos=\DB::table('document_user')->where('process', '=', $process->process)->get();

        $i=0;
        foreach($id_documentos as $id_documento){
            $documents[$i]=\DB::table('documents')->where('id', '=', $id_documento->document_id)->first();
            $i++;
        }
             
        

       // dd($documents);
        
        return view('Documentos')->with(compact('documents'));

    }
}
