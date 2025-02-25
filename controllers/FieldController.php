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
    $router->render('fields/fields.php');
  }



  public static function field($router)
  {
    session_start();
    // aqui obtnemos el id de la loza deportiva que queremos ver
    //debuguear($_GET);
    $id = $_GET['id'];
    $field = Field::getOneById($id);
    debuguear($field);
    $router->render('field/field.php', [
      'field' => $field
    ]);
  }
}
