<h1 class="nombre-pagina">Olvidaste password</h1>
<p class="descripcion-pagina">Escribe tu correo</p>
<?php include_once __DIR__ . '/../templates/alertas.php'?>
<form class="formulario" action="/olvide" method="post">
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Email" name="email" required>
  </div>

  <input type="submit" value="Iniciar Sesion" class="boton">
</form>

<div class="acciones">
  <a href="/">Ya tienes cuenta? Inicia Sesion</a>
  <a href="/">Ya tienes cuenta? Inicia Sesion</a>
</div>