<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

if(isset($_GET["courseid"]) && isset($_POST["course"])) {
    $courseId = $_GET["courseid"];
    $course = $_POST["course"];

//Actualizar en la base de datos
    if($conn -> query ("UPDATE courses SET name = '$course' WHERE id = '$courseId';")) {
      
        $_SESSION['message'] = "Curso actualizado correctamente";
        $_SESSION['message_alert'] = "success";   
    
        header('Location: ' . root . 'cursos');
    } else {
        $_SESSION['message'] = "Error al actualizar este curso";
        $_SESSION['message_alert'] = "danger";        

        header('Location: ' . root . 'cursos');
    }
}

//Cerrar la conexión a la base de datos
$conn -> close ();
?>