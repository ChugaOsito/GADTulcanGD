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

                  <p><b>Respondiendo a {{ $typoR->name}} Número: </b> {{ $documentoR->number }}</p>
                  <p> <b>Descripción:</b> {{ $documentoR->name }}</p>
              
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
  <label class="col-form-label mt-4" for="inputDefault">Número de Documento <em> (Si este campo se deja vacío se asignará un número automáticamente)</em></label>
  <input type="text" class="form-control" placeholder="Inserte un Número de Documento" id="inputDefault" name="number" value="{{ old('number') }}" 
  minlength="1" maxlength="4" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
</div>

<div class="form-group">
  <fieldset>
    <label class="form-label mt-4" for="readOnlyInput">Para:</label>
    <input class="form-control" id="readOnlyInput" type="text" placeholder="{{ $user->lastname }} {{ $user->name }} {{ $user->identification }}" readonly="">
  </fieldset>
</div>

<div class="form-group">
  <label class="col-form-label mt-4" for="inputDefault">Descripción del Documento</label>
  <input type="text" class="rounded form-control" placeholder="Inserte una breve descripción" id="inputDefault" name="nombre" value="{{ old('nombre') }}">
</div>

<div class="form-group">
  <label for="formFile" class="form-label mt-4">Subir Archivo PDF</label>
  <input class="rounded form-control" type="file" id="formFile" name="archivo">
</div>



  
  
<br>
  
                
<style>
  .botonEnlinea{
  display: inline-block;
  }
                        </style>
  <button type="button" class="btn btn-success botonEnlinea" data-toggle="modal" data-target="#exampleModal">
  Anexos
  </button>
  
                         
  
                 <!--Inicio Anexos -->
                       <!-- Modal content-->
                      <!-- Button trigger modal -->
  
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
  <h4 class="modal-title text-dark">Anexar Documentos</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <div class="modal-body">
  <!-- Modal Body-->
  
  
  <div class="input-group control-group increment" >
  
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombre del Anexo</label>
    <input type="text" class="form-control" placeholder="Nombre del Documento" id="inputDefault" name="nombreAnexo[]" value="{{ old('nombreAnexo.0') }}">
  </div>
  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault2">Archivo</label>
  <input type="file" name="Anexo[]" class="form-control"  id="inputDefault2" value="{{ old('Anexo.0') }}">
  <br>
  <div class="input-group-btn"> 
    <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i> Añadir</button>
    <input class="btn bg-danger text-white" type ="button" onclick="limpiar()" value="Quitar"/>
    
  </div>
  
  </div>
  </div>
  
  <div class="clone hide d-none">
  <div class="control-group input-group" style="margin-top:10px">
    
    <div class="form-group">
      <label class="col-form-label mt-4" for="inputDefault2">Nombre del Anexo</label>
      <input type="text" class="form-control" placeholder="Nombre del Documento" id="inputDefault2" name="nombreAnexo[]" value="{{ old('nombreAnexo.1') }}">
    </div>
    <div class="form-group">
      <label class="col-form-label mt-4" for="inputDefault3">Archivo</label>
    <input type="file" name="Anexo[]" class="form-control"  id="inputDefault3" value="{{ old('Anexo.1') }}">
    <br>
    <div class="input-group-btn"> 
      <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Quitar</button>
    </div>
  
  </div>
    
   
  </div>
  </div>
  
  <br>
  <!-- Fin Modal Body -->
  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  
  </div>
  </div>
  </div>
  </div>
  <!--  Fin Modal -->
                
                <!--Fin Anexos -->
  
  <div class="form-group botonEnlinea">
    <button type="submit" class="rounded btn btn-primary">Enviar</button>
          </div>
</form>

</div>
</div>
</div>
<script type="text/javascript">

  $(document).ready(function() {

    $(".btn-success").click(function(){ 
        var html = $(".clone").html();
        $(".increment").after(html);
    });

    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".control-group").remove();
    });

  });
  function limpiar(){
  document.getElementById('inputDefault2').value ='';

  }
</script>
@endsection
