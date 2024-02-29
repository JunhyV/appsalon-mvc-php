<?php
$usuario = $datos['usuario'];
?>
<div class="page__header">
    <h1>Registro</h1>
    <p>Ingresa tus datos para crear una cuenta.</p>
</div>
<?php
include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/crear-cuenta" method="post" class="form">
    <div class="form__campo">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre)?>">
    </div>
    <div class="form__campo">
        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido)?>">
    </div>
    <div class="form__campo">
        <label for="telefono">Teléfono: </label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu Teléfono" value="<?php echo s($usuario->telefono)?>">
    </div>
    <div class="form__campo">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo s($usuario->email)?>">
    </div>
    <div class="form__campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>
    <input type="submit" value="Registrarme" class="boton--azul">
</form>
<div class="page__enlaces">
    <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>