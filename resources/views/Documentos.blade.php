@extends('layouts.app')
@extends('librerias.DataTable')
@section('content')
<div class="rounded-3 card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

  @if (request()->is('Seguimiento/*'))
                <div class="card-header">Seguimiento de documentos</div>
@elseif (request()->is('Enviados'))
<div class="card-header">Archivos Enviados</div>
@elseif (request()->is('Recibidos'))
<div class="card-header">Bandeja de Entrada</div>
@else
<div class="card-header">Documentos Internos del GAD de Tulcan</div>
@endif
                <div class="card-body bg-light text-black">

                 
                  @if (request()->query('exito')==1)
                 
                  <div class="alert alert-success">
                    El documento ha sido enviado exitosamente
                    </div>
                   
                    
                  @endif
                  

                  @if (request()->is('Seguimiento/*'))
                  <p><b>{{ $tipo->name}} Numero: </b> {{ $documento->number }}</p>
<p> <b>Descripción:</b> {{ $documento->name }}</p>

@php
   $available=\DB::table('document_user')->where('document_user.document_id', '=', $documento->id)
   ->select('document_user.available as available' )->first();

   $process=\DB::table('document_user')->where('document_id', '=', $documento->id)->first();

   $processs=\DB::table('document_user')->where('document_id', '=', $process->process)
   ->where('user_id', '=', auth()->id())->where('type', '=', 'E')->first();
        
@endphp
@if (($processs!=null))
  

@if (($available->available==0) )
<a href="/AbrirProceso/{{$documento->id}}" class="btn btn-success " title="Reabrir Proceso">


  <i class="fas fa-check-circle fa-1x">Reabrir Proceso</i>

 </a>
 <br>
  @else
  <a href="/TerminarProceso/{{$documento->id}}" class="btn btn-danger " title="Cerrar Proceso">

    <i class="fas fa-times-circle fa-1x">Cerrar Proceso</i>

   </a>
   <br>
@endif
@endif
<br>
                  @endif  
<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      @if (request()->is('Seguimiento/*'))
      <th>Transaccion</th>
      @endif
@if (request()->is('Enviados'))
<th>Para</th>
@elseif (request()->is('Recibidos'))
<th>De</th>
@endif
      
      <th>Número</th>
      <th>Tipo</th>
      <th>Descripción</th>
      <th>Fecha de Creación</th>
      <th>Opciones</th>
      
    </tr>
  </thead>
  <tbody>
    <!-- Inicio Carpetas -->
    

    @if (request()->is('Documentos/*'))
    @foreach ($folders as $folder)
    @if ($folder->id>1)
    <tr>
      
      
      
      <td> </td>
      <td>Carpeta</td>
      <td>{{ $folder->name }}</td>
      <td>{{ $folder->created_at }}</td>
      
      
      
      <td>
       
        <a href="/Documentos/{{$folder->id}}" class="btn btn-primary btn-sm" title="Editar"><i class="fas fa-folder-open fa-1x"> Abrir Carpeta</i>
        </a>

        
        
      </td>
    </tr>
    @endif
    @endforeach
    @endif
    <!-- Fin Carpetas  -->
    @if (isset($documents))
      
    
    @foreach ($documents as $document)
    
    @php
      if ((request()->is('Documentos/*')) or request()->is('Seguimiento/*'))
      {
$idDelDocumento= $document->id;
      }else {
        $idDelDocumento=$document->document_id;
      }
    @endphp
     
    <tr  id="Fila-{{ $idDelDocumento }}" @if (isset($document->read) && $document->read==0)
      class="read"
    @endif >
    
    

    @if (request()->is('Enviados'))
    <td>
      @php
      $receptors=\DB::table('users')->join('document_user','users.id','=','document_user.user_id')
    
      ->where('document_user.document_id', '=', $idDelDocumento)
      ->where('document_user.type', '=', "R")
      ->select('users.name as name','users.lastname as lastname')
      ->take(3)
      ->get();
  
       
     @endphp
<ul>
     @foreach ( $receptors as  $key => $receptor )
     
       @if ($key>=2)
    .............   
         @else
         <li> {{ $receptor->lastname }} {{ $receptor->name }} </li>
       @endif
     
     
      
    
     @endforeach
    </ul>   
    </td>

    @elseif (request()->is('Recibidos'))

    @php
    $emisor=\DB::table('users')->join('document_user','users.id','=','document_user.user_id')
  
    ->where('document_user.document_id', '=', $idDelDocumento)
    ->where('document_user.type', '=', "E")
    ->select('users.name as name','users.lastname as lastname')
    ->first();

     
   @endphp
    <td>
      {{ $emisor->lastname }} {{ $emisor->name }} 
    </td>
    @endif
    
    @if (request()->is('Seguimiento/*'))
    @if ($document->tipo=='E')
    <td>Enviado</td>
    @else
    <td>Recibido</td>
    @endif
    
    @endif
      <td>{{ $document->number }}</td>
      <td>{{ $document->type }}</td>
      <td>{{ $document->name }}</td>
      <td>{{ $document->created_at }}</td>
      
      <td>
        <!-- Modal -->
        <!-- Trigger the modal with a button -->
        <button     onclick="resalta('Fila-{{ $idDelDocumento }}')" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-{{$idDelDocumento}}"><i class="fas fa-envelope-open-text fa-1x"> Ver</i></button>
        
        <div id="myModal-{{$idDelDocumento}}" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark"><b>{{ $document->type}} Número: {{ $document->number }} </b></h4>
                    </div>
                    <div class="modal-body">
                      <p><b>Descripción:</b>  {{ $document->name }}</p>
                      @if (request()->is('Recibidos'))
@php
  $disponible= \DB::table('document_user')->where('document_id', '=', $document->document_id)->first();
@endphp
@if ($disponible->available==1)
  

                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      
                        <div class="btn-group" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Responder</button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                            <a class="dropdown-item" href="/ResponderDoc/{{$idDelDocumento}}">Subir Documento</a>
                            <a class="dropdown-item" href="/EditorResponder/{{$idDelDocumento}}">Redactar Documento</a>
                          </div>
                        </div>
                      </div>
                      @endif
                   
                   @php
                      
  $leido= \DB::table('documents')->where('id', '=', $idDelDocumento)  ->update(['read' => 1]);
                    @endphp
                      
                      @endif

                      @if (request()->is('Enviados'))
                      <!--
                      <a href="/FirmarDoc/{{$idDelDocumento}}" class="btn btn-primary " title="Editar">
                        
                        <i class="fas fa-edit fa-1x"> Editar</i>
                         
                       </a>
                      -->
                      

                      

                      @endif
                       
                      <a href="/ViewAnexo/{{$idDelDocumento}}" class="btn btn-info " title="Ver Anexos">
                        <i class="fas fa-paperclip fa-1x"> Anexos</i>
                         
                       </a>
  <!-- Se agrego el boton de seguimiento -->
                      <a href="/Seguimiento/{{$idDelDocumento}}" class="btn btn-success" title="Seguimiento">
                        <i class="fas fa-history fa-1x"> Seguimiento</i>
                        
                      </a>
                     
                      
<!--Descomentar en caso de ser necesario, este metodo se usaba anteriormente cuando no estaban disponibles los modales
                      <a href="/Documento/{{$idDelDocumento}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
                        <span class="glyphicon glyphicon-pencil"></span>
                      </a>
                    -->
                      
                      <a href="/ValidarDocFirmado/{{$idDelDocumento}}" class="btn btn-warning" title="Verificar Firmas">
                        <i class="fas fa-file-signature fa-1x"> Verificar Firmas Electronicas</i>
                         
                       </a>
                       
                       
                      @php
                      
                      $documento= \DB::table('documents')->where('id', '=', $idDelDocumento)->first();
                      $pathToFile=$documento->path;
                      
                      $str = substr($pathToFile, 16);
                      
                      @endphp
                        <embed src="http://localhost/{{ $str }}" frameborder="0" width="100%" height="450px">
                          @php
                          $emisores=ObtenerUsuarios($idDelDocumento,'E');
                        @endphp
                         <h5 class="text-dark">De:</h5>
                         <table class="table table-hover table-bordered">
                           <thead>
                             <tr>
                               <th>Cedula</th>
                               <th>Nombre</th>
                               <th>Cargo</th>
                               
                             </tr>
                           </thead>
                           <tbody>
                             @php
                               $emisores=ObtenerUsuarios($idDelDocumento,'E');
                             @endphp
                             @foreach ($emisores as $emisor )
                             <tr>
                               <td>{{ $emisor->identification }}</td>
                                 <td>{{ $emisor->treatment_abbreviation }} {{ $emisor->name }} {{ $emisor->lastname }}</td>
                                 <td>{{ $emisor->position_name }} DE {{ strtoupper($emisor->departament_name) }}</td>
                               </tr>
                             @endforeach
                           
                           </tbody>
                         </table>

                          

                          <h5 class="text-dark">Para:</h5>
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                $receptores=ObtenerUsuarios($idDelDocumento,'R');
                              @endphp
                              @foreach ($receptores as $receptor )
                              <tr>
                                <td>{{ $receptor->identification }}</td>
                                  <td>{{ $receptor->treatment_abbreviation }} {{ $receptor->name }} {{ $receptor->lastname }}</td>
                                  <td>{{ $receptor->position_name }} DE {{ strtoupper($receptor->departament_name) }}</td>
                                </tr>
                              @endforeach
                            
                            </tbody>
                          </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<!--  Fin Modal -->
       
       
        
      </td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
</div>
</div>
<script>

function resalta(elemento) {
  var elem = document.getElementById(elemento);
  $(elem).removeClass("read");

} 
</script>

@endsection
    
@php
function ObtenerUsuarios($doc,$transaccion){
  
  $usuariosID= \DB::table('document_user')
->where('document_id', '=', $doc)
->where('type', '=', $transaccion)->get();
$i=0;
foreach ($usuariosID as $usuarioID) {
  $usuarios[$i]= \DB::table('users')
  ->join('departaments','departaments.id','=','users.departament_id')
  ->join('positions','positions.id','=','users.position_id')
 ->join('treatments','treatments.id','=','users.treatment_id')
 ->select('users.*', 'departaments.name as departament_name','positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
 ->where('users.id', '=', $usuarioID->user_id)->first();
$i++;
}
return $usuarios;
}


 
@endphp