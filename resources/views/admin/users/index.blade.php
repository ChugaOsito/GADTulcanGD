@extends('layouts.app')

@extends('librerias.DataTable')


@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Registro de Usuarios</div>

                <div class="card-body bg-light text-black">

                  @if (session('notification'))
                  <div class="alert alert-success">
                  {{ session('notification') }}
                  </div>
                    
                  @endif


                  
                  <!-- Modal -->
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus fa-1x "> Nuevo Usuario</i></button>
        <br>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark">Crear Nuevo Usuario</h4>
                    </div>
                    <div class="modal-body">
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
  <label for="exampleSelect1" class="form-label mt-4">Tratamiento o Título</label>
  <select class="rounded form-select" id="exampleSelect1" name="treatment">
    @foreach ($treatments as $treatment )
    <option value="{{ $treatment->id }}"> {{ $treatment->name }} </option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Número de Cédula </label>
    <input type="text" class="form-control" placeholder="Inserte Número de Cédula " id="inputDefault" name="identification" value="{{ old('identification') }}" 
    minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Apellidos</label>
    <input type="text" class="form-control" placeholder="Inserte Apellidos" id="inputDefault" name="apellidos" value="{{ old('apellidos') }}"  onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombres</label>
    <input type="text" class="form-control" placeholder="Inserte Nombres" id="inputDefault" name="nombres" value="{{ old('nombres') }}"  onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>

  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Correo Electrónico</label>
    <input type="text" class="form-control" placeholder="Inserte Correo Electrónico" id="inputDefault" name="email" value="{{ old('email') }}">
  </div>
<!--Comentar Contraseña-->
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Contraseña</label>
    <input type="text" class="form-control" placeholder="Inserte Contraseña" id="inputDefault" name="contrasena" value="{{ old('contrasena', Str::random(10)) }}">
  </div>
  
  <div class="form-group">

    <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Departamento al que pertenece</label>
      <select class="rounded form-select" id="exampleSelect1" name="departamento">
        @foreach ($departaments as $departament )
        <option value="{{ $departament->id }}"> {{ $departament->name }} </option>   
        @endforeach
         
        
      </select>
    </div>

    <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Cargo que desempeña</label>
      <select class="rounded form-select" id="exampleSelect1" name="position">
        @foreach ($positions as $position )
        <option value="{{ $position->id }}"> {{ $position->name }} </option>   
        @endforeach
         
        
      </select>
    </div>
  </br>
  @if (auth()->user()->rol==0)

  @else
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="rol">
      <label class="form-check-label" for="flexCheckDefault">
      <b>  Asignar privilegios de Administrador</b>
      </label>
    </div>
@endif
    <!-- 
    <label class="col-form-label mt-4" for="Nombre">Seleccione Rol del usuario</label>
</br>



  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    @if (Auth::user()->rol==-1)
    <input type="radio" class="btn-check" name="rol" id="btnradio0" autocomplete="off" checked="" value="-1">
    <label class="btn btn-outline-primary" for="btnradio0">Super Administrador</label>
    <input type="radio" class="btn-check" name="rol" id="btnradio1" autocomplete="off" checked="" value="0">
    <label class="btn btn-outline-primary" for="btnradio1">Administrador</label>
    @endif
    <input type="radio" class="btn-check" name="rol" id="btnradio2" autocomplete="off" checked="" value="1">
    <label class="btn btn-outline-primary" for="btnradio2">Jefe de departamento</label>
    <input type="radio" class="btn-check" name="rol" id="btnradio3" autocomplete="off" checked="" value="2">
    <label class="btn btn-outline-primary" for="btnradio3">Funcionario</label>
  </div>
  -->
  </div>
<br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Registrar</button>
        </div> 
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
</div>

</div>
</div>
</div>
<br>

<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>Cédula</th>
      <th>Apellidos</th>
      <th>Nombres</th>
      <th>E-mail</th>
      <th>Cargo</th>
      <th>Departamento</th>
      <th>Rol</th>
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
      <td>{{ $user->position_name}}</td>
      <td>{{ $user->departament_name}}</td>
      @php
        $roles = array("Super Administrador","Administrador","Jefe de Departamento", "Funcionario");
      @endphp
      <td>{{ $roles[$user->rol+1] }}</td>
      @if($user->deleted_at!=null)
      <td>
        <a href="/usuario/{{$user->id}}/restaurar" class="btn btn-success btn-sm" title="Restaurar"><i class="fas fa-recycle fa-1x"></i>
        </a>
      </td>
      
      @else
      <td>
        <a href="/usuario/{{$user->id}}" class="btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit fa-1x ">
          </i>
        </a>

        <a href="/usuario/{{$user->id}}/eliminar" class="btn btn-danger btn-sm" title="Inactivar">
          <i class="fas fa-trash fa-1x ">
          </i>
        </a>
      </td>
      @endif
    </tr>
    
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>

<script type="text/javascript">
  @if (count($errors) > 0)
      $('#myModal').modal('show');
  @endif
  </script>

@endsection
    
