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
                      <label for="exampleSelect1" class="form-label mt-4">Departamento Padre</label>
                      <select class="form-select" id="exampleSelect1" name="padre">
                        @foreach ($father_departaments as $father_departament )
                        <option value="{{ $father_departament->id }}" @if ($father_departament->id==$departament->father_departament_id)
                          selected
                        @endif>{{ $father_departament->name }}</option>   
                        @endforeach
                         
                        
                      </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label mt-4" for="inputDefault">Nombre del Departamento</label>
                        <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name', $departament->name) }}">
                      </div>
                      <div class="form-group">
                        <label class="col-form-label mt-4" for="inputDefault">Identificador del Departamento</label>
                        <input type="text" class="form-control" placeholder="Inserte un identificador para el departameto" id="inputDefault" name="identifier" value="{{ old('identifier', $departament->identifier) }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                      </div> 
                      
                    </br>
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div> 
                    </form>

 
<br>

</div>
</div>
</div>
@endsection
    