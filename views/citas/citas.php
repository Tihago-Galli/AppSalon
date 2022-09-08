<h1 class="nombre__app">Crear cita</h1>

<div class="barra">
    <p>Hola: <?php echo $nombre ?? '' ?></p>

    <a class="boton" href="/logout">Cerrar Sesion</a>
</div>
<div id="app">

    <div class="tabs">
        <button class="boton-seccion actual" data-paso="1">Servicios</button>
        <button class="boton-seccion " data-paso="2">Informacion cita</button>
        <button class="boton-seccion " data-paso="3">Resumen</button>
    </div>
    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
 
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div class="seccion" id="paso-2">
        <h2>Tus datos</h2>
      
        <form class="formulario">
        <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text"  name="nombre" id="nombre" value="<?php echo $nombre ?>" disabled>
    </div>
    <div class="campo">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day ')); ?>">
    </div>
    <div class="campo">
        <label for="hora">Hora</label>
        <input type="time"name="hora" id="hora">
    </div>
    <input type="hidden" id="id" value="<?php echo $id?>">
        </form>
    </div>

    <div class="seccion contenedor-resumen" id="paso-3">
        <h2>Resumen</h2>
        <P class="text-center">Verifica que todos los datos esten correctamente</P>
    </div>

    <div class="paginacion">
        <button class="boton-seccion btn-paginacion" id="anterior">&laquo; Anterior</button>
        <button class="boton-seccion btn-paginacion" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php $script = " 
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script> "

?>