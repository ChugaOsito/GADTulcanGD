@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Editar usuario</div>

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
  <label for="exampleSelect1" class="form-label mt-4">Tratamiento o Título</label>
  <select class="rounded form-select" id="exampleSelect1" name="treatment">
    @foreach ($treatments as $treatment )
    <option value="{{ $treatment->id }}"@if ($treatment->id== $user->treatment_id)   selected  @endif> {{ $treatment->name }} </option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Número de Cédula</label>
    <input type="text" class="form-control" placeholder="Inserte Número de Cédula" id="inputDefault" name="identification"  value="{{ old('identification', $user->identification) }}"
    minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Apellidos</label>
    <input type="text" class="form-control" placeholder="Inserte Apellidos" id="inputDefault" name="apellidos" value="{{ old('apellidos', $user->lastname) }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombres</label>
    <input type="text" class="form-control" placeholder="Inserte Nombres" id="inputDefault" name="nombres" value="{{ old('nombres', $user->name) }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>

  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Correo Electrónico</label>
    <input type="text" class="form-control" placeholder="Inserte Correo Electronico" id="inputDefault" name="email"  value="{{ old('email', $user->email) }}">
  </div>
<!--Comentar contraseña-->
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Contraseña <em> Ingresar solo en caso de que desee modificarse</em></label>
    <input type="text" class="form-control" placeholder="Inserte Contraseña" id="inputDefault" name="contrasena" value="{{ old('contrasena') }}">
  </div>

  <div class="form-group">

    <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Departamento al que pertenece</label>
      <select class="rounded form-select" id="exampleSelect1" name="departamento">
        @foreach ($departaments as $departament )
        <option value="{{ $departament->id }}" @if ($departament->id== $user->departament_id)   selected  @endif> {{ $departament->name }} </option>   
        @endforeach
         
        
      </select>
    </div>

    <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Cargo que desempeña</label>
      <select class="rounded form-select" id="exampleSelect1" name="position">
        
        @foreach ($positions as $position )
        <option value="{{ $position->id }}"  @if ($position->id== $user->position_id)   selected  @endif> {{ $position->name }}</option>   
        @endforeach
         
        
      </select>
    </div>
    <br>
    
    @if (auth()->user()->rol==0)

    @else
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="rol"
        @if ($user->rol==0))
          checked
        @endif>
        <label class="form-check-label" for="flexCheckDefault">
        <b>  Asignar privilegios de Administrador</b>
        </label>
      </div>
  @endif

    
</br>

  

  
  </div>
</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Actualizar</button>
        </div> 
</form>


</div>
</div>
</div>
@endsection
    