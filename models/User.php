<?php

namespace Models;

class User extends ActiveRecord
{

  protected  $name;
  protected  $last_name;
  protected  $email;
  protected  $password;
  protected  $is_admin;
  protected  $token;
  protected  $confirm;

  protected static $table = 'users';
  // esto no define a un usuario entonces no deberia ser parte de una instancia
  // mas bien deberia ser parte de la clase ya que es una propiedad general


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
      self::$messages['errors']['name'] = 'el nombre es obligatorio';
    }
    if (!$this->last_name) {
      self::$messages['errors']['last_name'] = 'el last_name es obligatorio';
    }
    if (!$this->email) {
      self::$messages['errors']['email'] = 'el email es obligatorio';
    }
    if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$messages['errors']['email'] = 'escribe un email correcto';
    }
    if (!$this->password) {
      self::$messages['errors']['password'] = 'el password es obligatorio';
    }
    if ($this->password && strlen($this->password) < 6) {
      self::$messages['errors']['password'] = 'el password debe ser de minimo 6 caracteres';
    }

    return self::$messages;
  }


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

  public function passwordVerify($password)
  {
    $result =  password_verify($this->password, $password);
    if ($result) {
      return true;
    }
    self::$messages['errors']['badrequest'] = 'el password es incorrecto';
  }

  public function passwordHash()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function save()
  {
    // antes de guardar los datos en la db sanitizarlos
    // preparar la consulta
    $sql = "INSERT INTO users (name, last_name, email, password)
    VALUES (?,?,?,?)";
    $stmt = self::$db->prepare($sql);
    // bindear los valores
    $stmt->bind_param('ssss', $this->name, $this->last_name, $this->email, $this->password);
    // ejecutar
    $result = $stmt->execute();
    // cerrar la conexion
    $stmt->close();
    if ($result) {
      $this->resetear();
      self::$messages['info']['success'] = 'registrado con exito';
    }
  }
}
