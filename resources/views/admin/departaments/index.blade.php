@extends('layouts.app')


@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Gestion de departamentos</div>

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
    @foreach ($departaments as $departament )
    <option value="{{ $departament->id }}">{{ $departament->name }}</option>   
    @endforeach
     
    
  </select>
</div>

<div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">Nombre del Departamento</label>
    <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name') }}">
  </div>
  
  
</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Registrar</button>
        </div> 
</form>
<br>
<table id="DataTable" class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Departamento Padre</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($departaments as $departament)
    <tr>
      <td>{{ $departament->id }}</td>
      <td>{{ $departament->name }}</td>
      <td>{{ $departament->father_departament}}</td>
      
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>
@endsection
    