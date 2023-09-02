<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");
//Filtro para los inputs
require_once ("classes/filter.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

if(isset($_POST["course"])) {
    if($_POST["course"] === "") {
        $_SESSION['message'] = "Escriba el nombre del curso";
        $_SESSION['message_alert'] = "danger";          

        header('Location: ' . root . 'cursos');
        exit;
    } else {
        $course = new Filter ($_POST["course"], FILTER_SANITIZE_STRING);
        $course = $course -> sanitization();
        $regExp = "/[a-zA-Z áéíóúÁÉÍÓÚñÑ,;:]/";

        $result = $conn -> query ("SELECT id FROM courses WHERE name = '$course';");

        if ($result -> num_rows > 0) {
            $_SESSION['message'] = "Este curso ya existe";
            $_SESSION['message_alert'] = "danger"; 

            header('Location: ' . root . 'cursos');
            exit;  
        } else {

            if (!preg_match($regExp, $course)) {
                $_SESSION['message'] = "Formato no válido para el nombre";
                $_SESSION['message_alert'] = "danger";    
                     
                header('Location: ' . root . 'cursos');
                exit;        
            } else {
                if (strlen($course) < 2 || strlen($course) > 75) {
                    $_SESSION['message'] = "El nombre debe tener entre 2 y 75 caracteres";
                    $_SESSION['message_alert'] = "danger";                      
            
                    header('Location: ' . root . 'cursos');
                    exit;       
                } else {
                    $stmt = $conn -> prepare("INSERT INTO courses (name) VALUES (?);"); 
                    $stmt->bind_param("s", $course);

                    if($stmt->execute()) {
                        $_SESSION['message'] = "Curso agregado correctamente";
                        $_SESSION['message_alert'] = "success";        

                        header('Location: ' . root . 'cursos');
                        exit; 
                    } else {
                        $_SESSION['message'] = "Error al agregar curso";
                        $_SESSION['message_alert'] = "danger";        

                        header('Location: ' . root . 'cursos');
                        exit; 
                    }                   
                }
            }
        }
    }
}

//Cerrar la conexión a la base de datos
$conn -> close ();
?>