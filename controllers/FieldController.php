<?php

namespace  Controllers;

use Models\Branch;
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


    $types = Type::find();
    $districts = District::find();
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
    $isAdmin = $_SESSION['user']['is_admin'] ?? null;
    if ($reservationId && !is_numeric($reservationId)) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && !isset($_SESSION['user'])) {
      header('Location:/');
    } elseif ($reservationId && is_numeric($reservationId) && isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['id'];
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
      'reservation' => $reservation,
      'isAdmin' => $isAdmin,
      'reservationId' => $reservationId
    ]);
  }

  public static function createField($router)
  {
    session_start();
    is_auth();
    is_admin('profile');
    $types = Type::find();
    // aqui deberiamos sacar las sucursales no los distritos
    // ya que las sucursales ya traen consigo los distritos
    //$districts = District::get();
    $branches = Branch::find();
    $field = new Field;
    $messages = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $field = new Field($_POST);
      //debuguear($field);
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
            // setear las horas corregidas
            $correctedHours = correctHours($_POST['opening_hours'], $_POST['closing_time']);
            $field->setProperty('opening_hours', $correctedHours['opening_hours']);
            $field->setProperty('closing_time', $correctedHours['closing_time']);
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
      'branches' => $branches,
      'field' => $field,
      'errors' => $messages['errors'],
      'info' => $messages['info'],
    ]);
  }


  public static function editField($router)
  {
    session_start();
    is_auth();
    is_admin('profile');
    $types = Type::find();
    //$districts = District::get();
    $branches = Branch::find();
    $field = new Field;
    $messages = [];

    $idField = $_GET['id'] ?? null;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if ($idField && is_numeric($idField)) {
        // buscar en la db
        $field = Field::findOne('id', $idField);
        $previousImage = $field['image'];
        // borrar la imagen del sistema local
        deleteImage($previousImage);
        // si no existe redireccionar
        if (!$field) {
          header('Location: /profile/see-fields');
        }
      } else {
        header('Location: /profile/see-fields');
      }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $field = new Field($_POST);
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
            // setear las horas corregidas
            $correctedHours = correctHours($_POST['opening_hours'], $_POST['closing_time']);
            $field->setProperty('opening_hours', $correctedHours['opening_hours']);
            $field->setProperty('closing_time', $correctedHours['closing_time']);
            // editar la publicacion
            //debuguear($field);
            $field->edit($idField);
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
      $field = $field->getValues();
    }
    $messages = Field::getMessages();


    $router->render('field/form-field.php', [
      'types' => $types,
      'branches' => $branches,
      'field' => $field,
      'errors' => $messages['errors'],
      'info' => $messages['info']
    ]);
  }

  public static function deleteField($router)
  {
    session_start();
    is_auth();
    is_admin('profile');
    $previousRoute = '/profile/see-fields';
    $field = Field::findOne('id', $_POST['id']);
    $result = Field::delete($_POST['id']);
    if ($result) {
      // si se elimino correctamente , elimnar la imagen asociada a ese campo
      deleteImage($field['image']);
      header('Location:' . $previousRoute);
    }
  }
}
