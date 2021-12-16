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
                                  <label class="col-form-label mt-4" for="inputDefault">Nombre del Documento</label>
                                  <input type="text" class="rounded form-control" placeholder="Inserte Nombre del Documento" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
                                </div>

                                <div class="form-group">
                                  <label for="exampleSelect1" class="form-label mt-4">Usuario Receptor</label>
                                  <select class="rounded form-select select2" id="exampleSelect1" name="receptor[]" multiple="multiple">
                                    @foreach ($users as $user )
                                    <option value="{{ $user->id }}">{{ $user->identification }} - {{ $user->lastname }} {{ $user->name }} </option>   
                                    @endforeach
                                    @foreach ($departaments as $departament )
                                    <option value="{{ -$departament->id }} "> Todo el departamento de {{ $departament->name }} </option> 
                                    @php
                                $otros_usuarios = \DB::table('users')->where('departament_id', '=', $departament->id)->get();
                                  @endphp  
                                  @foreach ($otros_usuarios as $otro_usuario )
                                  <option value="{{ $otro_usuario->id }}">{{ $otro_usuario->identification }} - {{ $otro_usuario->lastname }} {{ $otro_usuario->name }} </option>   
                                
                                  @endforeach
                                    @endforeach
                                     
                                    
                                  </select>
                                </div>
                        
                                <div class="form-group">
                                    <label class="col-form-label mt-4" for="inputDefault">Objeto</label>
                                    <input name="objeto" type="text" class="form-control" placeholder="Inserte Objeto del documento" id="inputDefault">
                                  </div>

                                <div class="form-group">
                                    <label for="exampleTextarea" class="form-label mt-4">Cuerpo</label>
                                    <textarea name="cuerpo" class="form-control" id="exampleTextarea" rows="20"></textarea>
                                  </div>
                        
                                </br>
                        
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                          </div> 
                                       
                          
                          
                        
                         
                        </form>

                  

   
</div>
</div>
</div>
@endsection
@section('ck-editor')

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>


<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

    
@endsection
    