@extends('layouts.app')
@extends('librerias.DataTable')
@section('content')
<div class="rounded-3 card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Documentos Internos del GAD de Tulcan</div>

                <div class="card-body bg-light text-black">

                  

    
<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>Numero</th>
      <th>Tipo</th>
      <th>Nombre del Documento</th>
      <th>Fecha de Creacion</th>
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
    <tr>
     
     
      
      <td>{{ $document->number }}</td>
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
                        <h4 class="modal-title text-dark">Detalles del Documento</h4>
                    </div>
                    <div class="modal-body">
                      @if (request()->is('Recibidos'))

                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-sm btn-primary">Responder</button>
                        <div class="btn-group" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                            <a class="dropdown-item" href="/ResponderDoc/{{$idDelDocumento}}">Subir Documento</a>
                            <a class="dropdown-item" href="/EditorResponder/{{$idDelDocumento}}">Editar Documento</a>
                          </div>
                        </div>
                      </div>

                    
                      
                      @endif

                      @if (request()->is('Enviados'))
                      <a href="/FirmarDoc/{{$idDelDocumento}}" class="btn btn-primary " title="Editar">
                        <i class="fas fa-edit fa-1x"> Editar</i>
                         
                       </a>
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
                         <h5 class="text-dark">Emisor</h5>
                         <table class="table table-hover table-bordered">
                           <thead>
                             <tr>
                               <th>Cedula del Emisor</th>
                               <th>Nombre del Emisor</th>
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
                                 <td>{{ $emisor->position_name }}</td>
                               </tr>
                             @endforeach
                           
                           </tbody>
                         </table>

                          

                          <h5 class="text-dark">Receptores</h5>
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th>Cedula del Receptor</th>
                                <th>Nombre del Receptor</th>
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
                                  <td>{{ $receptor->position_name }}</td>
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

@endsection
    
@php
function ObtenerUsuarios($doc,$transaccion){
  
  $usuariosID= \DB::table('document_user')
->where('document_id', '=', $doc)
->where('type', '=', $transaccion)->get();
$i=0;
foreach ($usuariosID as $usuarioID) {
  $usuarios[$i]= \DB::table('users')
 ->join('positions','positions.id','=','users.position_id')
 ->join('treatments','treatments.id','=','users.treatment_id')
 ->select('users.*', 'positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
 ->where('users.id', '=', $usuarioID->user_id)->first();
$i++;
}
return $usuarios;
}


 
@endphp