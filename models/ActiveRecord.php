<?php

namespace Models;

class ActiveRecord
{
  // esta clase sera el padre de otras clases, este heredada metodos comunes
  // como crear, leer, actualizar, eliminar para reutilizar logica comun
  // entre clases
  protected static $table = '';
  protected static $columns = [];
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

  public static function doQuery($sql, $types, $values, $get = false)
  {
    $stmt = self::$db->prepare($sql);
    $stmt->bind_param($types, ...$values);
    $result = $stmt->execute();
    if ($get) {
      $result = $stmt->get_result();
    }
    $stmt->close();
    return $result;
  }

  public function insertOne($types)
  {
    $columns = implode(',', static::$columns);
    $charMul = rtrim(str_repeat('?,', count(static::$columns)), ',');
    $values = $this->generateValues();
    //debuguear($values);
    $query = "INSERT INTO " . static::$table . "(" . $columns . ") ";
    $query .= "VALUES (" . $charMul . ")";
    //debuguear($query);
    //die();
    $result = self::doQuery($query, $types, $values);
    return $result;
  }

  public static function deleteOne($id)
  {
    $query = "DELETE FROM " . static::$table . " WHERE id = ?;";
    $types = "i";
    $values = [$id];
    $result = self::doQuery($query, $types, $values);
    return $result;
  }

  public function updateOne($types, $id)
  {
    $fields = $this->generateFieldsToSet();
    $query = "UPDATE " . static::$table . " SET " . $fields . " WHERE id = ?";
    $values = $this->generateValues();
    $values[] = $id;
    $result = self::doQuery($query, $types, $values);
    return $result;
  }

  public function generateFieldsToSet()
  {
    $char = "";
    foreach (static::$columns as $values) {
      //debuguear($values);
      $char .= $values . "=?,";
    }
    return rtrim($char, ',');
  }


  public function generateValues()
  {
    $data = [];
    // iteramos el arreglo de columnas 
    foreach (static::$columns as $values) {
      $data[] = $this->$values;
    }
    return $data;
  }
}
