<?php

namespace Controllers;

use Models\Field;

class ApiController
{

  // obtener todos los campos deportivos
  public static function getFields($router)
  {
    // debuguear($_GET);
    $skip = $_GET['skip'] ?? 0;
    // consultar el modelo para traer todos los campos deportivos
    $fields = Field::get("LIMIT 3 OFFSET {$skip}");
    // transformar en json el resultado
    $jsonData = json_encode($fields);
    echo $jsonData;
  }


  // obtener por filtro


  // obtener uno solo


}
