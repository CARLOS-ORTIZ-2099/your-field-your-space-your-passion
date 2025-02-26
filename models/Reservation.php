<?php

namespace Models;

class Reservation
{

  protected $user_id;
  protected $field_id;
  protected $total_pay;
  protected $rental_time;
  protected $start_time;
  protected $rental_date;

  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }

  public function __construct($arguments = [])
  {
    $this->user_id = $arguments['user_id'] ?? null;
    $this->field_id = $arguments['field_id'] ?? null;
    $this->total_pay = $arguments['total_pay'] ?? null;
    $this->rental_time = $arguments['rental_time'] ?? null;
    $this->start_time = $arguments['start_time'] ?? null;
    $this->rental_date = $arguments['rental_date'] ?? null;
  }

  public static function get($date, $field)
  {
    //buscar todas las reservas de una determinada fecha de un determinado campo deportivo
    $query = "SELECT start_time, rental_time, 
    ADDTIME(start_time, SEC_TO_TIME(rental_time*3600)) 
    AS end_time FROM reservations 
    WHERE rental_date = '{$date}' AND field_id = $field
    ORDER BY start_time ASC
    ";
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
