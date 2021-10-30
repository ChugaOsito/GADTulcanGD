@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 50rem;">

            
                <div class="card-header">Gestion de Carpetas</div>

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

    <form action="" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group">
  <label for="exampleSelect1" class="form-label mt-4">Carpeta Padre</label>
  <select class="form-select" id="exampleSelect1" name="padre">
    @foreach ($folders as $folder )
    <option value="{{ $folder->id }}">{{ $folder->name }}</option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombre de la Carpeta</label>
    <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name') }}">
  </div>
  
  
</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Registrar</button>
        </div> 
</form>
<br>
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Departamento Padre</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($folders as $folder)
    <tr>
      <td>{{ $folder->id }}</td>
      <td>{{ $folder->name }}</td>
      <td>{{ $folder->father_folder_id }}</td>
      <td>
        <a href="/usuario/{{$folder->id}}" class="btn btn-primary btn-sm" title="Editar">Editar
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <a href="/usuario/{{$folder->id}}" class="btn btn-danger btn-sm" title="Dar de baja">
         Dar de baja
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
    