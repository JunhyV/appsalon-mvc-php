<div class="page__header">
    <h1>Crear nuevo servicio</h1>
</div>

<?php
include_once __DIR__ . '/../templates/nav.php';
?>

<div class="tabs">
    <a href="/admin" class="boton--azul">Citas</a>
    <a href="/servicios" class="boton--azul">Servicios</a>
    <a href="/servicios/crear" class="boton--azul">Nuevo servicio</a>
</div>

<?php
include_once __DIR__ . '/../templates/alertas.php';
include_once __DIR__ . '/../admin/formulario.php';
?>