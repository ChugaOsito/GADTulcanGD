@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Editar</div>

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
                        <label class="col-form-label mt-4" for="inputDefault">Trato o Titulo</label>
                        <input type="text" class="form-control" placeholder="Inserte un Trato o titulo ejm(Ingeniero, Señor,Magister)" id="inputDefault" name="name" value="{{ old('name',$treatment->name) }}">
                      </div>
                      <div class="form-group">
                        <label class="col-form-label mt-4" for="inputDefault">Inserte una Abreviatura para el Titulo</label>
                        <input type="text" class="form-control" placeholder="Inserte una abreviatura ejm(Ing, Sr, Msc)" id="inputDefault" name="abbreviation" value="{{ old('abbreviation',$treatment->abbreviation) }}">
                      </div>
                      
                    </br>
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div> 
                    </form>

 
<br>

</div>
</div>
</div>
@endsection
    