
  @if (auth()->check())
    
       
  <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
    <div class="card-header">Menu</div>

    <div class="card-body bg-light">
        

<div class="list-group">
  <a  @if (request()->is('EnviarDoc')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif 
  href="/EnviarDoc" >Enviar</a>
  
  <a  @if (request()->is('Enviados')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif 
  href="/Enviados" class="list-group-item list-group-item-action active">Documentos Enviados</a>
  <a class="nav-link dropdown-toggle list-group-item list-group-item-action active" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Firma Electronica</a>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="/FormFirmarDoc">Firmar Documento</a>
    <a class="dropdown-item" href="/FormValidarDocFirmado">Verificar Firmas Electronicas</a>
    
  </div>
  <a @if (request()->is('Documentos')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif  
  href="/Documentos">Buscar en Repositorio</a>
  @if (auth()->user()->is_admin)
  <a @if (request()->is('usuarios'))  class="nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
    @else  
    class="nav-link dropdown-toggle list-group-item list-group-item-action active"
    @endif
    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Opciones de Administracion</a>

  <div class="dropdown-menu">
    <a class="dropdown-item" href="/usuarios">Registrar Usuarios</a>
    
    
  </div>
  @endif
 
    
  
  
</div>


</div>
</div>
@endif 

  
  