@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Firma Electronica</div>

                <div class="card-body bg-light text-black">
    <form action="" method="post" enctype="multipart/form-data">
@csrf



  <div class="form-group">
    <label for="formFile" class="form-label mt-4">Certificado P12 o PFX</label>
    <input class="form-control" type="file" id="formFile" name="p12">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1" class="form-label mt-4">Contraseña del Certificado</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="senha">
  </div>
<!--- Elejir pagina y posicion de firma
  <div class="form-group">
    <label class="col-form-label mt-4" for="Nombre">Ingrese pagina en donde se estampara la Firma</label>
<input type="number" class="form-control"  id="pagina" name="pagina"
       min="1" max="10000">
  </div>
  <div class="form-group">
    <label class="col-form-label mt-4" for="Nombre">Indique la posicion del estampado en la hoja</label>

  </br>

<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
  <input type="radio" class="btn-check" name="posicion" id="btnradio1" autocomplete="off" checked="" value="1">
  <label class="btn btn-outline-primary" for="btnradio1">O</label>
  <input type="radio" class="btn-check" name="posicion" id="btnradio2" autocomplete="off" checked="" value="2">
  <label class="btn btn-outline-primary" for="btnradio2">O</label>
  <input type="radio" class="btn-check" name="posicion" id="btnradio3" autocomplete="off" checked="" value="3">
  <label class="btn btn-outline-primary" for="btnradio3">O</label>
</div>
</br>
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="posicion" id="btnradio4" autocomplete="off" checked="" value="4">
    <label class="btn btn-outline-primary" for="btnradio4">O</label>
    <input type="radio" class="btn-check" name="posicion" id="btnradio5" autocomplete="off" checked="" value="5">
    <label class="btn btn-outline-primary" for="btnradio5">O</label>
    <input type="radio" class="btn-check" name="posicion" id="btnradio6" autocomplete="off" checked="" value="6">
    <label class="btn btn-outline-primary" for="btnradio6">O</label>
  </div>
</br>
  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="posicion" id="btnradio7" autocomplete="off" checked="" value="7">
    <label class="btn btn-outline-primary" for="btnradio7">O</label>
    <input type="radio" class="btn-check" name="posicion" id="btnradio8" autocomplete="off" checked="" value="8">
    <label class="btn btn-outline-primary" for="btnradio8">O</label>
    <input type="radio" class="btn-check" name="posicion" id="btnradio9" autocomplete="off" checked="" value="9">
    <label class="btn btn-outline-primary" for="btnradio9">O</label>
  </div>


  </div>
Fin posicion y pagina de firma-->
</br>
  <div class="form-group">
    <button type="submit" class="btn btn-primary">Firmar</button>

    <a href="/VincularCarpeta/{{$id}}" class="btn btn-danger" title="Editar">Omitir
      <span class="glyphicon glyphicon-pencil"></span></a>
          </div> 
        
         
</form>
</div>
</div>
</div>
@endsection
