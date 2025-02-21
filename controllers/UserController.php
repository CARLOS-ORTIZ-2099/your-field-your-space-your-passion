<?php

namespace Controllers;

use Models\User;

class UserController
{


  public static function login($router)
  {
    $newUser = new User;
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newUser = new User($_POST);
      $errores = $newUser->validateFieldsLogin();
      if (empty($errores)) {
        $res =  $newUser->getOne();
        debuguear($res);
        if ($res->num_rows == 0) {
          $newUser->setErrors('notFound', 'usuario no encontrado');
        } else {
          if ($newUser->passwordVerify($res)) {
            header('Location:/');
          }
        }
      }
    }

    $errores = $newUser->getErrors();
    $router->render('auth/login.php', [
      'user' => $newUser,
      'errores' => $errores
    ]);
  }

  public static function register($router)
  {
    $newUser = new User;
    $errores = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newUser = new User($_POST);
      $errores = $newUser->validateFieldsRegister();
      // debuguear($errores);
      if (empty($errores)) {
        $res =  $newUser->getOne();
        //debuguear($res);
        if ($res->num_rows > 0) {
          $newUser->setErrors('duplicado', 'intenta con otro email');
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
    $errores = $newUser->getErrors();
    $router->render(
      'auth/register.php',
      [
        'user' => $newUser,
        'errores' => $errores
      ]
    );
  }

  // CONTINUAR AQUI
}
