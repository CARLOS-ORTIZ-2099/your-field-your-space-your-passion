<?php

namespace Models;

class Reservation extends ActiveRecord
{

  protected $user_id;
  protected $field_id;
  protected $total_pay;
  protected $rental_time;
  protected $start_time;
  protected $rental_date;

  protected static $table = 'reservations';
  protected static $columns = ['user_id', 'field_id', 'total_pay', 'rental_time', 'start_time', 'rental_date'];

  public function __construct($arguments = [])
  {
    $this->user_id = $arguments['user_id'] ?? null;
    $this->field_id = $arguments['field_id'] ?? null;
    $this->total_pay = $arguments['total_pay'] ?? null;
    $this->rental_time = $arguments['rental_time'] ?? null;
    $this->start_time = $arguments['start_time'] ?? null;
    $this->rental_date = $arguments['rental_date'] ?? null;
  }

  // obtiene todas las horas ocupadas de una reserva en una determinada fecha
  public static function get($date, $field, $edit)
  {
    $types = 'si';
    $values = [$date, $field];
    //buscar todas las reservas de una determinada fecha de un determinado campo deportivo
    $query = "SELECT start_time, rental_time, ADDTIME(start_time, SEC_TO_TIME(rental_time*3600)) AS end_time 
    FROM reservations 
    WHERE rental_date = ? AND field_id = ?";

    if ($edit) {
      $query .= " AND id != ?";
      $types .= 'i';
      $values[] = $edit;
    }
    $query .= " ORDER BY start_time ASC";
    $result = self::doQuery($query, $types, $values, true);
    $result = self::transformData($result);
    return $result;
  }

  // obtiene todas las reservas del usuario con uniones de otras tablas
  public static function getReservationsUser($id, $admin = null)
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
    ON fields.branch_id = branches.id";
    if (!$admin) {
      $query .= " WHERE reservations.user_id = {$id}";
    }
    $result =  self::$db->query($query);
    $result = self::transformData($result);
    return $result;
  }

  // obtiene una sola reserva segun id
  public static function getOneReservation($reservationId, $fieldId, $userId = null)
  {
    $types = "ii";
    $values = [$reservationId, $fieldId];

    $query = "SELECT * FROM reservations WHERE id = ? AND field_id = ?";
    if ($userId) {
      $query .= " AND user_id = ?";
      $types .= "i";
      $values[] = $userId;
    }

    $result = self::doQuery($query, $types, $values, true);
    $result = self::transformData($result);
    return array_shift($result);
  }

  public static function updateReservation($data, $isAdmin = null)
  {
    $types = 'ssii';
    $values = [
      $data["rental_date"],
      $data["start_time"],
      $data["id"],
      $data["field_id"]
    ];

    $query = "UPDATE reservations set rental_date = ?, start_time = ? 
    WHERE id = ? AND field_id = ?";

    if (!$isAdmin) {
      $query .= " AND user_id = ?";
      $types .= 'i';
      $values[] = $data["user_id"];
    }

    $result = self::doQuery($query, $types, $values);
    return $result;
  }

  public function save()
  {
    $types = "iidsss";
    $result = $this->insertOne($types);
    return $result;
  }

  public static function delete($id)
  {
    $result = self::deleteOne($id);
    return $result;
  }
}
