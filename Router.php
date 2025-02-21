<?php

namespace AppRouter;



class Router
{

  // aqui iremos almacnenado las rutas de GET y POST
  // solo esas ya que el navegador por defecto no acepta DELETE, UPDATE, etc
  protected $getRoutes = [];
  protected $postRoutes = [];



  // luego crear metodos que alamacenen rutas para cada metodo

  public  function get($route, $clase)
  {
    $this->getRoutes[$route] = $clase;
  }

  public  function post($route, $clase)
  {
    $this->postRoutes[$route] = $clase;
  }


  public  function execute()
  {
    // primero ver la url actual
    $url = $_SERVER['PATH_INFO'] ?? '/';

    // luego corroborar el metodo de la solicitud actual

    $methodHttp = $_SERVER['REQUEST_METHOD'];
    if ($methodHttp === 'POST') {
      // buscar en el arreglo de rutas POST
      $fn = $this->postRoutes[$url] ?? null;
    } else {
      // buscar en el arreglo de rutas GET
      $fn = $this->getRoutes[$url] ?? null;
    }

    if ($fn) {
      // ejecutar el metodo de dicho controlador
      // debuguear($fn);
      call_user_func($fn, $this);
    } else {
      echo "no existe la ruta intenta luego";
    }
  }


  public  function render($view, $data = [])
  {
    //debuguear($data);
    // creando variabkes variables
    // esto de aqui se hace para que la vista que se renderiza lea las variables con el mismo nombre con el 
    // cual se le pasa
    foreach ($data as $key => $value) {
      // debuguear($key);
      $$key = $value;
    }

    // tenemos que tener en cuenta que siempre vamos a utilizar el layout principal, asi como el header y el footer

    $layoutView = __DIR__ . '/views/layout.php';

    $url = __DIR__ . '/views/' . $view;

    require_once $layoutView;
    // require_once $url;
  }
}
