<form action="" class="form" method="post">
    <div class="form__campo">
        <label for="nombre">Servicio:</label>
        <input type="text" name="nombre" value="<?php echo $servicio->nombre ?>">
    </div>
    <div class="form__campo">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" value="<?php echo $servicio->precio ?>">
    </div>
    <input type="submit" value="Agregar Servicio" class="boton--azul">
</form>
