<?php
//Raíz de directorio
define("root", "/application/");

//Url requerida
$uri = parse_url($_SERVER["REQUEST_URI"])['path']; 

//Parámetros que vienen con la url
$param = isset(parse_url($_SERVER["REQUEST_URI"])['query']) ? parse_url($_SERVER["REQUEST_URI"])['query'] : "";

//Si no hay parámetros
if($param == "") {
    $routes = [
    root => "controllers/index.controller.php" ,    
    root. "login" => "controllers/login.controller.php",
    root. "salir" => "controllers/logout.controller.php",
    root. "alumnos" => "controllers/students.controller.php",
    root. "cursos" => "controllers/courses.controller.php",
    root. "create" => "controllers/create.controller.php"    
    ];
//Si hay parámetros
} else {
    $routes = [
    root. "delete" => "controllers/delete.controller.php",
    root. "edit" => "controllers/edit.controller.php",
    root. "create" => "controllers/create.controller.php",
    root. "update" => "controllers/update.controller.php",
    root. "certificado" => "controllers/certificate.controller.php"
    ];
}

//Si la Url existe se llama al controlador
if(array_key_exists($uri, $routes)) {
    require $routes[$uri];
//Si no existe se llama a error 404
} else {
    http_response_code(404);
    require "views/error/404.php";
}
?>