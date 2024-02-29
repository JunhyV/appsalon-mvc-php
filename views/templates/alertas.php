<?php
foreach ($alertas as $tipo => $mensajes) :
    foreach ($mensajes as $mensaje) :
        ?>
        <p class="alerta alerta__<?php echo $tipo?>"><?php echo $mensaje?></p>
        <?php
    endforeach;
endforeach;
?>