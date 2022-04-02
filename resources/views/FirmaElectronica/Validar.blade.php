@extends('layouts.app')

@section('content')
<div class="card text-white bg-primary border-primary mb-3" style="max-width: 100rem;">

            
                <div class="card-header">Datos del Firmante </div>

                <div class="card-body bg-light text-black">
                  @if ($datos==null)
                  

<div class="alert alert-dismissible alert-warning">
  
  <h4 class="alert-heading">Lo sentimos</h4>
  <p class="mb-0">No se han encontrado firmas electrónicas en este documento <a href="javascript:history.back()" class="alert-link"> Volver</a>.</p>
</div>


                  
                    
                 @else
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Fecha de Firmado</th>
                        <th>Firma</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($datos as $dato )
                      <tr>
                        
                        <td>{{ $dato['cedula'] }}</td>
                        <td>{{ $dato['nombre'] }}</td>
                        <td>{{ $dato['fecha_Firmado'] }}</td>
                        @if ($dato['validez']==true)
                        <td>Válida</td>
                        @else
                        <td> Inválida</td>
                        @endif
                        
                      </tr>    
                      @endforeach
                    
                      
                    </tbody>
                  </table>
                  @endif
</div>
</div>
</div>
@endsection
    