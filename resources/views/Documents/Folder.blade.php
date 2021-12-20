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
  <label class="col-form-label mt-4" for="Nombre">¿Desea hacer este documento publico?</label>
</br>

  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
   
    <input type="radio" class="btn-check" name="publico" id="btnradio2" autocomplete="off"  value="1" @if ($document->public==1) checked @endif>
    <label class="btn btn-outline-primary" for="btnradio2">Si</label>
    <input type="radio" class="btn-check" name="publico" id="btnradio3" autocomplete="off"  value="0" @if ($document->public==0) checked @endif>
    <label class="btn btn-outline-primary" for="btnradio3">No</label>
  </div>

</br>
<br>
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
