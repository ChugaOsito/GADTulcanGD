<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\EnviarDocController;
use App\Models\Document;
use App\Models\Type;
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
        $document=Document::find($id);
        $type=Type::find($document->type_id);
if($this->UsuarioPropietario($id)==Auth::user()->id){
    return  view('FirmaElectronica/Firmar')->with (compact('id'))->with (compact('document'))->with (compact('type'));
}
return 'Usted no tiene permiso para realizar la accion solicitada';
        
    }
    
    
    public function FirmarDoc($id, Request $request){
        $pdfAFirmar=$id;
        if(( $pdfAFirmar !==null )and ($request->hasFile("p12"))){
            $documents= document::find($pdfAFirmar);
            $pdfAFirmar=$documents->path;
            $filep12=$request->file("p12");
            $nombrep12="pdf_".time().".p12";
            $rutap12=public_path("pdf/".$nombrep12);
            $contraseña=$request->input("senha");
            $rutaGuardado="C:/xampp/htdocs/GADTulcanGD/public/pdf/";
                copy($filep12,$rutap12);
                $certificado=$rutaGuardado.$nombrep12;           
$horiz=198;$vert=175;
try{    $client = new Client([
        'headers' => [ 'Content-Type' => 'application/json; charset="utf-8"' ]    ]);
    $response = $client->post('http://localhost:8080/Firma_EC_API/APIREST/Firmarpdf',
        ['body' => json_encode(
            [ "archivop12" => $certificado,"contrasena" => $contraseña,"documentopdf" => $pdfAFirmar,"pagina"=> "",
                "h"=> $horiz,"v"=> $vert,                    ]
        )]);
       $DocumentoFirmado=json_decode($response->getBody(),true);
    if($DocumentoFirmado==NULL){
        unlink($certificado);
        return back()->with('errors','Los datos son incorrectos');
    }
    $documents->path=$DocumentoFirmado['docFirmado'];
    $documents->save();}catch(\GuzzleHttp\Exception\ConnectException $e){ unlink($certificado);
    return 'En este momento no es posible conectarse al modulo de firmas electronicas, por favor intentelo mas tarde';
}
catch(\GuzzleHttp\Exception\ClientException $e){
    unlink($certificado);
    return 'Por este momento no es posible conectarse al modulo de firmas electronicas, por favor intentelo mas tarde';
}            unlink($certificado);
            unlink($pdfAFirmar);         
            return redirect()->route('VincularCarpeta', ['id' => $id]);
            }
        }
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
            [                'ubicacion' => $pdfAvalidar            ]
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
