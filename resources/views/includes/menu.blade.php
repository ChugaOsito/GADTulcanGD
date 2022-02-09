@if (auth()->check())
<!--Inicio SuperAdmin-->
@if(auth()->user()->is_superadmin)
<aside class="col-12 col-md-2 p-0 bg-light border flex-shrink-1">
  
  <div class="list-group">


    <a  @if (request()->is('Dashboard')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
      href="/Dashboard" class="list-group-item list-group-item-action active">Dashboard</a>
  
    <a  @if (request()->is('usuarios')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
      href="/usuarios" class="list-group-item list-group-item-action active">Gestionar Usuarios</a>

      <a  @if (request()->is('departamentos')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
        href="/departamentos" class="list-group-item list-group-item-action active">Gestionar Organigrama</a>
    
        <div class="list-group">
 

          <a @if (request()->is('cargos') or request()->is('tratamientos') )  class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
            @else  
            class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active"
            @endif
            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Otras Configuraciones</a>
        
          <div class="border rounded bg-primary dropdown-menu">
            <a class="dropdown-item text-white" href="/size/1">Configurar Tamaño de Subida de Doumentos</a>
            <a class="dropdown-item text-white" href="/tipos">Agregar tipos de documentos</a>
            <a class="dropdown-item text-white" href="/cargos">Agregar Cargos</a>
            <a class="dropdown-item text-white" href="/tratamientos">Agregar Tratamientos o Titulos Academicos</a>
          </div>
   
   
      
  </div>
</aside>
<!--Fin SuperAdmin-->
@else
<aside class="col-12 col-md-2 p-0 bg-light border flex-shrink-1">
  
    <div class="list-group">
 

      <a @if (request()->is('EnviarDoc') or request()->is('Editor') )  class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active bg-dark" 
        @else  
        class=" border rounded nav-link dropdown-toggle list-group-item list-group-item-action active"
        @endif
        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Enviar</a>
    
      <div class="border rounded bg-primary dropdown-menu">
        <a class="dropdown-item text-white" href="/EnviarDoc">Subir Documento</a>
        <a class="dropdown-item text-white" href="/Editor">Redactar Documento</a>
        
        
      </div>
      <a  @if (request()->is('Procesos')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
        href="/Procesos" class="list-group-item list-group-item-action active">Procesos</a>

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
     
    @if (auth()->user()->is_DepartamentBoss)
    <a @if (request()->is('carpetas')) class="border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif  
      href="/carpetas">Gestionar Carpetas</a>    
      <a  @if (request()->is('DescargarZip')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
        href="/DescargarCopia" class="list-group-item list-group-item-action active">Descargar copias de informacion</a>
    @endif
  
    @if (auth()->user()->is_admin)
     <a  @if (request()->is('usuarios')) class=" border rounded list-group-item list-group-item-action active bg-dark" @else class="border rounded list-group-item list-group-item-action active "@endif 
      href="/usuarios" class="list-group-item list-group-item-action active">Gestionar Usuarios</a>

     
    
      
      @endif
     
        
    </div>
</aside>
@endif
@endif