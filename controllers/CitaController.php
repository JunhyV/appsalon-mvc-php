<?php
namespace Controller;

use MVC\Router;

class CitaController{
    public static function index(Router $router){
        isAuth();
        $nombre = $_SESSION['nombre'];
        $id = $_SESSION['id'];
        $router->render('cita', [
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}