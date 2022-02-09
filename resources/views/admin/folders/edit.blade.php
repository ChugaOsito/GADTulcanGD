@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Editar Carpeta</div>

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
                        <input type="text" class="form-control" placeholder="Inserte un nombre para el departameto" id="inputDefault" name="name" value="{{ old('name',$folder->name) }}">
                      </div>
                      
                      
                    </br>
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Registrar</button>
                            </div> 
                    </form>

 
<br>

</div>
</div>
</div>
@endsection
    