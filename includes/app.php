<?php

use Models\ActiveRecord;


require 'functions.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
// le pasamos como parametro al metodo estatico la conexion a la base de datos
ActiveRecord::setDb($db);
