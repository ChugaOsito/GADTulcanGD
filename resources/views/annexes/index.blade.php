@extends('layouts.app')
@extends('librerias.DataTable')
@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Anexar Documentos</div>

                <div class="card-body bg-light text-black">

                  @if (session('notification'))
                  <div class="alert alert-success">
                  {{ session('notification') }}
                  </div>
                    
                  @endif


                  @if (count ($errors)>0)
                  <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error )
                      <li> {{ $error }}</li>
                    @endforeach
                  </ul>
                  </div>
                    
                  @endif

                  <!--Con este condicional verificamos que solo el propietario del documento pueda anexar documentos-->
                  <p><b>{{ $type->name}} Número: </b> {{ $document->number }}</p>
                  <p> <b>Descripción:</b> {{ $document->name }}</p>
                  @if (auth()->id()== $usuario->user_id)
  

    <form action="" method="post" enctype="multipart/form-data">
@csrf

<div class="form-group">
  <label class="col-form-label mt-4" for="inputDefault">Nombre del Anexo</label>
  <input type="text" class="form-control" placeholder="Inserte Nombre del Documento" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
</div>

<div class="form-group">
  <label for="formFile" class="form-label mt-4">Subir Archivo PDF</label>
  <input class="form-control" type="file" id="formFile" name="archivo">
</div>

</br>
<div class="form-group">
  <button type="submit" class="btn btn-primary">Anexar</button>

  <a href="{{ route('Enviados', ['exito' => 1]) }}" class="btn btn-danger" title="Editar">Terminar
    <span class="glyphicon glyphicon-pencil"></span></a>
        </div>

</form>
@endif
<br>
<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Opciones</th>
     
      
    </tr>
  </thead>
  <tbody>
    @foreach ($annexes as $annex)
    <tr>
      <td>{{ $annex->id }}</td>
      <td>{{ $annex->name }}</td>
      <td>
        <!-- Modal -->
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-{{$annex->id}}"><i class="fas fa-envelope-open-text fa-1x"> Abrir</i></button>
        
        <div id="myModal-{{$annex->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark">Visualizar Anexo</h4>
                    </div>
                    <div class="modal-body">
                     
                       
                       
                      @php
                      
                      $documento= \DB::table('annexes')->where('id', '=', $annex->id)->first();
                      $pathToFile=$annex->path;
                      
                      $str = substr($pathToFile, 16);
                      
                      @endphp
                        <embed src="http://localhost/{{ $str }}" frameborder="0" width="100%" height="450px">
                          

                          

                          
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<!--  Fin Modal -->
@if (auth()->id()== $usuario->user_id)      
<a href="/Anexo/{{$annex->id}}/eliminar" class="btn btn-danger btn-sm" title="Eliminar">
  <i class="fas fa-trash fa-1x ">
  </i>
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
    