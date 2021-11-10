@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Registro de Usuarios</div>

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
    <label class="col-form-label mt-4" for="inputDefault">Numero de Cedula</label>
    <input type="text" class="form-control" placeholder="Inserte Numero de Cedula" id="inputDefault" name="identification" value="{{ old('identification') }}">
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Apellidos</label>
    <input type="text" class="form-control" placeholder="Inserte Apellidos" id="inputDefault" name="apellidos" value="{{ old('apellidos') }}">
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombres</label>
    <input type="text" class="form-control" placeholder="Inserte Nombres" id="inputDefault" name="nombres" value="{{ old('nombres') }}">
  </div>

  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Correo Electronico</label>
    <input type="text" class="form-control" placeholder="Inserte Correo Electronico" id="inputDefault" name="email" value="{{ old('email') }}">
  </div>

  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Contraseña</label>
    <input type="text" class="form-control" placeholder="Inserte Contraseña" id="inputDefault" name="contrasena" value="{{ old('contrasena', Str::random(10)) }}">
  </div>
  <div class="form-group">
    <label class="col-form-label mt-4" for="Nombre">Seleccione Rol del usuario</label>
</br>
  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="rol" id="btnradio1" autocomplete="off" checked="" value="0">
    <label class="btn btn-outline-primary" for="btnradio1">Administrador</label>
    <input type="radio" class="btn-check" name="rol" id="btnradio2" autocomplete="off" checked="" value="1">
    <label class="btn btn-outline-primary" for="btnradio2">Gestor de Carpetas</label>
    <input type="radio" class="btn-check" name="rol" id="btnradio3" autocomplete="off" checked="" value="2">
    <label class="btn btn-outline-primary" for="btnradio3">Funcionario</label>
  </div>
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
      <th>Cedula</th>
      <th>Apellidos</th>
      <th>Nombres</th>
      <th>E-mail</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->identification }}</td>
      <td>{{ $user->lastname }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email}}</td>
      <td>
        <a href="/usuario/{{$user->id}}" class="btn btn-primary btn-sm" title="Editar">Editar
          <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <a href="/usuario/{{$user->id}}" class="btn btn-danger btn-sm" title="Dar de baja">
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
    