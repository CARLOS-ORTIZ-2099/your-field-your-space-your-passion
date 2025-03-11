<?php

function debuguear($data)
{
  echo "<pre/>";
  var_dump($data);
  echo "<pre/>";
}


function is_auth()
{
  if (!$_SESSION['user']) {
    header('Location:/');
  }
}

function is_admin($route)
{
  $admin = $_SESSION['user']['is_admin'] ?? null;
  if (!$admin) {
    header('Location:/' . $route);
  }
}

function authPublic()
{
  if (isset($_SESSION['user'])) {
    header('Location:/profile');
  }
}

function checkUserPath()
{
  $urlpath = $_SERVER['PATH_INFO'] ?? '/';
  $urlNew =  explode('/', $urlpath);
  array_shift($urlNew);
  return $urlNew;
}


function deleteImage($name)
{
  if ($name) {
    $route = __DIR__ . "/../uploads/" . $name;
    // echo $route;
    if (file_exists($route)) {
      $result = unlink($route);
      //echo $result;
    }
  } else {
    echo 'no tiene nada';
  }
}

function campareDate($myReservation)
{
  $now = strtotime(date('Y-m-d'));

  $rental_date = strtotime($myReservation);

  if ($rental_date <= $now) {
    return true;
  }
  return false;
}

function correctHours($opening_hours, $closing_time)
{
  $init = explode(':', $opening_hours);
  $final = explode(':', $closing_time);
  /* debuguear($init);
  debuguear($final); */
  $init = array_shift($init) . ":00";

  $final = array_shift($final) . ":00";

  return ['opening_hours' => $init, 'closing_time' => $final];
}

function checkShift($hour)
{
  $explode = explode(':', $hour);
  $res = (int) array_shift($explode);
  if ($res >= 12) {
    return 'pm';
  } else {
    return 'am';
  }
}
