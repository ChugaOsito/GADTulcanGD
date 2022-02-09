@extends('layouts.app')
@extends('librerias.DataTable')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Gestion de cargos de la Institucion</div>

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
    <label class="col-form-label mt-4" for="inputDefault">Nombre del Cargo</label>
    <input type="text" class="form-control" placeholder="Inserte un cargo" id="inputDefault" name="name" value="{{ old('name', $positions->name) }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="representative" 
    @if ($positions->representative==1)
    checked  
    @endif>
    <label class="form-check-label" for="flexCheckDefault">
      <b>Asignar privilegios de Representante de Departamentos</b> 
    </label>
  </div>
  
  
</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Actualizar</button>
        </div> 
</form>

@endsection
    