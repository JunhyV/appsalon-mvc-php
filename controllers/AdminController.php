<?php

namespace Controller;

use Model\AdminCitas;
use MVC\Router;

class AdminController {
    public static function admin (Router $router) {
        isAdmin();
        $nombre = $_SESSION['nombre'];
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechaValida = explode('-', $fecha);
        $year = $fechaValida[0];
        $month = $fechaValida[1];
        $day = $fechaValida[2];
        
        try {
            $fechaValida = checkdate($month, $day, $year);
        } catch (\Throwable $th) {
            header('Location: /404');
        }

        $consulta = 'SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, " ", usuarios.apellido) as cliente, usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ';
        $consulta .= 'FROM citas ';
        $consulta .= 'INNER JOIN usuarios ON citas.usuarios_id=usuarios.id ';
        $consulta .= 'INNER JOIN citasservicios ON citas.id=citasservicios.citas_id ';
        $consulta .= 'INNER JOIN servicios ON citasservicios.servicios_id=servicios.id ';
        $consulta .= "WHERE fecha = '$fecha';";

        $citas = AdminCitas::SQL($consulta);

        $router->render('admin/admin', [
            'nombre' => $nombre,
            'fecha' => $fecha,
            'citas' => $citas
        ]);
    }
}