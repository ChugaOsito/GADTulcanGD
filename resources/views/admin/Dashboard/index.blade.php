@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Dashboard</div>

                <div class="card-body bg-light text-black">
                    

                    <div class="row">
                        <div class="col-sm-6 ">
                          <div class="card text-white bg-success  ">
                            <div class="card-body">

                              <h5 class="card-title text-center">Usuarios Registrados</h5>

                            

                              <p class="card-text text-center"><i class="fas fa-users fa-5x " > {{ $usuarios }}</i></p>
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="card text-white bg-warning">
                            <div class="card-body">
                              <h5 class="card-title">Documentos Subidos</h5>
                             
                              <p class="card-text text-center"> <i class="far fa-file-pdf fa-5x"> {{ $documentos }}</i></p>
                              <a href="#" class="btn btn-primary">Mas Detalles</a>
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
          <a href="#" class="btn btn-primary">Mas Detalles</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5 class="card-title">Carpetas Registradas</h5>
         
          <p class="card-text text-center"> <i class="fas fa-folder-open fa-5x"> {{ $carpetas }}</i></p>
          <a href="#" class="btn btn-primary">Mas Detalles</a>
        </div>
      </div>
    </div>
    
  </div>
          
</div>
</div>
</div>
@endsection
    