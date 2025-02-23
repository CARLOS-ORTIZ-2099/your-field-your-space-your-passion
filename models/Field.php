<?php

namespace Models;


class Field
{


  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }


  public static function get($limit)
  {

    $query = 'SELECT * FROM fields ';
    if ($limit) {
      $query .= $limit;
    }
    //debuguear($query);
    // esto devuelve un objeto de consulta
    // debemos hacer que "transforme" la data en formato legible
    // para mandarselo al controlador y este posteriormente la mande al 
    // cliente
    $result =  self::$db->query($query);
    // procesar la data y convertirlo en un array de objetos
    $result = self::transformData($result);
    return $result;
  }

  public static function getFieldsFilters($type, $district)
  {
    // CONTINUAR AQUI
    // aqui buscar las lozas deportivas por ditrito y por tipo
    $query = "SELECT fields.*, branches.district_id AS ID_DISTRITO, districts.id AS ID_DISTRITO_TABLA, districts.name AS NOMBRE_DISTRITO FROM fields 
      INNER JOIN  types
      ON fields.type_id = types.id
      INNER JOIN branches
      ON fields.branch_id = branches.id
      INNER JOIN districts
      ON branches.district_id = districts.id
      WHERE types.id = $type AND districts.id = $district;";
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
