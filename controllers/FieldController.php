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
    //$id = $_GET['id'] ?? null;
    $fieldId = $_GET['id'] ?? null;
    //$edit = $_GET['edit'] ?? null;
    $reservationId = $_GET['edit'] ?? null;
    if (!$fieldId || !is_numeric($fieldId)) {
      header('Location:/');
      // debuguear('no valido');
    }
    $reservation = null;
    if ($reservationId && !is_numeric($reservationId)) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && !isset($_SESSION['user'])) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['id'];
      // capturar si el usuario actual es admin
      $isAdmin = $_SESSION['user']['is_admin'] ?? null;
      // dependiendo si el usuario es admin o no haremos una u otra query
      if ($isAdmin) {
        $reservation = Reservation::getOneReservation(
          $reservationId,
          $fieldId
        );
      } else {
        $reservation = Reservation::getOneReservation(
          $reservationId,
          $fieldId,
          $userId
        );
      }

      if (!$reservation) {
        header('Location:/');
      }
    }

    $field = Field::getOneById($fieldId);
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
