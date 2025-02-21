<?php

namespace Models;

class User
{

  public  $name;
  public  $last_name;
  public  $email;
  public  $password;
  public  $is_admin;
  public  $token;
  public  $confirm;
  public $errors = [];
  // podriamos hacer que esta propiedad en esta clase sea de instancia
  // los potenciales problemas si convertimos esta propiedad en una de instancia seria que
  // si en un futuro agrego metodos estaticos que necesiten acceder a la 
  // varaibel de $db no podria
  protected static $db;

  public static function setDb($connect)
  {
    self::$db = $connect;
  }

  public function __construct($arguments = [])
  {
    $this->name = $arguments['name'] ?? null;
    $this->last_name = $arguments['last_name'] ?? null;
    $this->email = $arguments['email'] ?? null;
    $this->password = $arguments['password'] ?? null;
  }

  public function validateFieldsRegister()
  {
    if (!$this->name) {
      $this->errors['name'] = 'el nombre es obligatorio';
    }
    if (!$this->last_name) {
      $this->errors['last_name'] = 'el last_name es obligatorio';
    }
    if (!$this->email) {
      $this->errors['email'] = 'el email es obligatorio';
    }
    if (!$this->password) {
      $this->errors['password'] = 'el password es obligatorio';
    }
    if ($this->password && strlen($this->password) < 6) {
      $this->errors['password'] = 'el password debe ser de minimo 6 caracteres';
    }

    return $this->errors;
  }

  public  function validateFieldsLogin()
  {
    if (!$this->email) {
      $this->errors['email'] = 'el email es obligatorio';
    }
    if (!$this->password) {
      $this->errors['password'] = 'el password es obligatorio';
    }
    return $this->errors;
  }

  public function getOne()
  {
    $query = "SELECT * FROM users WHERE email = '{$this->email}'";
    $result = self::$db->query($query);
    return $result;
  }

  public function save()
  {
    $query = "INSERT INTO users (name, last_name, email, password)
              VALUES
          ('{$this->name}', '{$this->last_name}', '{$this->email}', '{$this->password}');";

    $result =  self::$db->query($query);
    if ($result) {
      // resetear objeto 
      $this->resetear();
      $this->errors['success'] = 'registrado con exito';
    }
  }

  public function resetear()
  {
    foreach (get_object_vars($this) as $key => $value) {
      $this->$key = null;
    }
  }

  public function passwordHash()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function passwordVerify($data)
  {
    $user = $data->fetch_assoc();
    // debuguear($user);
    $result =  password_verify($this->password, $user['password']);
    debuguear($result);
    if ($result) {
      return true;
    }
    $this->errors['passwordBad'] = 'el password es incorrecto';
  }


  public function setErrors($key, $value)
  {
    $this->errors[$key] = $value;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
