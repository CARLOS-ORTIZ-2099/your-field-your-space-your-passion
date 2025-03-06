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

    $urlCurrent = $_SERVER['PATH_INFO'] ?? 'sin data';
    $user = $_SESSION['user'] ?? null;
    $isAdmin = $_SESSION['user']['is_admin'] ?? null;

    if ($urlCurrent === '/profile/see-fields' && $user && $isAdmin) {
      $isAdmin = 'profile';
    } elseif ($urlCurrent === '/profile/see-fields' && (!$user || !$isAdmin)) {
      header('Location:/');
    }


    $types = Type::get();
    $districts = District::get();
    $router->render('fields/fields.php', [
      'types' => $types,
      'districts' => $districts,
      'isAdmin' => $isAdmin
    ]);
  }

  public static function field($router)
  {
    session_start();
    $fieldId = $_GET['id'] ?? null;
    $reservationId = $_GET['edit'] ?? null;
    if (!$fieldId || !is_numeric($fieldId)) {
      header('Location:/');
    }
    $reservation = null;
    if ($reservationId && !is_numeric($reservationId)) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && !isset($_SESSION['user'])) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['id'];
      $isAdmin = $_SESSION['user']['is_admin'] ?? null;
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
    if (!$field) {
      header('Location:/');
    }
    $router->render('field/field.php', [
      'field' => $field,
      'id' => $_SESSION['user']['id'] ?? null,
      'reservation' => $reservation
    ]);
  }

  public static function createField($router)
  {
    session_start();
    is_auth();
    is_admin('profile');
    $types = Type::get();
    $districts = District::get();
    $field = new Field;
    $messages = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $field = new Field($_POST);
      // validar si llega la imagen y si es valida
      $field->existImage();
      $messages = $field->validateFields();
      if (empty($messages['errors'])) {
        // si todos los campos estan llenos validar la imagen el tipo y el peso de la misma
        $isValid = $field->validateImage();
        if ($isValid) {
          // guardamos la imagen si es valida
          $res = $field->saveImage();
          // si la imagen se guardo correctamente
          if ($res['response']) {
            // setear la propiedad image de la instancia con la url final
            $field->setProperty('image', $res['image']);
            // guardar la publicacion
            $field->save();
          }
          // si no se guardo la imagen
          else {
            Field::setMessage(
              'errors',
              ['badrequest' => 'hubo un error al guardar imagen']
            );
          }
        }
      }
    }
    $messages = Field::getMessages();
    $field = $field->getValues();

    $router->render('field/form-field.php', [
      'types' => $types,
      'districts' => $districts,
      'field' => $field,
      'errors' => $messages['errors'],
      'info' => $messages['info'],
    ]);
  }
}
