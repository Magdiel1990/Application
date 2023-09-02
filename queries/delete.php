<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

/****************************COURSE DELETION **************************/

if(isset($_GET["courseid"])) {
    $courseId = $_GET["courseid"];

//Verificar que ese id existe
    if($conn -> query ("SELECT id FROM courses WHERE id = '$courseId';")) {
        $result = $conn -> query ("DELETE FROM courses WHERE id = '$courseId';");
        if($result) {
            $_SESSION['message'] = "Curso eliminado";
            $_SESSION['message_alert'] = "success";   
        
            header('Location: ' . root . 'cursos');
        } else {
            $_SESSION['message'] = "Error al eliminar este curso";
            $_SESSION['message_alert'] = "danger";        
    
            header('Location: ' . root . 'cursos');
        }
    } else {
        $_SESSION['message'] = "Este curso no existe";
        $_SESSION['message_alert'] = "danger";        

        header('Location: ' . root . 'cursos');
    }
}

/****************************USERS DELETION **************************/

if(isset($_GET["userid"])) {
    $userId = $_GET["userid"];

//Verificar que ese id existe
    if($conn -> query ("SELECT id FROM users WHERE id = '$userId';")) {
        $result = $conn -> query ("DELETE FROM users WHERE id = '$userId';");
        if($result) {
            $_SESSION['message'] = "Usuario eliminado";
            $_SESSION['message_alert'] = "success";   
        
            header('Location: ' . root . 'alumnos');
        } else {
            $_SESSION['message'] = "Error al eliminar este usuario";
            $_SESSION['message_alert'] = "danger";        
    
            header('Location: ' . root . 'alumnos');
        }
    } else {
        $_SESSION['message'] = "Este usuario no existe";
        $_SESSION['message_alert'] = "danger";        

        header('Location: ' . root . 'alumnos');
    }
}

//Cerrar la conexión a la base de datos
$conn -> close ();
?>