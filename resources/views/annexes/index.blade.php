@extends('layouts.app')

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
@if (auth()->id()== $usuario->user_id)
  

    <form action="" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group">
  <label class="col-form-label mt-4" for="inputDefault">Nombre del Annexo</label>
  <input type="text" class="form-control" placeholder="Inserte Nombre del Documento" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
</div>

<div class="form-group">
  <label for="formFile" class="form-label mt-4">Subir Archivo PDF</label>
  <input class="form-control" type="file" id="formFile" name="archivo">
</div>

</br>
<div class="form-group">
  <button type="submit" class="btn btn-primary">Anexar</button>

  <a href="/Enviados" class="btn btn-danger" title="Editar">Terminar
    <span class="glyphicon glyphicon-pencil"></span></a>
        </div>

</form>
@endif
<br>
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach ($annexes as $annex)
    <tr>
      <td>{{ $annex->id }}</td>
      <td>{{ $annex->name }}</td>
      <td>
        <a href="#" class="btn btn-primary btn-sm" title="Editar">Editar
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <a href="#" class="btn btn-danger btn-sm" title="Dar de baja">
         Dar de baja
          <span class="glyphicon glyphicon-remove"></span>
        </a>

        <a href="/VerAnexo/{{$annex->id}}" class="btn btn-primary btn-sm" title="Editar">Visualizar
          <span class="glyphicon glyphicon-pencil"></span>
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
    