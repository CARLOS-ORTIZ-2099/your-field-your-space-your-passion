<?php

namespace Controllers;

use Models\Field;
use Models\Reservation;

class ApiController
{

  // obtener todos los campos deportivos
  public static function getFields($router)
  {
    // debuguear($_GET);
    $skip = $_GET['skip'] ?? 0;
    // consultar el modelo para traer todos los campos deportivos
    $fields = Field::get($skip);
    // transformar en json el resultado
    $jsonData = json_encode($fields);
    echo $jsonData;
  }


  // obtener por filtro

  public static function getFieldsFilters()
  {
    //debuguear($_GET);
    $skip = $_GET['skip'] ?? 0;
    $type  = $_GET['type'];
    $district  = $_GET['district'];
    $fields = Field::getFields($type, $district, $skip);
    $jsonData = json_encode($fields);
    echo $jsonData;
  }


  // obtener reservas con una determinada fecha

  public static function getReservations()
  {
    // en este metodo comunicarme con el modelo y que traiga todos las reservas
    // con una fecha en especifico
    //debuguear($_GET);
    $date = $_GET['date'];
    $reservations = Reservation::get($date);
    echo json_encode($reservations);
  }
  // CONTINUAR AQUI

  // obtener uno solo


}
