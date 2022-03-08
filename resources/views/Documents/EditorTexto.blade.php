@extends('layouts.app')
@extends('librerias.select2')
@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Editor de Texto</div>

                <div class="card-body bg-light text-black">

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
                                  <label class="col-form-label mt-4" for="inputDefault">Número de Documento <em> (Si este campo se deja vacío se asignara un número automáticamente)</em></label>
                                  <input type="text" class="form-control" placeholder="Inserte un Número de Documento" id="inputDefault" name="number" value="{{ old('number') }}" 
                                  minlength="1" maxlength="4" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-form-label mt-4" for="inputDefault">Descripción del Documento</label>
                                  <input type="text" class="rounded form-control" placeholder="Inserte una breve descripción" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
                                </div>
                                
                                <div class="form-group">
                                  <label for="exampleSelect1" class="form-label mt-4">Para:</label>
                                  <select class="rounded form-select select2" id="exampleSelect1" name="receptor[]" multiple="multiple">
                                    @if($users->count()>1)
                                    <optgroup label="{{ $MiDepartamento->name }}">
                                    <option value="{{ -$MiDepartamento->id }} "> Todo el departamento de {{ $MiDepartamento->name }} </option> 
                                    @foreach ($users as $user )
                                    @if($user->id!=Auth::user()->id)
                                    <option value="{{ $user->id }}" > {{ $user->treatment_abbreviation }}.{{ $user->lastname }} {{ $user->name }} - {{ $user->position_name }} DE {{ strtoupper($user->departament_name) }}
                                       </option>   
                                   @endif
                                    
                                    
                                    @endforeach
                                  </optgroup>
                                  @endif
                                  @if (auth()->user()->is_DepartamentBoss)
                                    @php
                                   
                                    $otros_usuarios=MasUsuarios($Father_departament->id);
                                  @endphp 
                                  @if (isset($otros_usuarios))
                                  <optgroup label="Departamento Superior">
                                  @foreach ($otros_usuarios as $otro_usuario )
                                  
                                  <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}  DE {{ strtoupper($otro_usuario->departament_name) }}
                                 
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
                                    
                                    <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}  DE {{ strtoupper($otro_usuario->departament_name) }}
                                  
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
                                    <option value="{{ $otro_usuario->id }}" > {{ $otro_usuario->treatment_abbreviation }}.{{ $otro_usuario->lastname }} {{ $otro_usuario->name }} - {{ $otro_usuario->position_name }}  DE {{ strtoupper($otro_usuario->departament_name) }}
                                  
                                    @endforeach  
                                     
                                    @endif 
                                  
                                    @endforeach
                                  </optgroup>  
                                    @endif
                                  </select>
                                </div>
                        
                                <div class="form-group">
                                    <label class="col-form-label mt-4" for="inputDefault">Objeto/Asunto</label>
                                    <input name="objeto" type="text" class="form-control" placeholder="Inserte Objeto del documento" id="inputDefault" value="{{ old('objeto') }}">
                                  </div>
<!--
                                <div class="form-group">
                                    <label for="exampleTextarea" class="form-label mt-4">Cuerpo</label>
                                    <textarea name="cuerpo" class="form-control" id="exampleTextarea" rows="20" >
                                      {{ old('cuerpo') }}
                                    </textarea>
                                  </div>
                        -->
                        <div class="form-group">
                          <label for="cuerpo" class="form-label mt-4">Cuerpo</label>
                        <textarea cols="80" id="cuerpo" name="cuerpo" rows="10" data-sample-short>{{ old('cuerpo') }}</textarea>
                        </div>
                                </br>
                        
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                          </div> 
                                       
                          
                          
                        
                         
                        </form>

                  

   
</div>
</div>
</div>

@php
function MasUsuarios($id_Departamento){
  $masusuarios= \DB::table('users')->where('departament_id', '=', $id_Departamento)
  
  ->join('departaments','departaments.id','=','users.departament_id')
  ->join('positions','positions.id','=','users.position_id')
  ->where('positions.representative', '=', 1)->where('users.deleted_at', '=', NULL)
        ->join('treatments','treatments.id','=','users.treatment_id')
        ->select('users.*', 'departaments.name as departament_name','positions.name as position_name', 'treatments.abbreviation as treatment_abbreviation')
->get();
return $masusuarios;
}

  @endphp

@endsection
@section('ck-editor')

<script>
  CKEDITOR.replace('cuerpo', {
    height: 400,
    baseFloatZIndex: 10005,
    removeButtons: 'PasteFromWord,ExportPdf,Print,Save,NewPage,Preview,Source,DocProps'
  });
</script>
    
@endsection
@section('ck-editor-CDN')
<script src="https://cdn.ckeditor.com/4.17.2/full/ckeditor.js"></script>
@endsection
    