@extends('layouts.app')


@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Descargar Copia de información</div>

                <div class="card-body bg-light text-black">

                  @if (session('notification'))
                  <div class="alert alert-danger">
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
  <label for="exampleSelect1" class="form-label mt-4">Escoja un usuario</label>
  <select class="form-select" id="exampleSelect1" name="usuario">
    @foreach ($users as $user )
    <option value="{{ $user->id }}" > {{ $user->treatment_abbreviation }}.{{ $user->lastname }} {{ $user->name }} - {{ $user->position_name }}
       </option>   
    @endforeach
     
    
  </select>
</div>


  
  
</br>

<div class="form-group">
  <button type="submit" class="btn btn-primary">Descargar</button>
        </div> 
</form>
<br>

</div>
</div>
</div>
@endsection
    