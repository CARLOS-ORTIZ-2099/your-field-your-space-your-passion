<?php

namespace Models;

class Branch
{


  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }

  public static function get()
  {
    $query = 'SELECT * FROM branches ';
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return $result;
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
