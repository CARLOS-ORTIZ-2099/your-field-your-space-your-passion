<?php

use Models\Branch;
use Models\District;
use Models\Field;
use Models\Reservation;
use Models\Type;
use Models\User;

require 'functions.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
/* use Model\ActiveRecord; */
// le pasamos como parametro al metodo estatico la conexion a la base de datos
/* ActiveRecord::setDB($db); */

Field::setDb($db);
User::setDb($db);
Reservation::setDb($db);
Type::setDb($db);
District::setDb($db);
Branch::setDb($db);
