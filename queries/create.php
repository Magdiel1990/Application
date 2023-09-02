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

if(isset($_POST["user"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["role"])) {
    if($_POST["user"] === "" || $_POST["firstname"] === "" || $_POST["lastname"] === "" || $_POST["password"] === "" || $_POST["email"] === ""|| $_POST["role"] === "") {
        $_SESSION['message'] = "Complete todos los campos por favor";
        $_SESSION['message_alert'] = "danger";          

        header('Location: ' . root . 'alumnos');
        exit;
    } else {
        $username = new Filter ($_POST["user"], FILTER_SANITIZE_STRING);
        $username = $username -> sanitization();

        $firstname = new Filter ($_POST["firstname"], FILTER_SANITIZE_STRING);
        $firstname =  $firstname -> sanitization();

        $lastname = new Filter ($_POST["lastname"], FILTER_SANITIZE_STRING);
        $lastname = $lastname-> sanitization();

        $password = $_POST["password"];

        $email = new Filter ($_POST["email"], FILTER_SANITIZE_EMAIL);
        $email = $email -> sanitization();;

        $roleid = $_POST["role"];

        $regExp = "/[a-zA-Z áéíóúÁÉÍÓÚñÑ,;:]/";

        $result = $conn -> query ("SELECT id FROM users WHERE username = '$username';");

        if ($result -> num_rows > 0) {
            $_SESSION['message'] = "Este usuario ya existe";
            $_SESSION['message_alert'] = "danger"; 

            header('Location: ' . root . 'alumnos');
            exit; 
        } else {

            if (!preg_match($regExp, $username) || !preg_match($regExp, $firstname) || !preg_match($regExp, $lastname) || !preg_match($regExp, $email)) {
                $_SESSION['message'] = "Formato no válido";
                $_SESSION['message_alert'] = "danger";    
                     
                header('Location: ' . root . 'alumnos');
                exit;      
            } else {
                if (strlen($password) < 5 || strlen($password) > 50 || strlen($lastname) < 5 || strlen($lastname) > 40 || strlen($firstname) < 5 || strlen($firstname) > 30 || strlen($username) < 5 || strlen($username) > 30 || strlen($email) < 11 || strlen($email) > 70) {
                    $_SESSION['message'] = "El nombre es muy largo";
                    $_SESSION['message_alert'] = "danger";                      
            
                    header('Location: ' . root . 'alumnos');
                    exit;     
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn -> prepare("INSERT INTO users (username, firstname, lastname, password, email, role_id) VALUES (?, ?, ?, ?, ?, ?);"); 
                    $stmt->bind_param("sssssi", $username, $firstname, $lastname, $hashed_password, $email, $roleid);

                    if($stmt->execute()) {
                        $_SESSION['message'] = "Usuario agregado correctamente";
                        $_SESSION['message_alert'] = "success";        

                        header('Location: ' . root . 'alumnos');
                        exit;
                    } else {
                        $_SESSION['message'] = "Error al agregar usuario";
                        $_SESSION['message_alert'] = "danger";        

                        header('Location: ' . root . 'alumnos');
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