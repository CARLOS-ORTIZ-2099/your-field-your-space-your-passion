<?php

namespace Models;


class Field extends ActiveRecord
{

  protected $name;
  protected $rental_price;
  protected $branch_id;
  protected $type_id;
  protected $image;
  protected $opening_hours;
  protected $closing_time;
  public $previous_image;

  protected static $table = 'fields';
  protected static $columns = ['name', 'rental_price', 'branch_id', 'type_id', 'image', 'opening_hours', 'closing_time'];

  public function __construct($arguments = [])
  {
    $this->name = $arguments['name'] ?? null;
    $this->rental_price = $arguments['rental_price'] ?? null;
    $this->branch_id = $arguments['branch_id'] ?? null;
    $this->type_id = $arguments['type_id'] ?? null;
    $this->image = $arguments['image'] ?? null;
    $this->opening_hours = $arguments['opening_hours'] ?? null;
    $this->closing_time = $arguments['closing_time'] ?? null;
    $this->previous_image = $arguments['previous_image'] ?? null;
  }


  public function validateFields()
  {
    if (!$this->name) {
      self::$messages['errors']['name'] = 'el nombre es obligatorio';
    }
    if (!$this->rental_price) {
      self::$messages['errors']['rental_price'] = 'el priecio de alquiler es obligatorio';
    }
    if (!$this->branch_id) {
      self::$messages['errors']['branch_id'] = 'el id de sucursal es obligatorio';
    }
    if (!$this->type_id) {
      self::$messages['errors']['type_id'] = 'el id de tipo es obligatorio';
    }

    if (!$this->opening_hours) {
      self::$messages['errors']['opening_hours'] = 'la hora de apertura es obligatoria';
    }
    if (!$this->closing_time) {
      self::$messages['errors']['closing_time'] = 'la hora de cierre es obligatoria';
    }
    return self::$messages;
  }

  public function shouldUpdateImage()
  {

    if ($_FILES['image']['error'] === 0) {
      return true;
    }
    return false;
  }

  // este método sólo es valido para cuando se cree un nuevo campo, ya que ahí si
  // debería SI O SI mandarse una imagen
  // pero cuando se va a editar un campo no es necesario que el usuario mande una imagen
  // ya que el puede o no editar la imagen
  public function existImage()
  {
    if ($_FILES['image']['error'] === 4) {
      self::$messages['errors']['image'] = 'la imagen es obligatoria';
    }
  }

  public function validateImage()
  {
    // validar tipo y peso
    //debuguear($_FILES['image']);
    $validTypes = ["image/png", "image/jpeg", "image/jpg", "image/webp"];
    $sizeMax = 1024 * 1024 * 3;

    $isValid = true;

    if (!in_array($_FILES['image']['type'], $validTypes)) {
      self::$messages['errors']['image'] = "la imagen no tiene el formato correcto";
      $isValid = false;
    } elseif ($_FILES['image']['size'] > $sizeMax) {
      self::$messages['errors']['image'] = "El archivo es demasiado grande. Máximo permitido: 3 MB.";
      $isValid = false;
    }
    return $isValid;
  }

  public function saveImage()
  {
    // crear nombre unico para la imagen
    $path = $_FILES['image']['full_path'];
    $uniqueId = uniqid();
    $full_path = $uniqueId . "-" . $path;
    $routeDir = __DIR__ . "/../public/uploads";
    if (!file_exists($routeDir)) {
      mkdir($routeDir);
    }
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $routeDir . "/" . $full_path);

    return ['response' => $res, 'image' => $full_path];
  }

  public function save()
  {
    $types = "sdiisss";
    $result = $this->insertOne($types);
    if ($result) {
      $this->resetear();
      self::$messages['info']['success'] = 'campo creado con exito';
    }
  }

  public function edit($id)
  {
    $types = "sdiisssi";
    $result = $this->updateOne($types, $id);
    if ($result) {
      $this->resetear();
      self::$messages['info']['success'] = 'campo editado con exito';
    }
  }

  public static function delete($id)
  {
    $result = self::deleteOne($id);
    return $result;
  }


  public static function get($skip, $type = null, $district = null)
  {
    $types = '';
    $values = [];
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
      $query .= " WHERE types.id = ? AND districts.id = ?";
      $types .= 'ii';
      $values[] = $type;
      $values[] = $district;
    }
    //si solo existe type
    else if ($type) {
      $query .= "
      INNER JOIN  types
      ON fields.type_id = types.id";
      $query .= " WHERE types.id = ?";
      $types .= 'i';
      $values[] = $type;
    }
    // si solo existe district
    else if ($district) {
      $query .= "
      INNER JOIN branches
      ON fields.branch_id = branches.id
      INNER JOIN districts
      ON branches.district_id = districts.id";
      $query .= " WHERE districts.id = ?";
      $types .= 'i';
      $values[] = $district;
    }

    // $skip siempre va a existir
    if (is_numeric($skip)) {
      $query .= " LIMIT 3 OFFSET ?";
      $types .= 'i';
      $values[] = $skip;
    }
    $result = self::doQuery($query, $types, $values, true);
    $result = self::transformData($result);
    return $result;
  }

  public static function getOneById($id)
  {

    $query = 'SELECT fields.*, branches.name AS nombre_sucursal, branches.address, districts.name AS distrito, types.name AS tipo_cancha
    FROM fields 
    INNER JOIN branches 
    ON fields.branch_id = branches.id
    INNER JOIN districts
    ON branches.district_id = districts.id
    INNER JOIN types
    ON fields.type_id = types.id';
    $query .= ' WHERE fields.id = ?';
    $types = 'i';
    $values = [$id];
    $result = self::doQuery($query, $types, $values, true);
    $result = self::transformData($result);
    return array_shift($result);
  }
}
