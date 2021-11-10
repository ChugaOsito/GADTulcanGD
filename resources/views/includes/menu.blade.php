@if (auth()->check())
<aside class="col-12 col-md-2 p-0 bg-light border flex-shrink-1">
  
    <div class="list-group">
 

      <a @if (request()->is('EnviarDoc') or request()->is('Editor') )  class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
        @else  
        class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active"
        @endif
        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Enviar</a>
    
      <div class="border rounded bg-primary dropdown-menu">
        <a class="dropdown-item text-white" href="/EnviarDoc">Subir Documento</a>
        <a class="dropdown-item text-white" href="/Editor">Editar Documento</a>
        
        
      </div>
      
      <a  @if (request()->is('Enviados')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
      href="/Enviados" class="list-group-item list-group-item-action active">Documentos Enviados</a>
    
      <a  @if (request()->is('Recibidos')) class="border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
        href="/Recibidos" class="list-group-item list-group-item-action active">Bandeja de Entrada</a>
    <!---
      <a class="nav-link dropdown-toggle list-group-item list-group-item-action active" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Firma Electronica</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="/FormFirmarDoc">Firmar Documento</a>
        <a class="dropdown-item" href="/FormValidarDocFirmado">Verificar Firmas Electronicas</a>
      
      </div>
      -->
      <a @if (request()->is('Documentos/1')) class="border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif  
      href="/Documentos/1">Buscar en Repositorio</a>
      @if (auth()->user()->is_admin)
    
      <a @if (request()->is('carpetas')) class="border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif  
        href="/carpetas">Gestionar Carpetas</a>
    
      <a @if (request()->is('usuarios') or request()->is('departamentos') )  class="border rounded nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
        @else  
        class="border rounded  nav-link dropdown-toggle list-group-item list-group-item-action active"
        @endif
        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Opciones de Administracion</a>
    
      <div class="border rounded bg-primary dropdown-menu">
        <a class="dropdown-item text-white" href="/usuarios">Registrar Usuarios</a>
        <a class="dropdown-item text-white" href="/departamentos">Gestion de departamentos</a>
        
        
      </div>
    
      
      @endif
     
        
  </nav>
</aside>
@endif