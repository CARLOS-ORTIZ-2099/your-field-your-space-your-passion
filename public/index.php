<?php

require_once __DIR__ . '/../includes/app.php';


use AppRouter\Router;
use Controllers\FieldController;
use Controllers\RentController;
use Controllers\StaticController;

$newRouter = new Router;
// aqui estamos diciendo cuando estemos en la ruta '/' se ejecutara el metodo 'inicio' del controlador StaticController::class
// rutas para contenido estatico
$newRouter->get('/', [StaticController::class, 'init']);
$newRouter->get('/about', [StaticController::class, 'aboutUs']);
$newRouter->get('/blog', [StaticController::class, 'blog']);

// rutas para los campos a alquilar

// obtener todos los campos
$newRouter->get('/fields', [FieldController::class, 'getFields']);
// obtener un campo en especifico
$newRouter->get('/field', [FieldController::class, 'getField']);

$newRouter->execute();
/* debuguear($newRouter); */
