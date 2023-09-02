<?php
//Raíz de directorio
define("root", "/application/");

//Nombre de la sesión
session_name("Login");

//Inicializar sesión
session_start();

//Destruir sesión
session_unset();

session_destroy();

//Redireccionar al login
header('Location: ' . root . 'login');

die();
?>