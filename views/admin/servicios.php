<div class="page__header">
    <h1>Administración de servicios</h1>
</div>

<?php
include_once __DIR__ . '/../templates/nav.php';
?>

<div class="tabs">
    <a href="/admin" class="boton--azul">Citas</a>
    <a href="/servicios" class="boton--azul">Servicios</a>
    <a href="/servicios/crear" class="boton--azul">Nuevo servicio</a>
</div>

<ul class="lista-servicios">
    <?php
    foreach ($servicios as $servicio) : ?>
        <li class="lista-servicios__li">
            <p class="lista-servicios__p">Servicio: <span class="lista-servicios__span"> <?php echo $servicio->nombre?></span></p>
            <p class="lista-servicios__p">Precio: <span class="lista-servicios__span"><?php echo $servicio->precio?></span></p>
            <div class="lista-servicios__botones">
                <a href="servicios/actualizar?id=<?php echo $servicio->id?>" class="boton--azul">Actualizar</a>
                <form action="api/eliminar-servicio" method="post">
                    <input type="hidden" name="id" value="<?php echo $servicio->id?>">
                    <input class="boton--rojo" type="submit" value="Eliminar">
                </form>
            </div>
        </li>
    <?php endforeach ?>
</ul>