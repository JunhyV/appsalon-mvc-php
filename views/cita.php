<div class="page__header">
    <h1>Crear nueva cita</h1>
    <p>Elige tus servicios y coloca tus datos.</p>
</div>

<?php
include_once __DIR__ . '/templates/nav.php';
?>

<div id="cita-app">
    <div class="tabs">
        <button class="boton--azul tabs--seleccionado" data-paso='1'>Servicios</button>
        <button class="boton--azul" data-paso='2'>Datos</button>
        <button class="boton--azul" data-paso='3'>Resumen</button>
    </div>
    <div class="cita">
        <div class="cita__secciones cita--visible" id="paso-1">
            <h1>Servicios</h1>
            <p>Elige los servicios a continuación</p>
            <div id='servicios' class="servicios"></div>
        </div>
        <div class='cita__secciones' id="paso-2">
            <h1>Datos</h1>
            <p>Coloca los datos para agendar la cita</p>
            <form action="/cita" class="form">
                <div class="form__campo">
                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" value='<?php echo $nombre ?>' disabled>
                    <input type="hidden" id='id' value="<?php echo $id ?>">
                </div>
                <div class="form__campo">
                    <label for="fecha">Fecha: </label>
                    <input type="date" name="fecha" id="fecha" min='<?php
                                                                    date_default_timezone_set('America/Mexico_City');
                                                                    echo date('Y-m-d', strtotime('+1 day')) ?>'>
                </div>
                <div class="form__campo">
                    <label for="hora">Hora: </label>
                    <input type="time" name="hora" id="hora">
                </div>
            </form>
        </div>
        <div class='cita__secciones' id="paso-3">
            <h1>Resumen</h1>
            <div id="resumen"></div>
        </div>
    </div>
    <div class="paginador">
        <button id="anterior" class="boton--azul boton--invisible">&laquo; Anterior</button>
        <button id="siguiente" class="boton--azul">&raquo; Siguiente</button>
    </div>
</div>

<?php
$script = '
</script><script src="build/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
';
