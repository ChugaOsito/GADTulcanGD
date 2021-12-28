<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use File;

class ZipController extends Controller
{
    //
    public function index(){
      
        //$id_departamento = Auth::user()->departament_id;
        
        $users=\DB::table('users')
        ->where('departament_id','=',Auth::user()->departament_id)
        ->join('positions','positions.id','=','users.position_id')
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
        ->get();
        
        
        
        return  view('zipdownload.index')->with (compact('users'));
    }
    public function download(Request $request){
       
        $documentos=\DB::table('documents')
        ->join('document_user','document_user.document_id','=','documents.id')
        ->where('document_user.user_id','=', $request->input('usuario'))->get();
       
        $zip= new ZipArchive();
        $fileName= 'Backup.zip';
       
        if (!$zip->open( public_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            exit("Error creando ZIP");
        }

            foreach ($documentos as $documento) {
                $relativeNameInZipFile=basename($documento->path);
                $zip->addFile($documento->path,$relativeNameInZipFile);
                
            
            }
           
            $zip->close();

            if(file_exists(public_path($fileName))){
                return response()->download(public_path($fileName));
            }else {
                return back()->with('notification','No se han encontrado registros para este usuario');
            }
        

    
}
}
