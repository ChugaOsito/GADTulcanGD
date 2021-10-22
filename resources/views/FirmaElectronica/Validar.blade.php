@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 50rem;">

            
                <div class="card-header">Verificar Firma Electronica</div>

                <div class="card-body bg-light text-black">
    <form action="/ValidarDocFirmado" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group">
    <label for="formFile" class="form-label mt-4">Archivo PDF</label>
    <input class="form-control" type="file" id="formFile" name="urlpdf">
  </div>
</br>
<div class="form-group">
  <button type="submit" class="btn btn-primary">Verificar</button>
        </div> 
</form>
</div>
</div>
</div>
@endsection
    