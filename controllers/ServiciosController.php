<?php

namespace Controller;

use Model\Servicios;
use MVC\Router;

class ServiciosController{
    public static function servicios(Router $router){
        isAdmin();

        $nombre = $_SESSION['nombre'];
        $servicios = Servicios::all();

        $router->render('admin/servicios', [
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);
    }
    public static function crear(Router $router){
        isAdmin();

        $nombre = $_SESSION['nombre'];
        $servicio =  new Servicios;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = new Servicios($_POST);
            $alertas = $servicio->validarServicio();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $router->render('admin/crear', [
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
    public static function actualizar(Router $router){
        isAdmin();

        $nombre = $_SESSION['nombre'];
        $id = $_GET['id'];
        $servicio =  Servicios::find($id);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = new Servicios($_POST);
            $servicio->id = $id;
            $alertas = $servicio->validarServicio();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        
        $router->render('admin/actualizar', [
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
}