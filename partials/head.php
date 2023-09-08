<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");
$conn = DBConnection::dbConnection();

//Nombre de la sesión
session_name("Login");

//Inicializar sesión
session_start();

//Verificar el estado del usuario
if (!isset($_SESSION['username'])) {
    header("Location: " . root . "login");
    exit;
} else {    
//Si no está logueado
    $lastTime = $_SESSION["last_access"];
    $currentTime = date("Y-n-j H:i:s");

    $timeDiff = (strtotime($currentTime) - strtotime($lastTime));

//Después de 12 minutos la sesión se cierra
    if ($timeDiff >= 12 * 60) {

//Guardar el usuario
        $username = $_SESSION['username'];     

//Cerrar sesión
        session_destroy();  

//Nombre de la sesión
        session_name("Login");

//Inicializar sesión
        session_start();

//Reasignar el usuario
        $_SESSION['username'] = $username;

        header("Location: " . root . "login");        
    } else {
//Guardar el tiempo de sesión del usuario
        $_SESSION["last_access"] = $currentTime;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Magdiel Castillo Mills">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <meta name="Keywords" content="cursos, virtual, online, programación">
        <meta property="og:type" content="website">
        <meta name="description" content="Realiza los mejores cursos online de programación">
        <title>Cursos Gratis</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="shortcut icon" href="https://hoy.com.do/wp-content/uploads/2020/03/10-cursos-online-gratuitos-aprender-ingles-810x455.jpg">
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/65a5e79025.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            //Evita que los formularios se reenvíen  
            if (window.history.replaceState) { 
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </head>
<body>