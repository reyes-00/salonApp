<h2 class="nombre-pagina">Crear cita</h2>
<p class="descripcion-pagina">Elige tus servicios a continuatión</p>
<div class="app">
  <nav class="tabs">
    <button type="button" class="actual" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Infromacion cita</button>
    <button type="button" data-paso="3">Resumen</button>
  </nav>
  <div id="paso-1" class="seccion">
    <h2>Servicios</h2>
    <p class="text-center">Elige tus servicios a continuatión</p>
    <div id="servicios" class="listado-servicios"></div>
  </div>
  <div id="paso-2" class="seccion">
    <h2>Tus Datos y cita</h2>
    <p class="text-center">Coloca tus datos y fecha de tu cita</p>
    <form action="" class="formulario">
      <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre?>" disabled>
      </div>
      <div class="campo">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d',strtotime('+1 day')); ?>">
      </div>
      <div class="campo">
        <label for="hora">Hora</label>
        <input type="time" name="hora" id="hora">
      </div>
      <input type="hidden" id="id" value="<?php echo $id; ?>">
    </form>
    <div id="servicios" class="listado-servicios"></div>
  </div>
  <div id="paso-3" class="seccion contenido-resumen">
    <h2>Resumen</h2>
    <p class="text-center">Verfica que la informacion sea correcta</p>
    <div id="servicios" class="listado-servicios"></div>
  </div>
  <div class="paginacion">
    <button id="anterior" class="boton">
      &laquo; Anterior
    </button>
    <button id="siguiente" class="boton">
      Siguiente &raquo;
    </button>
  </div>
</div>

<?php $script = "
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
"?>