
  @if (auth()->check())
    
       
  <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
    <div class="card-header">Menu</div>

    <div class="card-body bg-light">
        

<div class="list-group">
 

  <a @if (request()->is('EnviarDoc') or request()->is('Editor') )  class="nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
    @else  
    class="nav-link dropdown-toggle list-group-item list-group-item-action active"
    @endif
    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Enviar</a>

  <div class="dropdown-menu">
    <a class="dropdown-item" href="/EnviarDoc">Subir Documento</a>
    <a class="dropdown-item" href="/Editor">Editar Documento</a>
    
    
  </div>
  
  <a  @if (request()->is('Enviados')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif 
  href="/Enviados" class="list-group-item list-group-item-action active">Documentos Enviados</a>

  <a  @if (request()->is('Recibidos')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif 
    href="/Recibidos" class="list-group-item list-group-item-action active">Bandeja de Entrada</a>
<!---
  <a class="nav-link dropdown-toggle list-group-item list-group-item-action active" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Firma Electronica</a>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="/FormFirmarDoc">Firmar Documento</a>
    <a class="dropdown-item" href="/FormValidarDocFirmado">Verificar Firmas Electronicas</a>
  
  </div>
  -->
  <a @if (request()->is('Documentos')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif  
  href="/Documentos/1">Buscar en Repositorio</a>
  @if (auth()->user()->is_admin)

  <a @if (request()->is('carpetas')) class="list-group-item list-group-item-action active bg-dark" @else class="list-group-item list-group-item-action active "@endif  
    href="/carpetas">Gestionar Carpetas</a>

  <a @if (request()->is('usuarios') or request()->is('departamentos') )  class="nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
    @else  
    class="nav-link dropdown-toggle list-group-item list-group-item-action active"
    @endif
    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Opciones de Administracion</a>

  <div class="dropdown-menu">
    <a class="dropdown-item" href="/usuarios">Registrar Usuarios</a>
    <a class="dropdown-item" href="/departamentos">Gestion de departamentos</a>
    
    
  </div>

  
  @endif
 
    
  
  
</div>


</div>
</div>
@endif 

  
  