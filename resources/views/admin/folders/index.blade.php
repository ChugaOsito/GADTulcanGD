@extends('layouts.app')
@extends('librerias.DataTable')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Gestion de Carpetas</div>

                <div class="card-body bg-light text-black">

                  @if (session('notification'))
                  <div class="alert alert-success">
                  {{ session('notification') }}
                  </div>
                    
                  @endif


                 

                   <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus fa-1x "> Nueva Carpeta</i></button>
        <br>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-dark">Crear Nueva Carpeta</h4>
                    </div>
                    <div class="modal-body">
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
  <label for="exampleSelect1" class="form-label mt-4">Carpeta Padre</label>
  <select class="form-select" id="exampleSelect1" name="padre">
    @foreach ($carpetas as $carpeta )

    @if ($carpeta->deleted_at==NULL)
    
    <option class="dropdown-item " value="{{ $carpeta->id }}"> &#128193; {{ $carpeta->name }}</option>  

    @php
       $hijos = \DB::table('folders AS d1')
        ->where('d1.father_folder_id','=',$carpeta->id)
        ->where('d1.departament_id','=',Auth::user()->departament_id)
        ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
    ->orderBy('updated_at','DESC')
->get();

@endphp
    @if ($hijos != NULL)
    @php
        $nivel=2;
    @endphp
    @include('admin.folders.tree',['hijos' => $hijos,'nivel'=>$nivel])   
    
    @endif
    @endif
     
    @endforeach
    
  </select>
</div>


<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombre de la Carpeta</label>
    <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name') }}">
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
      <th>Carpeta Padre</th>
      <th>Departamento al que pertenece</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($folders as $folder)
    <tr>
      <td>{{ $folder->id }}</td>
      <td>{{ $folder->name }}</td>
      <td>{{ $folder->father_folder }}</td>
     
      <td>{{ $folder->departament }}</td>
      @if ($folder->deleted_at!=null)
      <td>
        

        <a href="/carpeta/{{$folder->id}}/restaurar" class="btn btn-success btn-sm" title="Dar de baja">
          <i class="fas fa-recycle fa-1x"></i>
        </a>
      </td>
      @else
      <td>
        <a href="/carpeta/{{$folder->id}}" class="btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit fa-1x ">
          </i>
        </a>

        <a href="/carpeta/{{$folder->id}}/eliminar" class="btn btn-danger btn-sm" title="Dar de baja">
          <i class="fas fa-trash fa-1x ">
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
<script type="text/javascript">
  @if (count($errors) > 0)
      $('#myModal').modal('show');
  @endif
  </script>

@endsection
    