<?php
//Nombre de la sesión
session_name("Login");

//Inicializar sesión
session_start();

//Conexión a la base de datos
require_once ("classes/db_connection.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

// Verificar conexión
if ($conn->connect_error) {
    die("Error en conexión: " . $conn->connect_error);
}

/****************************COURSE DELETION **************************/

if(isset($_GET["courseid"])) {
    $courseId = $_GET["courseid"];
//Verificar que ese id existe
    $result = $conn -> query ("SELECT id FROM courses WHERE id = $courseId;");
    
    $num_rows = $result -> num_rows;
    
    if($num_rows >= 1) {
        $resultado = $conn -> query ("DELETE FROM courses WHERE id = $courseId;");

        if($resultado) {
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

/******************************Borrar cursos de los estudiante ************************* */

if(isset($_GET["cursoid"])) {
    $courseId = $_GET["cursoid"];
//Verificar que el curso existe
    $result = $conn -> query ("SELECT id FROM courses_details WHERE id = '$courseId';");

    if($result -> num_rows > 0) {
        $result = $conn -> query ("DELETE FROM courses_details WHERE id = '$courseId';");

        if($result) {
            $_SESSION['message'] = "Curso eliminado";
            $_SESSION['message_alert'] = "success";        

            header('Location: ' . root . 'alumnos');
            exit;
        } else {
            $_SESSION['message'] = "Error al eliminar curso";
            $_SESSION['message_alert'] = "danger";        

            header('Location: ' . root . 'alumnos');
            exit;
        }
//Si no existe el curso envía a página de error
    } else {
        http_response_code(404);

        require_once ("partials/head.php");

        require_once ("partials/header.php");    
    
        require_once ("partials/nav.php");  
    
        require_once ("views/error/404.php");

        require_once ("partials/footer.php");
    }
}

//Cerrar la conexión a la base de datos
$conn -> close ();
?>