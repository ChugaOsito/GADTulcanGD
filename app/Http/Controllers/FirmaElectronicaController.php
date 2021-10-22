<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\EnviarDocController;
use App\Models\Document;

class FirmaElectronicaController extends Controller
{
    //Inicio Middleware
     public function __construct()
    {
        $this->middleware('auth');
    }
    //Fin Middledare
    //Firmar Documento
    public function FormularioFirma(){
        $activador=0;

        return  view('FirmaElectronica/Firmar')->with (compact('activador'));
    }
    
    
    public function FirmarDoc(Request $request){
        
        $pdfAFirmar=$request->input("AFirmar");
        
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



                
                
           
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json; charset="utf-8"' ]
            ]);
            
            $response = $client->post('http://localhost:8080/Prototipo_Firmador_Api/API/Firmarpdf',
                ['body' => json_encode(
                    [
                        
                        "archivop12" => $certificado,
                        "contrasena" => $contraseña,
                        "documentopdf" => $pdfAFirmar,
                        "pagina"=> $pag,
                        "h"=> $horiz,
                        "v"=> $vert,                    ]
                )]
            );
           
            $DocumentoFirmado=json_decode($response->getBody(),true);
            $documents->path=$DocumentoFirmado['docFirmado'];
            $documents->save();
            return response()->file($documents->path);
            }
        }
    //Fin Firmar Documento 
    //Validar Documento Firmado Electronicamente
    public function FormularioValidar(){

        return  view('FirmaElectronica/Validar');
    }


    public function ValidarDoc(Request $request){
if($request->hasFile("urlpdf")){
   
    $file=$request->file("urlpdf");
    $nombre="pdf_".time().".".$file->guessExtension();
    $ruta=public_path("pdf/".$nombre);
    $pdfAvalidar="C:/xampp/htdocs/GADTulcanGD/public/pdf/";
    if($file->guessExtension()=="pdf"){
        copy($file,$ruta);
        $pdfAvalidar.=$nombre;
        
    }else{
        dd("No es un pdf");
    }
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
    dd($response->getBody()->getContents());
    }
} 
    //Fin Validar Documento 
}
