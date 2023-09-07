<?php
//Nombre de la sesión
session_name("Login");

//Inicializar sesión
session_start();

//Conexión a la base de datos
require_once ("classes/db_connection.class.php");
$dbConection = new DBConnection("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

// Verificar conexión
if ($conn->connect_error) {
    die("Error en conexión: " . $conn->connect_error);
}


//Verificar el usuario y la contraseña
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

//Verificar que el usuario existe
    $stmt = $conn -> prepare("SELECT id, username, password, firstname, lastname, email, role_id FROM users WHERE username = ?;"); 
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt -> get_result(); 
  
        if ($result -> num_rows > 0) {

            $row = $result -> fetch_assoc();
//Verificar contraseña   
            if (password_verify($password, $row['password'])) {
                
//Creación de cookie     
                session_set_cookie_params(0, "/" , $_SERVER["HTTP_HOST"], 0);
                
//Variables sesión
                $_SESSION['userid'] = $row['id'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role_id'] = $row['role_id'];

//último acceso
                $_SESSION["last_access"] = date("Y-m-j H:i:s"); 

//Redirección al index
                header ("Location: " . root);   
    
        } else {
            $_SESSION['message'] = "¡Usuario o contraseña incorrectos!";
            $_SESSION['message_alert'] = "danger";
        }
    } else {
        $_SESSION['message'] = "¡Usuario o contraseña incorrectos!";
        $_SESSION['message_alert'] = "danger";
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
        <main class="container p-4 mb-5">
            <div class="text-center text-lg-start">
                <div class="card mb-3">
                    <div class="row p-4 g-0 d-flex justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-8 d-lg-flex">
                        <img src="https://infotepvirtual.com/images/nicepage-images/logo-infotep-slide.png" alt="Logo de Infotep Virtual"/>
                        </div>
                        <div class="col-lg-6 col-md-8">
                            <div class="card-body p-5">
                                <form method="POST" action="<?php root. "login";?>">
                                    <!-- Email -->
                                    <div class="form-outline mb-4">
                                        <input type="text" id="username" name="username" class="form-control" />
                                        <label class="form-label" for="username">Usuario</label>
                                    </div>

                                    <!-- Contraseña -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control" />
                                        <label class="form-label" for="password">Contraseña</label>
                                    </div>

                                    <div class="text-center">
                                    <!-- Botón de logeo -->
                                        <input type="submit" class="btn btn-primary mb-4" value="Acceder">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php
//Cerrar conexión a base de datos
    $conn -> close();

    require_once ("partials/footer.php");
?>
