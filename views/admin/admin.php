<div class="page__header">
    <h1>Administración de cita</h1>
</div>

<?php
include_once __DIR__ . '/../templates/nav.php';
?>

<div class="tabs">
    <a href="/admin" class="boton--azul">Citas</a>
    <a href="/servicios" class="boton--azul">Servicios</a>
    <a href="/servicios/crear" class="boton--azul">Nuevo servicio</a>
</div>
<form action="">
    <div class="form__campo">
        <label for="fecha">Fecha: </label>
        <input type="date" id="fecha" value="<?php echo $fecha ?>" min="<?php echo date('Y-m-d') ?>">
    </div>
</form>
<ul class="citas">
    <?php
    if (empty($citas)) { ?>
        <h2>No hay citas este día</h2> <?php 
        } else {
        $idCita = 0;

        foreach ($citas as $key => $cita) :
            $hora = explode(':', $cita->hora);
            $hora = "$hora[0]:$hora[1]";

            if ($cita->id !== $idCita) { ?>
            <li class="citas__li">
                <p class="citas__p">ID: <span class="citas__span"><?php echo $cita->id ?></span></p>
                <p class="citas__p">Hora: <span class="citas__span"><?php echo $hora ?></span></p>
                <p class="citas__p">Cliente: <span class="citas__span"><?php echo $cita->cliente ?></span></p>
                <p class="citas__p">Email: <span class="citas__span"><?php echo $cita->email ?></span></p>
                <p class="citas__p">Telefono: <span class="citas__span"><?php echo $cita->telefono ?></span></p>
                <p class="citas__p">Servicios </p>
                <ol> <?php 
                $idCita = $cita->id;
                $total = 0;
            } ?>

            <li class="citas__li--servicios"><?php echo $cita->servicio . ' ' . $cita->precio ?></li> <?php
            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id ?? 0;

            $total += $cita->precio;
            if ($actual !== $proximo) { ?>
            </ol>
                <p class="citas__p">Total: <span class="citas__span"><?php echo "$" . $total?></span></p>
                <form action="api/eliminar-cita" method="post">
                    <input type="hidden" name='id' value="<?php echo $cita->id?>">
                    <input class="boton--rojo" type="submit" value="Cancelar">
                </form><?php
            }
        endforeach;
    } ?>
</ul> <?php 
$script = '</script><script src="build/js/buscador.js"></script>';