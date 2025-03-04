<?php

namespace  Controllers;

use Models\District;
use Models\Field;
use Models\Reservation;
use Models\Type;

class FieldController
{

  public static function fields($router)
  {
    session_start();
    $types = Type::get();
    $districts = District::get();
    $router->render('fields/fields.php', [
      'types' => $types,
      'districts' => $districts
    ]);
  }



  public static function field($router)
  {
    session_start();
    $id = $_GET['id'] ?? null;
    $edit = $_GET['edit'] ?? null;

    if (!$id || !is_numeric($id)) {
      header('Location:/');
      // debuguear('no valido');
    }
    $reservation = null;
    if ($edit && !is_numeric($edit)) {
      header('Location:/');
    } 
    elseif($edit && is_numeric($edit) && !isset($_SESSION['user'])){
      header('Location:/');
    }
    elseif ($edit && is_numeric($edit) && isset($_SESSION['user'])) {
      $id_user = $_SESSION['user']['id'] ;
      $reservation = Reservation::getOneReservation($edit, $id, $id_user);
      if (!$reservation) {
        header('Location:/');
      }
    }

    $field = Field::getOneById($id);
    //debuguear($field);
    if (!$field) {
      header('Location:/');
    }
    $router->render('field/field.php', [
      'field' => $field,
      'id' => $_SESSION['user']['id'] ?? null,
      'reservation' => $reservation
    ]);
  }
}
