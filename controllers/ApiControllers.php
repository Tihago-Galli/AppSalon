<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicios;

class ApiControllers{
    public static function index(){
        //traemos todos los servicios y los tranformamos en json para leercons con fetchAPI
        $servicios = Servicios::all();

        echo json_encode($servicios);
    }

    public static function guardar(){
        //almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        //almacenamos el id con los que se guardo en memoria
        $id = $resultado['id'];



        //Almacena los servicios con el id de la cita
        //explode separa los valores con una coma
        $idServicios = explode(",", $_POST['servicios']);
        
        //iteramos por cada servicio guardado en memoria
        foreach($idServicios as $idServicio){
            //asignamos a la cita cada uno de los servicios solicitados
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            //Con el Foreach vamos a ir guardando cada uno de los servicios con la referencia de la cita
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

       //retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }
}
?>