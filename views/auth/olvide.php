<div class="page__header">
    <h1>Reestablece tu contraseña</h1>
    <p>Sigue los pasos para reestablecer tu contraseña.</p>
</div>
<?php
include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/olvide" method="post" class="form">
    <div class="form__campo">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Tu Email">
    </div>
    <input type="submit" value="Enviar correo" class="boton--azul">
</form>
<div class="page__enlaces">
    <a href="/crear-cuenta">¿No tienes cuenta? Crear cuenta</a>
    <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
</div>