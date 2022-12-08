<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Registrate</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<form class="formulario" action="/crear-cuenta" method="post" novalidate>
  <div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" placeholder="Nombre" name="nombre" required
      value="<?php echo s($usuario->nombre); ?>">
  </div>


  <div class="campo">
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" placeholder="Apellido" name="apellido" required
      value="<?php echo s($usuario->apellido); ?>">
  </div>
  <div class="campo">
    <label for="telefono">Telefono</label>
    <input type="number" id="telefono" placeholder="Telefono" name="telefono" required
      value="<?php echo s($usuario->telefono); ?>">
  </div>
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Email" name="email" required value="<?php echo s($usuario->email); ?>">
  </div>
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
  </div>
  <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
  <a href="/">Ya tienes cuenta? Inicia Sesion</a>
  <a href="/olvide">Olvidaste tu password</a>
</div>