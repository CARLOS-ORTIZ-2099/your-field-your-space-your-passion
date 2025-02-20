<?php

namespace Models;


class Field
{


  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }


  public static function get()
  {

    $query = 'SELECT * FROM fields';
    $result =  self::$db->query($query);

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

    return $result;
  }
}
