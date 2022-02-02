@foreach ($hijos as $hijo )

    @if ($hijo->deleted_at==NULL)
    
        
    @php
    $flecha='';
        for ($i=1;$i<$nivel;$i++){
            $flecha=$flecha."    -    ";
        }
        $flecha=$flecha.'  ';
    @endphp
    <option value="{{ $hijo->id }}">{{ $flecha }} &#128193; {{ $hijo->name }}</option>  

    @php
       $hijos = \DB::table('folders AS d1')
        ->where('d1.father_folder_id','=',$hijo->id)
        ->where('d1.departament_id','=',Auth::user()->departament_id)
        ->join('folders AS d2','d2.id','=','d1.father_folder_id')
    ->join('departaments AS d3','d3.id','=','d1.departament_id')
    ->select('d1.*', 'd2.name as father_folder', 'd3.name as departament')
    ->orderBy('updated_at','DESC')
->get();

    @endphp
    @if ($hijos != NULL)
    @php
        $temp= $nivel;
        $nivel++;
       
    @endphp 
    @include('admin.folders.tree',['hijos' => $hijos,'nivel'=>$nivel])   
   
    @php
    
   $nivel=$temp;
@endphp 
    @endif
    @endif
     
    @endforeach