@extends('layouts.app')

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
  <fieldset>
    <label class="form-label mt-4" for="readOnlyInput">Receptor</label>
    <input class="form-control" id="readOnlyInput" type="text" placeholder="{{ $user->lastname }} {{ $user->name }} {{ $user->identification }}" readonly="">
  </fieldset>
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
@endsection