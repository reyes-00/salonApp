<?php
namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class ApiController{
  
  public static function index(){
    $servicios = Servicio::all();
    echo json_encode($servicios);
  }
  public static function guardar(){

    // Almacena la cita y devuelve el servicio
     $cita = new Cita($_POST);
     $resultado = $cita->guardar();
     $id = $resultado['id'];
    // Almacena los servicios con el id de la cita
    $idServicios = explode(",", $_POST['servicios']);
    foreach($idServicios as $idServicio){
      debuguear($idServicios);
      $args = [
        'cita_id' => $id,
        'servicio_id' => $idServicio
        ];  
        debuguear($args);
      $citaServicio = new CitaServicio($args);
      $citaServicio->guardar();
    }
    // Retornamos una respusta
    $respuesta = ['resultado'=> $resultado];
    // $respuesta = ['resultado'=> $resultado];
    
    echo json_encode($respuesta);
  }
}

?>