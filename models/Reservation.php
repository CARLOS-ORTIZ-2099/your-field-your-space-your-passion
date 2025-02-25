<?php

namespace Models;

class Reservation
{
  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }

  public static function get($date)
  {
    //buscar todas las reservas de esta fecha
    $query = "SELECT * FROM reservations WHERE rental_date = '{$date}'";
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
