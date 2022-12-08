<h2 class="nombre-pagina">Recuperar password</h2>
<p class="descripcion-pagina">Coloca tu nueva password</p>
<?php include_once __DIR__ . '/../templates/alertas.php'?>
<?php if($error) {
  return;
} ?>
<form class="formulario" method="post">
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" placeholder="Password" name="password" required>
  </div>

  <input type="submit" value="Enviar" class="boton">
</form>

<div class="acciones">
  <a href="/">Ya tienes cuenta? Inicia Sesion</a>
  <a href="/">Ya tienes cuenta? Inicia Sesion</a>
</div>