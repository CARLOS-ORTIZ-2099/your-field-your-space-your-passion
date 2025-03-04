<?php

namespace Controllers;

use Models\Reservation;

class ReservationController
{

  // obtiene todas las reservas del usuario con uniones de otras tablas
  public static function myReservations($router)
  {
    session_start();
    is_auth();
    $id = $_SESSION['user']['id'];
    // traer todas las ressrvaciones del usuario autenticado
    $myReservations = Reservation::getReservationsUser($id);
    //debuguear($myReservations);
    $router->render('reservations/reservations.php', [
      'myReservations' => $myReservations
    ]);
  }

  public static function allReservations($router)
  {
    session_start();
    is_auth();
    $id = $_SESSION['user']['id'];
    $admin = $_SESSION['user']['is_admin'] ?? null;
    if (!$admin) {
      header('Location:/profile/my-reservations');
    }
    $myReservations = Reservation::getReservationsUser($id, $admin);
    //debuguear($myReservations);
    $router->render('reservations/reservations.php', [
      'myReservations' => $myReservations
    ]);
  }

  public static function deleteReservation()
  {
    session_start();
    is_auth();
    $previousRoute = $_SERVER['HTTP_REFERER'] ?? '/profile/my-reservations';
    $result = Reservation::delete($_POST['id']);
    if ($result) {
      header('Location:' . $previousRoute);
    }
  }
}
