<div class="page__header">
    <h1>Iniciar sesión</h1>
    <p>Ingresa tus datos para iniciar sesión.</p>
</div>
<?php
include_once __DIR__ . '/../templates/alertas.php';
$auth = $datos['auth'];
?>
<form action="/" method="post" class="form">
    <div class="form__campo">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo s($auth->email)?>">
    </div>
    <div class="form__campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>
    <input type="submit" value="Ingresar" class="boton--azul">
</form>
<div class="page__enlaces">
    <a href="/crear-cuenta">¿No tienes cuenta? Crear cuenta</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>