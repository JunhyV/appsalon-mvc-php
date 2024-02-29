<?php

namespace Controller;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicios;

class ApiController
{
    public static function servicios()
    {
        $servicios = Servicios::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        //Almacenar la cita
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        if ($resultado) {
            //Almacenar los servicios
            $id = $resultado['id'];
            $idServicios = explode(',', $_POST['servicios']);

            foreach ($idServicios as $idServicio) {
                $args = [
                    'citas_id' => $id,
                    'servicios_id' => $idServicio
                ];

                $citaServicio = new CitaServicio($args);
                $respuesta = $citaServicio->guardar();
            }

            echo json_encode($respuesta);
        }
    }
    public static function eliminarCita(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = s($_POST['id']);

            //Eliminar cita
            $cita = Cita::find($id);
            $cita->eliminar();

            //Eliminar servicios de la cita
            $citaServicio = CitaServicio::whereAll('citas_id', $id);
            foreach ($citaServicio as $cita) {
                $cita->eliminar();
            }
            
            header('Location: /admin');
        }

    }
    public static function eliminarServicio(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = s($_POST['id']);

            //Eliminar cita
            $servicio = Servicios::find($id);
            $servicio->eliminar();
            
            header('Location: /servicios');
        }

    }
}
