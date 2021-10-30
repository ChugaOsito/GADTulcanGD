@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 50rem;">

            
                <div class="card-header">Documentos Internos del GAD de Tulcan</div>

                <div class="card-body bg-light text-black">

                  

    
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>Identificador</th>
      <th>Nombre del Documento</th>
      <th>Fecha de Creacion</th>
      
    </tr>
  </thead>
  <tbody>
    <!-- Inicio Carpetas -->
    @if (request()->is('Documentos/*'))
    @foreach ($folders as $folder)
    <tr>
      
      <td>{{ $folder->id }}</td>
     
      <td>{{ $folder->name }}</td>
      <td>{{ $folder->created_at }}</td>
      
      <td>
       
        <a href="/Documentos/{{$folder->id}}" class="btn btn-primary btn-sm" title="Editar">Abrir Carpeta
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        
        
      </td>
    </tr>
   
    @endforeach
    @endif
    <!-- Fin Carpetas  -->
    @foreach ($documents as $document)
    <tr>
      @if (request()->is('Documentos/*'))
      <td>{{ $document->id }}</td>
      @else
      <td>{{ $document->document_id }}</td>
      @endif
      <td>{{ $document->name }}</td>
      <td>{{ $document->created_at }}</td>
      
      <td>
        @if (request()->is('Documentos/*'))
        <a href="/Documento/{{$document->id}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <a href="/Documento/{{$document->id}}" class="btn btn-danger btn-sm" title="Dar de baja">
         Firmar
          <span class="glyphicon glyphicon-remove"></span>
        </a>
        <a href="/ValidarDocFirmado/{{$document->id}}" class="btn btn-secondary btn-sm" title="Dar de baja">
          Verificar Firmas
           <span class="glyphicon glyphicon-remove"></span>
         </a>
         <a href="/Anexos/{{$document->id}}" class="btn btn-secondary btn-sm" title="Dar de baja">
          Anexos
           <span class="glyphicon glyphicon-remove"></span>
         </a>
          @else

          <a href="/Documento/{{$document->document_id}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
            <span class="glyphicon glyphicon-pencil"></span>
          </a>
  
          <a href="/Documento/{{$document->document_id}}" class="btn btn-danger btn-sm" title="Firmar">
           Firmar
            <span class="glyphicon glyphicon-remove"></span>
          </a>

          <a href="/ValidarDocFirmado/{{$document->document_id}}" class="btn btn-secondary btn-sm" title="Verificar Firmas">
            Verificar Firmas
             <span class="glyphicon glyphicon-remove"></span>
           </a>
           <a href="/Anexos/{{$document->document_id}}" class="btn btn-secondary btn-sm" title="Verificar Firmas">
            Anexos
             <span class="glyphicon glyphicon-remove"></span>
           </a>
        @endif
       
        
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>
@endsection
    