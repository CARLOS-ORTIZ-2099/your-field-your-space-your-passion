<?php

namespace  Controllers;

use Models\Field;


class FieldController
{

  public static function getFields($router)
  {
    // aqui debemos comunicarnos con el modelo
    $fields = Field::get();

    $router->render('fields/fields.php', $fields);
  }

  public static function getField($router)
  {
    // aqui obtnemos el id de la loza deportiva que queremos ver
    //debuguear($_GET);
    $id = $_GET['id'];
    $field = Field::getOneById($id);
    // aqui debemos comunicarnos con el modelo


    $router->render('field/field.php', $field);
  }
}
