<?php

namespace Models;

class ActiveRecord
{
  // esta clase sera el padre de otras clases, este heredada metodos comunes
  // como crear, leer, actualizar, eliminar para reutilizar logica comun
  // entre clases
  protected static $table = '';
  protected static $db;
  protected static  $messages = [
    'errors' => [],
    'info' => []
  ];

  public static function setDb($connect)
  {
    // aqui es indistinto si le ponemos static o self ya que este metodo no
    // sera llamado desde una clase hija por lo cual no hace falta hacer 
    // cautelosos con la referencia, ya que esta conexion solo deberia establecerse una sola vez
    self::$db = $connect;
  }

  public static function find()
  {

    $query = "SELECT * FROM " . static::$table;
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return $result;
  }

  public static function findOne($key, $value)
  {
    $query = "SELECT * FROM " . static::$table . " WHERE {$key} = '{$value}'";
    $result = self::$db->query($query);
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

  // getter para los mensajes
  public static function setMessage($type, $data)
  {
    self::$messages[$type] = $data;
    //debuguear(self::$messages);
  }
  // setter para los mensajes
  public static function getMessages()
  {
    return self::$messages;
  }

  // getter para una propiedad
  public function getProperty($property)
  {
    //debuguear($this);
    $res = $this->$property;
    return $res;
  }
  // setter para una propiedad
  public function setProperty($property, $value)
  {
    $this->$property = $value;
  }
  // getter para todas las propiedades
  public function getValues()
  {
    //debuguear($this);
    return get_object_vars($this);
  }

  public function resetear()
  {
    foreach (get_object_vars($this) as $key => $value) {
      $this->$key = null;
    }
  }
}
