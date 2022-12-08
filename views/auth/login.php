<h1 class="nombre-pagina">Desde login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>
<?php include_once __DIR__ . '/../templates/alertas.php'?>
<form class="formulario" action="/" method="post" novalidate>
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Email" name="email" required>
  </div>
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
  </div>
  <input type="submit" value="Iniciar Sesion" class="boton">
</form>

<div class="acciones">
  <a href="/crear-cuenta">Crear Cuenta</a>
  <a href="/olvide">Olvidaste tu password</a>
</div>