@extends('layouts.app')
@extends('librerias.DataTable')

@section('content')
<style>
  .abs-center {
  display: flex;
  align-items: center;
  justify-content: center;
  
}


</style>
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Dashboard</div>

                <div class="card-body bg-light text-black">
                    
                  

                    <div class="row">
                        <div class="col-sm-6 ">
                          <div class="card text-white bg-success  ">
                            <div class="card-body">

                              <h5 class="card-title text-center">Usuarios Registrados</h5>

                            

                              <p class="card-text text-center"><i class="fas fa-users fa-5x " > {{ $usuarios }}</i></p>
                              <!-- 
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
                              -->
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="card text-white bg-warning">
                            <div class="card-body">
                              <h5 class="card-title">Documentos Subidos</h5>
                             
                              <p class="card-text text-center"> <i class="far fa-file-pdf fa-5x"> {{ $documentos }}</i></p>
                             <!-- 
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
                              -->
                            </div>
                          </div>
                        </div>
                        
                      </div>
<br>
                      
<div class="row">
    <div class="col-sm-6 ">
      <div class="card text-white bg-dark  ">
        <div class="card-body">

          <h5 class="card-title text-center">Departamentos Registrados </h5>

        

          <p class="card-text text-center"><i class="fas fa-building fa-5x " > {{ $departamentos }}</i></p>
          <!-- 
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
                              -->
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5 class="card-title">Carpetas Registradas</h5>
         
          <p class="card-text text-center"> <i class="fas fa-folder-open fa-5x"> {{ $carpetas }}</i></p>
          <!-- 
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
                              -->
        </div>
      </div>
    </div>
    
  </div>
     
  <br>  
  <div class="row abs-center ">
    <div class="col-sm-10">
      <h1 class="card-title text-center text-white bg-dark ">LOGS de la Aplicacion</h1>
  <table id="DataTable"class=" table table-striped" style="width:100%">
    <thead>
      <tr>
        <th>id</th>
        <th>event</th>
        <th>new_values</th>
        <th>old_values</th>
        
        <th>user_type</th>
        <th>user_id</th>
        
        <th>auditable_type</th>
        <th>auditable_id</th>
        
        <th>url</th>
        <th>ip_address</th>
        <th>user_agent</th>
        <th>tags</th>
        <th>created_at</th>
        <th>updated_at</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($audits as $audit)
      <tr>
        <td>{{ $audit->id }}</td>
        <td>{{ $audit->event }}</td>
        <td>{{ $audit->new_values }}</td>
        <td>{{ $audit->old_values }}</td>
        
        <td>{{ $audit->user_type }}</td>
        <td>{{ $audit->user_id }}</td>
        
        <td>{{ $audit->auditable_type }}</td>
        <td>{{ $audit->auditable_id }}</td>
        
        <td>{{ $audit->url }}</td>
        <td>{{ $audit->ip_address }}</td>
        <td>{{ $audit->user_agent }}</td>
        <td>{{ $audit->tags }}</td>
        <td>{{ $audit->created_at }}</td>
        <td>{{ $audit->updated_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
    </div>
  </div>
</div>
</div>
</div>
@endsection
    