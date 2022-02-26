<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Folder;
use App\Models\Departament;
use App\Models\Annex;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use PDF;
class EnviarDocController extends Controller
{
    

    
    public function getEnviar(){
      
        $MiDepartamento=Departament::find(Auth::user()->departament_id);
        
        $users=\DB::table('users')
        ->where('rol','>',-1)
        ->join('departaments','departaments.id','=','users.departament_id')
        ->join('positions','positions.id','=','users.position_id')
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'departaments.name as departament_name','positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
        ->where('users.departament_id', '=', $MiDepartamento->id)
        ->where('users.deleted_at', '=', NULL)
        ->get();
        
        
        $Child_departaments=\DB::table('departaments')->where('father_departament_id', '=', $MiDepartamento->id)->get();
        
        $Father_departament=\DB::table('departaments')->where('id', '=', $MiDepartamento->father_departament_id)->first();
        $Brother_departaments=\DB::table('departaments')->where('father_departament_id', '=', $MiDepartamento->father_departament_id)->get();
        $types= Type::all();
        return  view('Enviar')->with (compact('users'))
        ->with (compact('Father_departament'))
        ->with (compact('Brother_departaments'))
        ->with (compact('Child_departaments'))
        ->with (compact('types'))
        ->with (compact('MiDepartamento'));
    }
    public function postEnviar(Request $request){
        $configuration=Configuration::find(1)->first();
        

        $rules=[

'nombre'=> 'required|min:3',
'archivo'=> 'required|mimes:pdf'.'|max:'.$configuration->document_size,
'receptor'=> 'required',
'type'=> 'required|exists:types,id'
        ];
       $messages=[
            'nombre.required'=>'No ha introducido una descripcion para el archivo ',
            'nombre.min'=>'La descripcion debe tener mas de 3 caracteres',
            'archivo.required'=>'No se ha se leccionado un archivo para subir',
            'archivo.mimes'=>'El archivo debe estar en formato PDF',
            'receptor.required'=> 'Seleccione almenos un destinatario',
            'archivo.max'=>'El archivo no puede exeder los '.$configuration->document_size.' kb',
            'type.required'=>'Ingrese un tipo de documento'
        ];
        $this->validate($request, $rules, $messages);
        $rutapdf=$this->SubirPdf($request->file("archivo"));
       
        
        //Registrar Documento y obtener su id
        $docSubido=$this->RegistrarEnvio($request->input('nombre'), $rutapdf, $request
        ->input('receptor'),$request->input('type') );
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido]);
    }

    public function MostrarDocumentos($id){

        $sub_documents=\DB::table('documents')
        ->join('types','documents.type_id','=','types.id')
        ->where('documents.folder_id', '=', $id)
        ->select('documents.folder_id as folder_id','documents.created_at as created_at','documents.name','documents.id','documents.number as number','types.name as type')->orderBy('documents.updated_at','DESC')
        ->get();

       
        $i=0;
        
        foreach ($sub_documents as $sub_document) {
            if($this->Permiso($sub_document->id)==true){
                $documents[$i]=$sub_document;
                $i++;
            }
            
        }
        
        $folders= \DB::table('folders')->where('father_folder_id', '=', $id)->get();
        if(isset($documents))
        {
            return view('Documentos')->with(compact('documents'))->with(compact('folders'));
        }else {
            return view('Documentos')->with(compact('folders'));     
        }
       

    }
    public function BandejaSalida(){
        if(auth()->user()->rol == -1)
        return redirect()->route('Dashboard');
        /*
         $usuarios= \DB::table('users')->join('llamadas','users.id','=','llamadas.user_id')
        ->select('users.id AS cedula','users.name','llamadas.*')-> get();
        */
        $documents=\DB::table('documents')->join('document_user','documents.id','=','document_user.document_id')
        ->join('types','documents.type_id','=','types.id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('document_user.type', '=', "E")
        ->select('document_user.available as available',
        'documents.created_at as created_at','documents.name',
        'documents.id as document_id','documents.number as number',
        'types.name as type')->orderBy('documents.updated_at','DESC')
        ->get();
        
    
        return view('Documentos')->with(compact('documents'));

    }
    public function BandejaEntrada(){
        if(auth()->user()->rol == -1)
        return redirect()->route('Dashboard');
       
        /*
         $usuarios= \DB::table('users')->join('llamadas','users.id','=','llamadas.user_id')
        ->select('users.id AS cedula','users.name','llamadas.*')-> get();
        */
        $documents=\DB::table('documents')->join('document_user','documents.id','=','document_user.document_id')
        ->join('types','documents.type_id','=','types.id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('document_user.type', '=', "R")
        ->select('documents.read as read','documents.created_at as created_at',
        'documents.name','documents.id as document_id','documents.number as number',
        'types.name as type')->orderBy('documents.updated_at','DESC')
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
        $MiDepartamento=Departament::find(Auth::user()->departament_id);
        
        $users=\DB::table('users')
        ->where('rol','>',-1)
        ->join('departaments','departaments.id','=','users.departament_id')
        ->join('positions','positions.id','=','users.position_id')
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'departaments.name as departament_name','positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
        ->where('users.departament_id', '=', $MiDepartamento->id)
        ->where('users.deleted_at', '=', NULL)
        ->get();
        
        
        $Child_departaments=\DB::table('departaments')->where('father_departament_id', '=', $MiDepartamento->id)->get();
        
        $Father_departament=\DB::table('departaments')->where('id', '=', $MiDepartamento->father_departament_id)->first();
        $Brother_departaments=\DB::table('departaments')->where('father_departament_id', '=', $MiDepartamento->father_departament_id)->get();
        $types= Type::all();
        return  view('Documents.EditorTexto')->with (compact('users'))
        ->with (compact('Father_departament'))
        ->with (compact('Brother_departaments'))
        ->with (compact('Child_departaments'))
        ->with (compact('types'))
        ->with (compact('MiDepartamento'));
    }
    public function DocHtml(Request $request){
        $rules=[

            'nombre'=> 'required|min:3',
            'cuerpo'=> 'required|min:3',
            'objeto'=> 'required|min:3',
            'receptor'=> 'required',
            'type'=> 'required|exists:types,id'
                    ];
            
                    $messages=[
                        'objeto.required'=>'No ha introducido ningun objeto de documento ',
                        'cuerpo.required'=>'No ha introducido ningun cuerpo de documento ',
                        'nombre.required'=>'No ha introducido una descripcion para el archivo ',
            'nombre.min'=>'La descripcion debe tener mas de 3 caracteres',
                        'receptor.required'=> 'Seleccione almenos un destinatario',
                        'type.required'=> 'Seleccione un tipo de documento'
            
                    ];
                    $this->validate($request, $rules, $messages);
          
        $cuerpo=$request->input('cuerpo');
        $objeto=$request->input('objeto');
        
        $nombre = Auth::user()->name;
        $apellido = Auth::user()->lastname;
        $type= Type::find($request->input('type'));
        $type= $type->name;
        
        $receptores_departamentos=$this->ObtenerDepartamentosReceptores($request->input('receptor'));
     
        $receptores=$this->ObtenerUsuariosReceptores($request->input('receptor'));
  
        //Inicio transformar Html a pdf
        if($receptores_departamentos==null){
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido,'numeracion'=>$this->Asignandonumero(),'tipo'=>$type]
                );

        }elseif ($receptores==null) {
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores_departamentos'=>$receptores_departamentos,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido,'numeracion'=>$this->Asignandonumero(),'tipo'=>$type]
                );
        }
        else {
            $pdf = PDF::loadView(
                'TextEditor.documento',
                ['receptores_departamentos'=>$receptores_departamentos,'receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido,'numeracion'=>$this->Asignandonumero(),'tipo'=>$type]
                );
        }
       
    $output = $pdf->output();

    $nombrepdf="pdf_".time().".pdf";
        $rutapdf=public_path("pdf/".$nombrepdf);

    file_put_contents( "pdf/".$nombrepdf, $output);

        //Fin transformacion
      
        
        
        //Registrar Documento y obtener su id
        $docSubido= $this->RegistrarEnvio($request->input('nombre'), $rutapdf, $request->input('receptor'),$request->input('type') );
        
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido]);

     }
    
     
//Carpeta
     public function FormularioCarpeta($id){

        if($this->UsuarioPropietario($id)==Auth::user()->id){

            $carpetas = \DB::table('folders AS d1')
            ->where('d1.father_folder_id','=',1)
            ->where('d1.departament_id','=',Auth::user()->departament_id)
            ->join('folders AS d2','d2.id','=','d1.father_folder_id')
        ->join('departaments AS d3','d3.id','=','d1.departament_id')
        ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
        ->orderBy('updated_at','DESC')
    ->get();

          
            $document=Document::find($id);
            $type=Type::find($document->type_id);
            $identificador= $id;
            return  view('Documents.Folder')->with (compact('document'))->with (compact('identificador'))
            ->with (compact('type'))->with (compact('carpetas'));
        }
        return 'Usted no tiene permiso para realizar la accion solicitada';
    }

    public function VincularCarpeta($id, Request $request){
        
        $document=Document::find($id);
        $document->folder_id=$request->input('carpeta');
        $document->public=$request->input('publico');
        $document->save();
        $identificador=$id;
        return redirect()->route('Anexos', ['id' => $identificador]);
    }

    //Anexos

    public function FormularioAnexos($id){
        $document=Document::find($id);
        $type=Type::find($document->type_id);
        if($this->Permiso($id)==false){

            return 'Usted no tiene permisos para realizar la accion solicitada';
        }
        $annexes= \DB::table('annexes')->where('document_id', '=', $id)->get();

        $usuario= \DB::table('users')->join('document_user','users.id','=','document_user.user_id')
        ->where('document_id', '=', $id)
        ->where('type', '=', 'E')->first();
        return  view('annexes.index')->with (compact('annexes'))->with (compact('usuario'))
        ->with (compact('document'))
        ->with (compact('type'));
    }
    public function BorrarAnexo($id){
        $Anexo=Annex::find($id);
       
        if($this->UsuarioPropietario($Anexo->document_id)!=Auth::user()->id){

            return 'Usted no tiene permisos para realizar la accion solicitada';
        }
        
        unlink($Anexo->path);
        $Anexo->delete();
        return  back();
    }
    public function Anexos($id, Request $request){
        $configuration=Configuration::find(1)->first();
       
        $rules=[

            'nombre'=> 'required|min:3',
            'archivo'=> 'required|mimes:pdf'.'|max:'.$configuration->document_size
            
                    ];
            
                    $messages=[
                        'nombre.required'=>'No ha introducido un nombre para el archivo ',
                        'nombre.min'=>'El nombre debe tener mas de 3 caracteres',
                        'archivo.required'=>'No se ha se leccionado un archivo para subir',
                        'archivo.mimes'=>'El archivo debe estar en formato PDF',
                        'archivo.max'=>'El archivo no puede exeder los '.$configuration->document_size.' kb',
            
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
       
        if($this->ValidarReceptor($id)==null){

            return 'Usted no tiene permisos para realizar la accion solicitada';
        }
        $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();
  
        $types= Type::all();
        return  view('Responder.Enviar')->with (compact('user'))->with (compact('types'));
    }
    public function postResponder(Request $request, $id){
        $configuration=Configuration::find(1)->first();
        $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();

        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();
        $rules=[
'archivo'=> 'required|mimes:pdf'.'|max:'.$configuration->document_size,
'type'=> 'required|exists:types,id',
'nombre'=> 'required|min:3'        ];
        $messages=[ 'nombre.required'=>'No ha introducido una descripcion para el archivo ',
            'nombre.min'=>'La descripcion debe tener mas de 3 caracteres',
            'archivo.required'=>'No se ha se leccionado un archivo para subir',
            'archivo.mimes'=>'El archivo debe estar en formato PDF',
            'type.required'=>'Ingrese un tipo de documento',
            'archivo.max'=>'El archivo no puede exeder los '.$configuration->document_size.' kb',        ];
        $this->validate($request, $rules, $messages);
        $rutapdf=$this->SubirPdf($request->file("archivo"));
             
        
        $docSubido=$this->RegistrarRespuesta($request->input('nombre'),
        $rutapdf,$process->process,$user->id,$request->input('type'));
       
        return redirect()->route('FirmarDoc', ['id' => $docSubido]);
    }
   //////////
   public function EditorTextoResponder($id){
    if($this->ValidarReceptor($id)==null){

        return 'Usted no tiene permisos para realizar la accion solicitada';
    }
    $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
        $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();
        $types= Type::all();
    return  view('Responder.EditorTexto')->with (compact('user'))->with (compact('types'));


   
}
public function DocHtmlResponder(Request $request, $id){
    $user_id=\DB::table('document_user')->where('type', '=', 'E')->where('document_id', '=', $id)->first();
    $user=\DB::table('users')->where('id', '=', $user_id->user_id)->first();

    $process=\DB::table('document_user')->where('document_id', '=', $id)->first();
    $rules=[

        'cuerpo'=> 'required|min:3',
        'objeto'=> 'required|min:3',
        'type'=> 'required|exists:types,id',
        'nombre'=> 'required|min:3'
                ];
        
                $messages=[
                    'nombre.required'=>'No ha introducido una descripcion para el archivo ',
            'nombre.min'=>'La descripcion debe tener mas de 3 caracteres',
                    'objeto.required'=>'No ha introducido ningun objeto de documento ',
                    'cuerpo.required'=>'No ha introducido ningun cuerpo de documento ',
                    'type.required'=>'Ingrese un tipo de documento'
                   
        
                ];
                $this->validate($request, $rules, $messages);
        
                
    $receptores[0]=$user;
    
    $cuerpo=$request->input('cuerpo');
    $objeto=$request->input('objeto');
    
    $nombre = Auth::user()->name;
    $apellido = Auth::user()->lastname;
    $type= Type::find($request->input('type'));
    $type= $type->name;
   
    //Inicio transformar Html a pdf
    $pdf = PDF::loadView(
    'TextEditor.documento',
    ['receptores'=>$receptores,'cuerpo'=>$cuerpo,'objeto'=>$objeto,'nombre'=>$nombre,'apellido'=>$apellido,'numeracion'=>$this->Asignandonumero(),'tipo'=>$type]
    );
$output = $pdf->output();

$nombrepdf="pdf_".time().".pdf";
    $rutapdf=public_path("pdf/".$nombrepdf);

file_put_contents( "pdf/".$nombrepdf, $output);
    //Fin transformacion
    
    $docSubido=$this->RegistrarRespuesta($request->input('nombre'),$rutapdf,$process->process,$user->id,$request->input('type'));
    return redirect()->route('FirmarDoc', ['id' => $docSubido]);
 }

    //FinResponder
    public function Procesos(){
        
        $processes=\DB::table('document_user')->where('user_id', '=', Auth::user()->id)->orderBy('process', 'desc')->get();

        $i=0;
        
        foreach($processes as $process){
            if($process->document_id == $process->process){
                
                $documents[$i]=\DB::table('documents')
        ->join('types','documents.type_id','=','types.id')
        ->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('documents.id', '=', $process->document_id)
        ->select('document_user.available as available','document_user.type as tipo','documents.created_at as created_at','documents.name','documents.id as document_id','documents.number as number','types.name as type')
       ->first();

                
                $i++;
               
            }
          
        }
       // dd($documents);
       return view('Documents.Procesos')->with(compact('documents'));
    }
    public function Seguimiento($id){

        if($this->Permiso($id)==false){

            return 'Usted no tiene permisos para realizar la accion solicitada';
        }
        $documento=Document::find($id);
        $tipo=Type::find($documento->type_id);

        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();
        $id_documentos=\DB::table('document_user')->where('process', '=', $process->process)->get();

        

        $i=0;
        $temporal=0;
        foreach($id_documentos as $id_documento){
            if($id_documento->document_id !== $temporal){
                
                $documents[$i]=\DB::table('documents')
        ->join('types','documents.type_id','=','types.id')
        ->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('documents.id', '=', $id_documento->document_id)
        ->select('document_user.type as tipo','documents.created_at as created_at','documents.name as name','documents.id as id','documents.number as number','types.name as type')
        ->first();

                
                $i++;
                $temporal=$id_documento->document_id;
            }
           
        }
             
        
      
        
        return view('Documents.Seguimiento')->with(compact('documents'))->with(compact('documento'))->with(compact('tipo'));

    }


    

    public function Terminar($id){
           
        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();

        $documents=\DB::table('document_user')->where('process', '=', $process->process)
        ->update(array('available' => 0));

        
return back();
    }
    public function Reabrir($id){
           
        $process=\DB::table('document_user')->where('document_id', '=', $id)->first();

        $documents=\DB::table('document_user')->where('process', '=', $process->process)
        ->update(array('available' => 1));

        
return back();
    }




/////////////////////////////////////////////////////////////Inicio Funciones 
    //Inicio metodo permitir acceso a documentos
    function Permiso($id_Documento){

        $documento=Document::find($id_Documento);

        $carpeta=\DB::table('documents')
        ->join('folders','documents.folder_id','=','folders.id')
        ->where('documents.id','=',$id_Documento)
        
        
        ->first();
        
/*
        $departamento= \DB::table('document_user')
        ->where('document_id','=',$id_Documento)
        ->where('type','=','E')
        ->join('users','document_user.user_id','=','users.id')
        ->first();
  */     

        $destinatario= \DB::table('documents')
        ->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.document_id','=',$id_Documento)
        ->where('document_user.user_id','=',Auth::user()->id)
        
        ->first();
    

        if(($carpeta->departament_id==Auth::user()->departament_id)||/*($departamento->departament_id ==Auth::user()->departament_id)  || */($destinatario !==  null) || ($documento->public==  1) )
    {
    return true;
    }
    return false;
    }
    //Fin metodo permitir acceso a documentos
//Inicio Numeracion
function Asignandonumero(){
     
       
     $departamento= \DB::table('departaments')
     ->where('id','=',Auth::user()->departament_id)
     ->first();
     $consulta=Document::all();
     $idAnterior=$consulta->last();
    
     if($idAnterior==null){
$numero=1;
     }else{
$numero=$idAnterior->id+1;
     }
     $numeracion=''.$numero.'-'.$departamento->identifier.'-GADMT-'.date('Y');
     
     return $numeracion;
}
//Fin Numeracion
     //Inicio metodo para enviar documento 
     function RegistrarEnvio($nombreDocumento, $rutaDocumento, $Receptores,$tipo_Documento){
        
        $folder=\DB::table('folders')->where('father_folder_id', '=', 1)
        ->where('departament_id', '=', Auth::user()->departament_id)->orderBy('id', 'asc')->first();
        $doc =new Document();
        $doc->name= $nombreDocumento;
        $doc->path= $rutaDocumento;
        $doc->type_id=$tipo_Documento;
        $doc->folder_id=$folder->id;
        $Usuarios=$this->ObtenerUsuariosReceptores($Receptores);
        $Departamentos=$this->ObtenerDepartamentosReceptores($Receptores);
       $doc->number=$this->Asignandonumero();
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
                    if(Auth::user()->id==$UsuarioDelpartamento->id){

                    }else{
                        $doc->users()->attach($UsuarioDelpartamento->id, ['type' => "R",'process' =>$doc->id ]);  
                    }

                    
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
     function RegistrarRespuesta($nombreDocumento, $rutaDocumento, $proceso, $UsuarioAresponder,$tipo_Documento){
        $folder=\DB::table('folders')->where('father_folder_id', '=', 1)
        ->where('departament_id', '=', Auth::user()->departament_id)->orderBy('id', 'asc')->first();
    $doc =new Document();
    $doc->folder_id=$folder->id;
    $doc->name= $nombreDocumento;
    $doc->path= $rutaDocumento;
    $doc->type_id=$tipo_Documento;
       
    $doc->number=$this->Asignandonumero();
    
    
    $doc->save();
    $doc->users()->attach($UsuarioAresponder, ['type' => "R",'process' =>$proceso ]);
    $doc->users()->attach(auth()->user()->id, ['type' => "E",'process' =>$proceso ]);
    
    return $doc->id;

     }
     //Fin Responder
     //Inicio Obtener usuario propietario
     function UsuarioPropietario($id){
        $user_id=\DB::table('document_user')->where('document_id', '=', $id)->where('type', '=', 'E')->first();
        return $user_id->user_id;
        } 
     //Fin Usuario Propietario 
     //Inicio Valida Receptor
     function ValidarReceptor($id){
        $receptor=\DB::table('document_user')->where('type', '=', 'R')
        ->where('document_id', '=', $id)
        ->where('user_id', '=', Auth::user()->id)
        ->first();
        return $receptor;
     }
     //Fin Validar Receptor
     //Obtener Usuarios Jefes de departamento
     function MasUsuarios($id_Departamento){
        $masusuarios= \DB::table('users')->where('departament_id', '=', $id_Departamento)->where('rol', '=', 1)
      ->join('positions','positions.id','=','users.position_id')
              ->join('treatments','treatments.id','=','users.treatment_id')
              ->select('users.*', 'positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
      ->get();
      }
     //Fin Jefes de departameto
//Fin Funciones
}
