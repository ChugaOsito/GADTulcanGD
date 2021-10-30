@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 50rem;">

            
                <div class="card-header">Editor de Texto</div>

                <div class="card-body bg-light text-black">

                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                                  </div> 
                                </br>
                        <textarea name="" id="editor" cols="30" rows="100">Hola</textarea>
                        
                       
                        
                        
                          
                          
                        
                         
                        </form>

                  

   
</div>
</div>
</div>
@endsection
@section('ck-editor')

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>


<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

    
@endsection
    