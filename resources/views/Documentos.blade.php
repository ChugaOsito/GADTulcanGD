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
    @foreach ($documents as $document)
    <tr>
      <td>{{ $document->id }}</td>
      <td>{{ $document->name }}</td>
      <td>{{ $document->created_at }}</td>
      
      <td>
        <a href="/Documento/{{$document->id}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <a href="/Documento/{{$document->id}}" class="btn btn-danger btn-sm" title="Dar de baja">
         Firmar
          <span class="glyphicon glyphicon-remove"></span>
        </a>
        
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>
@endsection
    