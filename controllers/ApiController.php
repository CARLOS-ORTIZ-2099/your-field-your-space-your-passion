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
    $type  = $_GET['type'] ?? null;
    $district  = $_GET['district'] ?? null;
    $fields = Field::get($skip, $type, $district);
    $jsonData = json_encode($fields);
    echo $jsonData;
  }


  // obtiene todas las horas ocupadas de una reserva en una determinada fecha
  public static function getReservations()
  {
    // en este metodo comunicarme con el modelo y que traiga todos las reservas 
    // con una fecha en especifico
    // debuguear($_GET);
    $date = $_GET['date'];
    $field = $_GET['field'];
    $edit = $_GET['edit'] ?? null;
    $reservations = Reservation::get($date, $field, $edit);
    //debuguear($reservations);
    $busyHours = [];
    foreach ($reservations as $reservation) {
      $busyHours[$reservation['start_time']] = $reservation['end_time'];
    }
    // debuguear($busyHours);
    echo json_encode($busyHours);
  }


  // funcion para editar reserva

  public static function updateReservation()
  {
    // aqui recibir la data que mande el usuario para actualizar su reserva
    $id = $_GET['id'];
    $data = $_POST;
    $data['id'] = $id;
    $result = Reservation::updateReservation($data);
    echo json_encode(['result' => $result]);
  }



  // crear reserva 
  public static function saveReservation()
  {
    //cuando le mandamos datos en formato json la superglobal POST no lee esos
    // datos, solo lee los datos que provengan de campos de formularios
    $newReservation = new Reservation($_POST);
    $result = $newReservation->save();
    echo json_encode(['result' => $result]);
  }
}
