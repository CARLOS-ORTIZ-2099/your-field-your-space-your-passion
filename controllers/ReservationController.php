<?php

namespace Controllers;

class ReservationController
{


  public static function myReservations($router)
  {
    session_start();

    $router->render('auth/reservations.php', []);
  }
}
