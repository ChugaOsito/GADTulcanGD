@extends('layouts.app')
@extends('librerias.select2')
@section('content')
<div class="rounded-3 card text-white bg-primary border-primary mb-3 " style="max-width: 100rem;">

            
                <div class="card-header">Enviar Documento</div>

                <div class="card-body bg-light text-black ">
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
  <label for="exampleSelect1" class="form-label mt-4">Tipo de Documento</label>
  <select class="form-select" id="exampleSelect1" name="type">
    @foreach ($types as $type )
    <option value="{{ $type->id }}">{{ $type->name }}</option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
  <label for="exampleSelect1" class="form-label mt-4">Usuario Receptor</label>
  <select class="rounded form-select select2" id="exampleSelect1" name="receptor[]" multiple="multiple">
    <optgroup label="Mi Departamento">
    <option value="{{ -$MiDepartamento->id }} "> Todo el departamento de {{ $MiDepartamento->name }} </option> 
    @foreach ($users as $user )
   
    <option value="{{ $user->id }}" > {{ $user->treatment_abbreviation }}.{{ $user->lastname }} {{ $user->name }} - {{ $user->position_name }}
       </option>   
   
    
    @endforeach
  </optgroup>
    @php
   
    $otros_usuarios=MasUsuarios($Father_departament->id);
  @endphp 
  @if (isset($otros_usuarios))
  <optgroup label="Departamento Superior">
  @foreach ($otros_usuarios as $otro_usuario )
  
  <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}
 
  @endforeach    
</optgroup>
  @endif 

@php
   $otros_usuarios=null;
@endphp
<optgroup label="Departamentos del mismo nivel">    
@foreach ($Brother_departaments as $Brother_departament )
    
    @php
   
      $otros_usuarios=MasUsuarios($Brother_departament->id);
    @endphp 
    @if (isset($otros_usuarios))
    
    @foreach ($otros_usuarios as $otro_usuario )
    @if ($otro_usuario->id!=Auth::user()->id)
    
    <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}
  
      @endif
    @endforeach 
     
    @endif 
  
    @endforeach
  </optgroup> 
    @php
    $otros_usuarios=null;
 @endphp
    <optgroup label="Departamentos Inferiores">
    @foreach ($Child_departaments as $Child_departament )
    
    @php
      $otros_usuarios=MasUsuarios($Child_departament->id);
    @endphp 
    @if (isset($otros_usuarios))
    
    @foreach ($otros_usuarios as $otro_usuario )
    <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}
  
    @endforeach  
     
    @endif 
  
    @endforeach
  </optgroup>  
    
  </select>
</div>

  <div class="form-group">
  <label class="col-form-label mt-4" for="inputDefault">Nombre del Documento</label>
  <input type="text" class="rounded form-control" placeholder="Inserte Nombre del Documento" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
</div>

<div class="form-group">
  <label for="formFile" class="form-label mt-4">Subir Archivo PDF</label>
  <input class="rounded form-control" type="file" id="formFile" name="archivo">
</div>



  
  
</br>
  <div class="form-group">
    <button type="submit" class="rounded btn btn-primary">Enviar</button>
          </div> 
</form>

</div>
</div>
</div>
@php
function MasUsuarios($id_Departamento){
  $masusuarios= \DB::table('users')->where('departament_id', '=', $id_Departamento)->where('rol', '=', 1)
->join('positions','positions.id','=','users.position_id')
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
->get();
return $masusuarios;
}

  @endphp
@endsection
