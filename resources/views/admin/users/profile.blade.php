@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Mi Perfil</div>

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
  <label for="exampleSelect1" class="form-label mt-4">Tratamiento o Titulo</label>
  <select class="rounded form-select" id="exampleSelect1" name="treatment">
    @foreach ($treatments as $treatment )
    <option value="{{ $treatment->id }}"@if ($treatment->id== $user->treatment_id)   selected  @endif> {{ $treatment->name }} </option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
  <label class="col-form-label mt-4" for="inputDefault">Numero de Cedula</label>
  <input type="text" class="form-control" placeholder="Inserte Numero de Cedula" id="inputDefault" name="identification"  value="{{ old('identification', $user->identification) }}"
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
    <label class="col-form-label mt-4" for="inputDefault">Correo Electronico</label>
    <input type="text" class="form-control" placeholder="Inserte Correo Electronico" id="inputDefault" name="email"  value="{{ old('email', $user->email) }}">
  </div>

  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Contraseña <em> Ingresar solo en caso de que desee modificarse</em></label>
    <input type="text" class="form-control" placeholder="Inserte Contraseña" id="inputDefault" name="contrasena" value="{{ old('contrasena') }}">
  </div>
  <div class="form-group">

    

    
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
    