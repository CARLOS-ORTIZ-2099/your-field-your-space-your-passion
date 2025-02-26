<?php

namespace Models;


class Field
{


  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }


  public static function get($skip, $type = null, $district = null)
  {
    // aqui buscar las lozas deportivas por ditrito y por tipo
    // para no hacer uniones innecesarias comprobar si solo se filtra por distrito o por tipo
    $query = "SELECT fields.* FROM fields";
    // aqui comprobar si llega el type y el district por que puede que el usuario solo halla filtrado por uno de ellos
    // si existen ambos
    if ($type && $district) {
      $query .= "
      INNER JOIN  types
      ON fields.type_id = types.id
      INNER JOIN branches
      ON fields.branch_id = branches.id
      INNER JOIN districts
      ON branches.district_id = districts.id";
      $query .= " WHERE types.id = $type AND districts.id = $district";
    }
    //si solo existe type
    else if ($type) {
      $query .= "
      INNER JOIN  types
      ON fields.type_id = types.id";
      $query .= " WHERE types.id = $type";
    }
    // si solo existe district
    else if ($district) {
      $query .= "
      INNER JOIN branches
      ON fields.branch_id = branches.id
      INNER JOIN districts
      ON branches.district_id = districts.id";
      $query .= " WHERE districts.id = $district";
    }

    if (is_numeric($skip)) {
      $query .= " LIMIT 3 OFFSET {$skip}";
    }
    // debuguear($query);
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    //debuguear($result);
    return $result;
  }


  public static function getOneById($id)
  {

    $query = 'SELECT fields.*, branches.name AS nombre_sucursal, branches.address,
    branches.image, districts.name AS distrito, types.name AS tipo_cancha
    FROM fields 
    INNER JOIN branches 
    ON fields.branch_id = branches.id
    INNER JOIN districts
    ON branches.district_id = districts.id
    INNER JOIN types
    ON fields.type_id = types.id';
    $query .= ' WHERE fields.id = ' . $id;
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return array_shift($result);
  }



  public static function transformData($data)
  {
    $registers = [];
    while ($row = $data->fetch_assoc()) {
      $registers[] = $row;
    }
    return $registers;
  }
}
