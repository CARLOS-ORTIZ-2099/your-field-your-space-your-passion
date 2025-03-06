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

function campareDate($myReservation)
{
  $now = strtotime(date('Y-m-d'));

  $rental_date = strtotime($myReservation);

  if ($rental_date <= $now) {
    return true;
  }
  return false;
}
