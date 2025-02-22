<?php

namespace Models;

class User
{

  protected  $name;
  protected  $last_name;
  protected  $email;
  protected  $password;
  protected  $is_admin;
  protected  $token;
  protected  $confirm;
  // esto no define a un usuario entonces no deberia ser parte de una instancia
  // mas bien deberia ser parte de la clase ya que es una propiedad general
  protected static  $messages = [
    'errors' => [],
    'info' => []
  ];
  // podriamos hacer que esta propiedad en esta clase sea de instancia
  // los potenciales problemas si convertimos esta propiedad en una de instancia seria que
  // si en un futuro agrego metodos estaticos que necesiten acceder a la 
  // varaibel de $db no podria, ya que estos metodos estaticos no tienen this
  protected static $db;
  // ya se vio
  public static function setDb($connect)
  {
    self::$db = $connect;
  }
  // ya se vio
  public function __construct($arguments = [])
  {
    $this->name = $arguments['name'] ?? null;
    $this->last_name = $arguments['last_name'] ?? null;
    $this->email = $arguments['email'] ?? null;
    $this->password = $arguments['password'] ?? null;
  }

  // ya se vio
  public function validateFieldsRegister()
  {
    if (!$this->name) {
      self::$messages['errors']['name'] = 'el nombre es obligatorio';
    }
    if (!$this->last_name) {
      self::$messages['errors']['last_name'] = 'el last_name es obligatorio';
    }
    if (!$this->email) {
      self::$messages['errors']['email'] = 'el email es obligatorio';
    }
    if (!$this->password) {
      self::$messages['errors']['password'] = 'el password es obligatorio';
    }
    if ($this->password && strlen($this->password) < 6) {
      self::$messages['errors']['password'] = 'el password debe ser de minimo 6 caracteres';
    }

    return self::$messages;
  }

  // ya se vio
  public  function validateFieldsLogin()
  {
    if (!$this->email) {
      self::$messages['errors']['email'] = 'el email es obligatorio';
    }
    if (!$this->password) {
      self::$messages['errors']['password'] = 'el password es obligatorio';
    }
    return self::$messages;
  }

  // ya se vio
  public static function getOne($key, $value)
  {
    $query = "SELECT * FROM users WHERE {$key} = '{$value}'";
    $result = self::$db->query($query);
    $result = self::transformData($result);
    //debuguear($result);
    return array_shift($result);
  }

  // ya se vio
  public static function transformData($data)
  {
    $registers = [];
    while ($row = $data->fetch_assoc()) {
      $registers[] = $row;
    }
    return $registers;
  }

  // ya se vio
  public function save()
  {
    $query = "INSERT INTO users (name, last_name, email, password)
              VALUES
          ('{$this->name}', '{$this->last_name}', '{$this->email}', '{$this->password}');";

    $result =  self::$db->query($query);
    if ($result) {
      // resetear objeto 
      $this->resetear();
      //$this->errors['success'] = 'registrado con exito';
      self::$messages['info']['success'] = 'registrado con exito';
    }
  }

  // ya se vio
  public function resetear()
  {
    foreach (get_object_vars($this) as $key => $value) {
      $this->$key = null;
    }
  }

  // ya se vio
  public function passwordHash()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  // ya se vio
  public function passwordVerify($password)
  {
    $result =  password_verify($this->password, $password);
    if ($result) {
      return true;
    }
    self::$messages['errors']['badrequest'] = 'el password es incorrecto';
  }


  // ya se vio
  public static function setMessage($type, $data)
  {
    self::$messages[$type] = $data;
    //debuguear(self::$messages);
  }

  // ya se vio
  public static function getMessages()
  {

    return self::$messages;
  }

  // ya se vio
  public function getProperty($property)
  {
    $res = $this->$property;
    return $res;
  }

  // ya se vio
  public function getValues()
  {

    return get_object_vars($this);
  }
}
