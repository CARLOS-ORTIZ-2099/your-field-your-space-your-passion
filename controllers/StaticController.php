<?php

namespace Controllers;


class StaticController
{

  public static function init($router)
  {
    // debuguear($router);
    $router->render('home/home.php');
  }

  public static function aboutUs($router)
  {
    $router->render('about/about.php');
  }


  public static function blog($router)
  {
    $router->render('blog/blog.php');
  }
}
