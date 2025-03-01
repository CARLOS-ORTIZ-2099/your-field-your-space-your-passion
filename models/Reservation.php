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

  public static function getOneReservation($id)
  {
    $query = "SELECT * FROM reservations WHERE id = {$id}";
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return array_shift($result);
  }

  public static function getReservationsUser($id)
  {
    $query = "SELECT reservations.*, fields.name AS field_name, fields.rental_price, types.name AS type_field, 
    branches.name AS branch_name, branches.address, 
    ADDTIME(reservations.start_time, SEC_TO_TIME(reservations.rental_time*3600)) AS end_time
    FROM reservations 
    INNER JOIN fields 
    ON reservations.field_id = fields.id
    INNER JOIN types
    ON fields.type_id = types.id
    INNER JOIN branches
    ON fields.branch_id = branches.id
    WHERE reservations.user_id = {$id}";
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return $result;
  }



  public function save()
  {
    $query = "INSERT INTO reservations (user_id, field_id, total_pay, rental_time, start_time, rental_date) 
    VALUES ({$this->user_id}, {$this->field_id}, {$this->total_pay}, {$this->rental_time}, '{$this->start_time}', '{$this->rental_date}')";
    $result = self::$db->query($query);
    return $result;
  }

  public static function delete($id)
  {
    $query = "DELETE FROM reservations WHERE reservations.id = {$id}";
    $result = self::$db->query($query);
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
