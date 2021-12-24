<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\EnviarDocController;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class FirmaElectronicaController extends Controller
{
    //Inicio Middleware
     public function __construct()
    {
        $this->middleware('auth');
    }
    //Fin Middledare
    //Firmar Documento
    public function FormularioFirma($id){
        
if($this->UsuarioPropietario($id)==Auth::user()->id){
    return  view('FirmaElectronica/Firmar')->with (compact('id'));
}
return 'Usted no tiene permiso para realizar la accion solicitada';
        
    }
    
    
    public function FirmarDoc($id, Request $request){
        
        $pdfAFirmar=$id;
        
        if(( $pdfAFirmar !==null )and ($request->hasFile("p12"))){
            
            $documents= document::find($pdfAFirmar);
            $pdfAFirmar=$documents->path;
            
            /*Esto se usaba cuando se recibia el doc directamente por text input 
            Borrar esta parte
           
            $filepdf=$request->file("urlpdf");
            $nombrepdf="pdf_".time().".".$filepdf->guessExtension();
            $rutapdf=public_path("pdf/".$nombrepdf);
    */
            $filep12=$request->file("p12");
            $nombrep12="pdf_".time().".p12";
            $rutap12=public_path("pdf/".$nombrep12);
            
            
            $contraseña=$request->input("senha");
            
            $rutaGuardado="C:/xampp/htdocs/GADTulcanGD/public/pdf/";
            
                
                copy($filep12,$rutap12);
                $certificado=$rutaGuardado.$nombrep12;
               
            /*   
            $pag=$request->input("pagina");
            $pos=$request->input("posicion");
            $horiz=0;
            $vert=0;
            
            //Posicion Arriba
            if ($pos==1){
                $horiz=0;
                $vert=561;

            }
            if ($pos==2){
                $horiz=198;
                $vert=561;

            }
            if ($pos==3){
                $horiz=396;
                $vert=561;

            }
            //Posicion media 
            if ($pos==4){
                $horiz=0;
                $vert=281;

            }
            if ($pos==5){
                $horiz=198;
                $vert=281;

            }
            if ($pos==6){
                $horiz=396;
                $vert=281;

            }
            //Posicion Bajo 
            if ($pos==7){
                $horiz=0;
                $vert=0;

            }
            if ($pos==8){
                $horiz=198;
                $vert=0;

            }
            if ($pos==9){
                $horiz=361;
                $vert=0;

            }


*/
                
                
$horiz=198;
$vert=175;
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json; charset="utf-8"' ]
            ]);
            
            $response = $client->post('http://localhost:8080/Prototipo_Firmador_Api/API/Firmarpdf',
                ['body' => json_encode(
                    [
                        
                        "archivop12" => $certificado,
                        "contrasena" => $contraseña,
                        "documentopdf" => $pdfAFirmar,
                        "pagina"=> "",
                        "h"=> $horiz,
                        "v"=> $vert,                    ]
                )]
            );
           
            $DocumentoFirmado=json_decode($response->getBody(),true);
            $documents->path=$DocumentoFirmado['docFirmado'];
            $documents->save();

            //Lo siguiente sirve para mostar el PDF Firmado, se usara despues
            //return response()->file($documents->path);

            return redirect()->route('VincularCarpeta', ['id' => $id]);
            }
        }
    //Fin Firmar Documento 
    //Validar Documento Firmado Electronicamente
    public function FormularioValidar(){

        return  view('FirmaElectronica/Validar');
    }


    public function ValidarDoc($id){
        $documento= document::find($id);
        $pdfAvalidar=$documento->path;
    $client = new Client([
        'headers' => [ 'Content-Type' => 'application/json; charset="utf-8"' ]
    ]);
    
    $response = $client->post('http://localhost:8080/Prototipo_Firmador_Api/API/Validarpdf',
        ['body' => json_encode(
            [
                'ubicacion' => $pdfAvalidar
            ]
        )]
    );
    //dd($response->getBody()->getContents());
    $datos=json_decode($response->getBody(),true);
    
    return view('FirmaElectronica/Validar')->with(compact('datos'));
    }
    //Inicio Funciones
    public function UsuarioPropietario($id){
        $user_id=\DB::table('document_user')->where('document_id', '=', $id)->where('type', '=', 'E')->first();
        return $user_id->user_id;
        }
        //Fin Funciones
} 
    //Fin Validar Documento 
//Funcion
