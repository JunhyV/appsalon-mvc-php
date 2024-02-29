<?php
$validacion = $datos['validacion'];
?>
<div class="page__header">
    <h1>Reestablece tu contraseña</h1>
</div>
<?php
include_once __DIR__ . '/../templates/alertas.php';
?>
<?php
if ($validacion) { ?>
    <form action="" method="post" class="form">
        <div class="form__campo">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Tu password">
        </div>
        <input type="submit" value="Reestablecer password" class="boton--azul">
    </form>
    <div class="page__enlaces">
        <a href="/crear-cuenta">¿No tienes cuenta? Crear cuenta</a>
        <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
<?php } ?>