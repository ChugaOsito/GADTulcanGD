@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Editar Carpeta</div>

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
                      <label for="exampleSelect1" class="form-label mt-4">Departamento al que pertenece esta carpeta</label>
                      <select class="form-select" id="exampleSelect1" name="departament">
                        @foreach ($departaments as $departament )
                        <option value="{{ $departament->id }}">{{ $departament->name }}</option>   
                        @endforeach
                         
                        
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleSelect1" class="form-label mt-4">Carpeta Padre</label>
                      <select class="form-select" id="exampleSelect1" name="padre">
                        @foreach ($father_folders as $father_folder )
                        <option value="{{ $father_folder->id }}">{{ $father_folder->name }}</option>   
                        @endforeach
                         
                        
                      </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label mt-4" for="inputDefault">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name',$folder->name) }}">
                      </div>
                      
                      
                    </br>
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Registrar</button>
                            </div> 
                    </form>

 
<br>

</div>
</div>
</div>
@endsection
    