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

                  

                  @if (request()->is('Seguimiento/*'))
                  <p><b>{{ $tipo->name}} Numero: </b> {{ $documento->number }}</p>
<p> <b>Descripción:</b> {{ $documento->name }}</p>
                  @endif  
<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
    
      <th colspan="2">Transaccion</th>
     
    
      <th >Numero</th>
      <th>Tipo</th>
      <th>Descripción</th>
      <th>Fecha de Creacion</th>
      <th>Opciones</th>
      
    </tr>
  </thead>
  <tbody>
   
   
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
    <tr @if (isset($document->read) && $document->read==0)
      class="read"
    @endif>
     
     
   
    @if ($document->tipo=='E')
    <td colspan="2">Enviado</td>
    @else
    <td colspan="2">Recibido</td>
    @endif
    
 
      
    <td >{{ $document->number }}</td>
      <td>{{ $document->type }}</td>
      <td>{{ $document->name }}</td>
      <td>{{ $document->created_at }}</td>
      
      <td>
        <!-- Modal -->
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-{{$idDelDocumento}}"><i class="fas fa-envelope-open-text fa-1x"> Abrir</i></button>
        
        <div id="myModal-{{$idDelDocumento}}" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark"><b>{{ $document->type}} Numero: {{ $document->number }} </b></h4>
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
                      <a href="/FirmarDoc/{{$idDelDocumento}}" class="btn btn-primary " title="Editar">
                        
                        <i class="fas fa-edit fa-1x"> Editar</i>
                         
                       </a>

                      

                      

                      @endif
@if ($document->tipo=='E')
  @if ($document->available==0 )
  <a href="/AbrirProceso/{{$idDelDocumento}}" class="btn btn-success " title="Reabrir Proceso">
                        
                        
  <i class="fas fa-check-circle fa-1x">Reabrir Proceso</i>
  
  </a>
  @else
  <a href="/TerminarProceso/{{$idDelDocumento}}" class="btn btn-danger " title="Cerrar Proceso">
                        
    <i class="fas fa-times-circle fa-1x">Cerrar Proceso</i>
    
  </a>
  @endif
@endif
                    
                       
                      <a href="/Anexos/{{$idDelDocumento}}" class="btn btn-info " title="Ver Anexos">
                        <i class="fas fa-paperclip fa-1x"> Anexos</i>
                         
                       </a>

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
  <!--  Documentos Hijos -->
  @php
   $childs=\DB::table('documents')
        ->join('types','documents.type_id','=','types.id')
        ->join('document_user','documents.id','=','document_user.document_id')
        ->where('document_user.user_id', '=', Auth::user()->id)
        ->where('document_user.document_id', '!=', $idDelDocumento)
        ->where('document_user.process', '=', $idDelDocumento)
        ->select('document_user.type as tipo','documents.created_at as created_at','documents.name','documents.id','documents.number as number','types.name as type')
        ->get();
   
  @endphp
  @foreach ($childs as $child)
  <tr @if (isset($child->read) && $child->read==0)
    class="read"
  @endif>
   
   <td><i class="fas fa-angle-double-right  fa-2x"></i></td>
 
  @if ($child->tipo=='E')
  <td >Enviado</td>
  @else
  <td >Recibido</td>
  @endif
  

    
  <td >{{ $child->number }}</td>
    <td>{{ $child->type }}</td>
    <td>{{ $child->name }}</td>
    <td>{{ $child->created_at }}</td>
    
    <td>
      <!-- Modal -->
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-{{$child->id}}"><i class="fas fa-envelope-open-text fa-1x"> Abrir</i></button>
      
      <div id="myModal-{{$child->id}}" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title text-dark"><b>{{ $document->type}} Numero: {{ $document->number }} </b></h4>
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
                    <a href="/FirmarDoc/{{$idDelDocumento}}" class="btn btn-primary " title="Editar">
                      
                      <i class="fas fa-edit fa-1x"> Editar</i>
                       
                     </a>

                    

                    

                    @endif

  
                     
                    <a href="/Anexos/{{$child->id}}" class="btn btn-info " title="Ver Anexos">
                      <i class="fas fa-paperclip fa-1x"> Anexos</i>
                       
                     </a>
<!--
                    <a href="/Seguimiento/{{$idDelDocumento}}" class="btn btn-success" title="Seguimiento">
                      <i class="fas fa-history fa-1x"> Seguimiento</i>
                      
                    </a>
                    -->

<!--Descomentar en caso de ser necesario, este metodo se usaba anteriormente cuando no estaban disponibles los modales
                    <a href="/Documento/{{$idDelDocumento}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
                      <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                  -->
                    
                    <a href="/ValidarDocFirmado/{{$child->id}}" class="btn btn-warning" title="Verificar Firmas">
                      <i class="fas fa-file-signature fa-1x"> Verificar Firmas Electronicas</i>
                       
                     </a>
                     
                     
                    @php
                    
                    $documento= \DB::table('documents')->where('id', '=', $child->id)->first();
                    $pathToFile=$documento->path;
                    
                    $str = substr($pathToFile, 16);
                    
                    @endphp
                      <embed src="http://localhost/{{ $str }}" frameborder="0" width="100%" height="450px">
                        @php
                        $emisores=ObtenerUsuarios($child->id,'E');
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
                             $emisores=ObtenerUsuarios($child->id,'E');
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
                              $receptores=ObtenerUsuarios($child->id,'R');
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
 <!--  Fin Documentos Hijos dd-->
    @endforeach
    @endif
  </tbody>
</table>
</div>
</div>

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