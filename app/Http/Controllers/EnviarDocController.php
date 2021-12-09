<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Folder;
use App\Models\Departament;
use App\Models\Annex;
use App\Models\Transaction;
use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use PDF;
class EnviarDocController extends Controller
{
    

    
    public function getEnviar(){
      
        $id_departamento = Auth::user()->departament_id;
        
        $users=\DB::table('users')
        ->join('positions','positions.id','=','users.position_id')
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
        ->where('users.departament_id', '=', $id_departamento)->get();
        
        $departaments=\DB::table('departaments')->where('father_departament_id', '=', $id_departamento)->get();
        
        return  view('Enviar')->with (compact('users'))->with (compact('departaments'));
    }
    public function postEnviar(Request $request){
        $configuration=Configuration::find(1)->first();
        

        $rules=[

'nombre'=> 'required|min:3',
'archivo'=> 'required|mimes:pdf'.'|max:'.$configuration->document_size,
'receptor'=> 'required'

        ];
        

        $messages=[
            'nombre.required'=>'No ha introducido un nombre para el archivo ',
            'nombre.min'=>'El nombre debe tener mas de 3 caracteres',
            'archivo.required'=>'No se ha se leccionado un archivo para subir',
            'archivo.mimes'=>'El archivo debe estar en formato PDF',
            'receptor.required'=> 'Seleccione almenos un destinatario',
            'archivo.max'=>'El archivo no puede exeder los '.$configuration->document_size.' kb'

        ];
        $this->validate($request, $rules, $messages);
        $rutapdf=$this->SubirPdf($request->file("archivo"));
        $activador=1;
        //Registrar Documento y obtener su id
        $docSubido=$this->RegistrarEnvio($request->input('nombre'), $rutapdf, $request->input('receptor') );
       
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

   
if($this->Permiso($id)==true)
{
    return response()->file($pathToFile);
}
return ('Usted no tiene permitido visualizar este documento');
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
            'receptor'=> 'required'
                    ];
            
                    $messages=[
                        'objeto.required'=>'No ha introducido ningun objeto de documento ',
                        'cuerpo.required'=>'No ha introducido ningun cuerpo de documento ',
                        'nombre.required'=>'No ha introducido un nombre para el archivo ',
                        'nombre.min'=>'El nombre debe tener mas de 3 caracteres',
                        'receptor.required'=> 'Seleccione almenos un destinatario'
            
                    ];
                    $this->validate($request, $rules, $messages);
          
        $cuerpo=$request->input('cuerpo');
        $objeto=$request->input('objeto');
        
        $nombre = Auth::user()->name;
        $apellido = Auth::user()->lastname;
        
        $receptores_departamentos=$this->ObtenerDepartamentosReceptores($request->input('receptor'));
     
        $receptores=$this->ObtenerUsuariosReceptores($request->input('receptor'));
  
        //Inicio transformar Html a pdf
        if($receptores_departamentos==null){
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido]
                );

        }elseif ($receptores==null) {
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores_departamentos'=>$receptores_departamentos,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido]
                );
        }
        else {
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores_departamentos'=>$receptores_departamentos,'receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido]
                );
        }
       
    $output = $pdf->output();

    $nombrepdf="pdf_".time().".pdf";
        $rutapdf=public_path("pdf/".$nombrepdf);

    file_put_contents( "pdf/".$nombrepdf, $output);

        //Fin transformacion
      
        
        $activador=1;
        //Registrar Documento y obtener su id
        $docSubido= $this->RegistrarEnvio($request->input('nombre'), $rutapdf, $request->input('receptor') );
        
       
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
                    $rutapdf=$this->SubirPdf($request->file("archivo"));
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

       if($this->Permiso($anexo->document_id)==true)
{
    return response()->file($pathToFile);
}
return ('Usted no tiene permitido visualizar este documento');
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
        $rutapdf=$this->SubirPdf($request->file("archivo"));
       
        
        $activador=1;
        $docSubido=$this->RegistrarRespuesta($request->input('nombre'),$rutapdf,$process->process,$user->id);
       
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
    $activador=1;
    $docSubido=$this->RegistrarRespuesta($request->input('nombre'),$rutapdf,$process->process,$user->id);
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
             
        

      
        
        return view('Documentos')->with(compact('documents'));

    }


    






/////////////////////////////////////////////////////////////Inicio Funciones 
    //Inicio metodo permitir acceso a documentos
    function Permiso($id_Documento){

    
        $departamento= \DB::table('documents')
        ->join('folders','documents.folder_id','=','folders.id')
        ->join('departaments','folders.departament_id','=','departaments.id')
        ->where('documents.id','=',$id_Documento)
        ->first();

        $destinatario= \DB::table('documents')
        ->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.document_id','=',$id_Documento)
        ->where('document_user.user_id','=',Auth::user()->id)
        
        ->first();
    

        if(($departamento->departament_id ==Auth::user()->departament_id)  || ($destinatario !==  null) )
    {
    return true;
    }
    return false;
    }
    //Fin metodo permitir acceso a documentos

     //Inicio metodo para enviar documento 
     function RegistrarEnvio($nombreDocumento, $rutaDocumento, $Receptores){
        $doc =new Document();
        $doc->name= $nombreDocumento;
        $doc->path= $rutaDocumento;
        $Usuarios=$this->ObtenerUsuariosReceptores($Receptores);
        $Departamentos=$this->ObtenerDepartamentosReceptores($Receptores);
        
        $doc->save();
        if(isset($Usuarios))
        {
            foreach ($Usuarios as $Usuario ) {
                $doc->users()->attach($Usuario->id, ['type' => "R",'process' =>$doc->id ]);
            }
        }
        
        if(isset($Departamentos)){
            foreach ($Departamentos as $Departamento ) {
            
                $UsuariosDelpartamento=\DB::table('users')->where('departament_id', '=', $Departamento->id)->get();
                
                foreach ($UsuariosDelpartamento as $UsuarioDelpartamento) {
                    $doc->users()->attach($UsuarioDelpartamento->id, ['type' => "R",'process' =>$doc->id ]);  
                }
                
            }
        }
        
       
        $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$doc->id ]);
        return $doc->id;

     }
     function ObtenerUsuariosReceptores($id_receptores)
     {
        
         $i=0;
        foreach($id_receptores as $id_receptor){
            if($id_receptor>-1)
            {
                $receptores[$i]=\DB::table('users')->where('id', '=', $id_receptor)->first();
                $i++;
        
               
            }
           
            
     }
     
     if(isset($receptores)){
        return $receptores;
    }
    return null;
    }
    function ObtenerDepartamentosReceptores($id_receptores)
    {
        $i=0;
       foreach($id_receptores as $id_receptor){
           if($id_receptor<0)
           {
               $receptores[$i]=\DB::table('departaments')->where('id', '=', -$id_receptor)->first();
               $i++;
       
              
           }
          
    }
    if(isset($receptores)){
        return $receptores;
    }
    return null;
   }
     //Fin metodo para enviar documento

     //Inicio Funcion Subir Pdf
     function SubirPdf($archivo){
         
     $filepdf=$archivo;
     $nombrepdf="pdf_".time().".".$filepdf->guessExtension();
     $rutapdf=public_path("pdf/".$nombrepdf);
     copy($filepdf,$rutapdf);
     
        return $rutapdf;
     }
     
     //Fin Subir pdf 

     //Responder
     function RegistrarRespuesta($nombreDocumento, $rutaDocumento, $proceso, $UsuarioAresponder){
       
    $doc =new Document();
    $doc->name= $nombreDocumento;
    $doc->path= $rutaDocumento;
    
    
    $doc->save();
    $doc->users()->attach($UsuarioAresponder, ['type' => "R",'process' =>$proceso ]);
    $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$proceso ]);
    
    return $doc->id;

     }
     //Fin Responder
//Fin Funciones
}
