@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Guardar documento en Carpeta</div>

                <div class="card-body bg-light text-black">
    <form action="" method="post" enctype="multipart/form-data">
@csrf

<div class="form-group">
    <label for="exampleSelect1" class="form-label mt-4">Carpeta</label>
    <select class="form-select" id="exampleSelect1" name="carpeta">
      @foreach ($folders as $folder )
      <option value="{{ $folder->id }}">{{ $folder->name }}</option>   
      @endforeach
       
      
    </select>
  </div>

</br>
  <div class="form-group">
    <button type="submit" class="btn btn-primary">Guardar</button>

    <a   href="/Anexos/{{ $identificador }}" class="btn btn-danger" title="Omitir">Omitir
      <span class="glyphicon glyphicon-pencil"></span></a>
          </div> 

          
        
      
</form>
</div>
</div>
</div>
@endsection
