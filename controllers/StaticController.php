<?php

namespace Controllers;


class StaticController
{

  public static function init($router)
  {
    // debuguear($router);
    session_start();
    // debuguear($_SESSION);
    $router->render('home/home.php');
  }

  public static function aboutUs($router)
  {
    session_start();
    $router->render('about/about.php');
  }


  public static function blog($router)
  {
    session_start();
    $router->render('blog/blog.php');
  }
}
