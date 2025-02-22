<?php

namespace  Controllers;

use Models\Field;


class FieldController
{

  public static function fields($router)
  {
    // aqui debemos comunicarnos con el modelo
    // devuelve un array de arrays asociativos donde cada array representa
    // un campo deportivo
    session_start();

    // capturar tipo y distrito para buscar por dichos criterios
    $type = $_GET['type'] ?? '';
    $district = $_GET['district'] ?? '';
    if ($type && $district) {
      debuguear($_GET);
      Field::getFieldsFilters($type, $district);
      $fields = '';
    } else {
      $fields = Field::get();
    }


    $router->render('fields/fields.php', [
      'fields' => $fields
    ]);
  }

  public static function field($router)
  {
    session_start();
    // aqui obtnemos el id de la loza deportiva que queremos ver
    //debuguear($_GET);
    $id = $_GET['id'];
    $field = Field::getOneById($id);
    //debuguear($field);
    $router->render('field/field.php', [
      'field' => $field
    ]);
  }
}
