<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");
//Filtro para los inputs
require_once ("classes/filter.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

/************************************Edición de curso ********************************* */

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

        header('Location: ' . root . 'edit?courseid=' . $courseId);
    }
}

/********************************************Edición de usuario ******************************/

if(isset($_GET["userid"]) && isset($_POST["user"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["role"])) {
    if($_POST["user"] === "" || $_POST["firstname"] === "" || $_POST["lastname"] === "" || $_POST["password"] === "" || $_POST["email"] === ""|| $_POST["role"] === "") {
        $_SESSION['message'] = "Complete todos los campos por favor";
        $_SESSION['message_alert'] = "danger";          

        header('Location: ' . root . 'edit?userid=' . $_GET["userid"]);
        exit;
    } else {
        $username = new Filter ($_POST["user"], FILTER_SANITIZE_STRING);
        $username = $username -> sanitization();

        $firstname = new Filter ($_POST["firstname"], FILTER_SANITIZE_STRING);
        $firstname =  $firstname -> sanitization();

        $lastname = new Filter ($_POST["lastname"], FILTER_SANITIZE_STRING);
        $lastname = $lastname-> sanitization();

        $email = new Filter ($_POST["email"], FILTER_SANITIZE_EMAIL);
        $email = $email -> sanitization();;

        $roleid = $_POST["role"];

        $regExp = "/[a-zA-Z áéíóúÁÉÍÓÚñÑ,;:]/";

        if (!preg_match($regExp, $username) || !preg_match($regExp, $firstname) || !preg_match($regExp, $lastname) || !preg_match($regExp, $email)) {
            $_SESSION['message'] = "Formato no válido";
            $_SESSION['message_alert'] = "danger";    
                    
            header('Location: ' . root . 'edit?userid=' . $_GET["userid"]);
            exit;      
        } else {
            if (strlen($lastname) < 5 || strlen($lastname) > 40 || strlen($firstname) < 5 || strlen($firstname) > 30 || strlen($username) < 5 || strlen($username) > 30 || strlen($email) < 11 || strlen($email) > 70) {
                $_SESSION['message'] = "El nombre es muy largo";
                $_SESSION['message_alert'] = "danger";                      
        
                header('Location: ' . root . 'edit?userid=' . $_GET["userid"]);
                exit;     
            } else {
                $result = $conn -> query ("SELECT r.role FROM users u JOIN roles r ON r.id = u.role_id WHERE r.role = 'Admin';");

                $stmt = $conn -> prepare("UPDATE users SET username = ?, firstname = ?, lastname = ?, email = ?, role_id = ? WHERE id = '" . $_GET["userid"] . "';"); 
                $stmt->bind_param("ssssi", $username, $firstname, $lastname, $email, $roleid);

                if($stmt->execute()) {
                    $_SESSION['message'] = "Usuario editado correctamente";
                    $_SESSION['message_alert'] = "success";        

                    header('Location: ' . root . 'alumnos');
                    exit;
                } else {
                    $_SESSION['message'] = "Error al editar usuario";
                    $_SESSION['message_alert'] = "danger";        

                    header('Location: ' . root . 'edit?userid=' . $_GET["userid"]);
                    exit;
                }                   
            }
        }
    }
}
//Cerrar la conexión a la base de datos
$conn -> close ();

//Si no hay variables post o get, reenvía al inicio
if(empty($_POST) || empty($_GET)) {
    header('Location: ' . root);
    exit;  
}
?>