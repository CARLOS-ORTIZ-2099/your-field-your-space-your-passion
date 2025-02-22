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

function authPublic()
{
  if (isset($_SESSION['user'])) {
    header('Location:/profile');
  }
}
