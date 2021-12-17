@extends('layouts.app')
@extends('librerias.DataTable')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Tipos de documentos</div>

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

                     <!-- Modal -->
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus fa-1x "> Nuevo Tipo de Documento</i></button>
        <br>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark">Crear Nuevo Tipo de Documento</h4>
                    </div>
                    <div class="modal-body">


    <form action="" method="post" enctype="multipart/form-data">
@csrf


<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Tipo de Documento</label>
    <input type="text" class="form-control" placeholder="Inserte un tipo de documento" id="inputDefault" name="name" value="{{ old('name') }}">
  </div>
  

</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Registrar</button>
        </div> 
</form>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
</div>

</div>
</div>
</div>
<br>

<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($types as $type)
    <tr>
      <td>{{ $type->id }}</td>
      <td>{{ $type->name }}</td>
     
      @if ($type->deleted_at==null)
      <td>
        <a href="/tipo/{{$type->id}}" class="btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit fa-1x ">
          </i>
        </a>

        <a href="/tipo/{{$type->id}}/eliminar" class="btn btn-danger btn-sm" title="Dar de baja">
          <i class="fas fa-trash fa-1x ">
          </i>
        </a>
      </td> 
      @else
      <td>
        <a href="/tipo/{{$type->id}}/restaurar" class="btn btn-success btn-sm" title="Restaurar"><i class="fas fa-recycle fa-1x ">
          </i>
        </a>

        
      </td>
      @endif
      
      
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>
@endsection
    