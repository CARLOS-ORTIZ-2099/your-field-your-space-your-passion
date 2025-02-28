<?php

namespace  Controllers;

use Models\District;
use Models\Field;
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
    // aqui obtnemos el id de la loza deportiva que queremos ver
    //debuguear($_GET);
    $id = $_GET['id'] ?? null;
    // comprobar que sea un id valido y que exista
    if (!$id || !is_numeric($id)) {
      header('Location:/');
      // debuguear('no valido');
    }
    $field = Field::getOneById($id);
    //debuguear($field);
    if (!$field) {
      header('Location:/');
    }
    $router->render('field/field.php', [
      'field' => $field,
      'id' => $_SESSION['user']['id'] ?? null
    ]);
  }
}
