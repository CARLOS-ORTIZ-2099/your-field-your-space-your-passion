<?php

namespace Controllers;

use Models\User;

class UserController
{


  public static function login($router)
  {

    // si ya existe el usuario manralo a la home
    session_start();
    authPublic();
    $newUser = new User;
    $messages = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newUser = new User($_POST);
      $messages = $newUser->validateFieldsLogin();
      if (empty($messages['errors'])) {
        $property = $newUser->getProperty('email');
        //$user =  $newUser->getOne();
        $user = User::getOne('email', $property);
        if (!$user) {
          User::setMessage(
            'errors',
            ['badrequest' => 'usuario no encontrado']
          );
          //$newUser->setErrors('notFound', 'usuario no encontrado');
        } else {
          if ($newUser->passwordVerify($user['password'])) {
            // crear session
            //debuguear($user);
            $_SESSION['user'] = [
              'name' => $user['name'],
              'lastname' => $user['last_name'],
              'email' => $user['email'],
              'is_admin' => $user['is_admin']
            ];
            //debuguear($_SESSION);
            header('Location:/');
          }
        }
      }
    }
    $messages = User::getMessages();
    $newUser = $newUser->getValues();
    $router->render('auth/login.php', [
      'user' => $newUser,
      'errors' => $messages['errors'],
      'info' => $messages['info'],
    ]);
  }

  public static function register($router)
  {
    session_start();
    authPublic();
    $newUser = new User;
    $messages = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newUser = new User($_POST);
      $messages = $newUser->validateFieldsRegister();
      //debuguear($messages);
      if (empty($messages['errors'])) {
        $property = $newUser->getProperty('email');
        $user = User::getOne('email', $property);
        if ($user) {
          User::setMessage(
            'errors',
            ['badrequest' => 'intenta con otro email']
          );
        } else {
          $newUser->passwordHash();
          // al ejecutar el metodo save vamos a resetear el objeto, es decir
          // cuando pasemos todas las validaciones y no haya ni un error
          //debuguear($newUser);
          $newUser->save();
          //debuguear($newUser);
        }
      }
    }
    $messages = User::getMessages();
    /* debuguear($messages); */
    // aqui debemos crear un metodo que recopile todas las propiedades de la instancia
    $newUser = $newUser->getValues();
    //debuguear($newUser);
    $router->render(
      'auth/register.php',
      [
        'user' => $newUser,
        'errors' => $messages['errors'],
        'info' => $messages['info'],
      ]
    );
  }

  public static function logout()
  {
    session_start();
    $_SESSION = [];
    //debuguear($_SESSION);
    header('Location:/');
  }

  public static function profile($router)
  {
    session_start();
    is_auth();
    $router->render('auth/profile.php');
  }
}
