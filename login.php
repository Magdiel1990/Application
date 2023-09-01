<?php
//Nombre de la sesión
session_name("Login");

//Inicializar sesión
session_start();

//Conexión a la base de datos
require_once ("classes/db_connection.class.php");
$dbConection = new DBConnection("localhost:3306", "root", "123456", "foodbase");
$conn = $dbConection -> dbConnection ();

//Verificar el usuario y la contraseña
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

//Verificar que el usuario existe
    $stmt = $conn -> prepare("SELECT * FROM users WHERE username = ?;"); 
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt -> get_result(); 
  
        if ($result -> num_rows > 0) {

            $row = $result -> fetch_assoc();
//Verificar contraseña   
            if (password_verify($password, $row['password'])) {
                
//Creación de cookie     
                session_set_cookie_params(0, root, $_SERVER["HTTP_HOST"], 0);
                
//Variables sesión
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

//último acceso
                $_SESSION["last_access"] = date("Y-m-j H:i:s"); 

//Redirección al index
                header ("Location: index.php");   
    
        } else {
            $_SESSION['message'] = "¡Usuario o contraseña incorrectos!";
            $_SESSION['message_alert'] = "danger";
        }
    } else {
        $_SESSION['message'] = "¡Usuario o contraseña incorrectos!";
        $_SESSION['message_alert'] = "danger";
    }
} 

    require_once("partials/head.php");
?>
    <main class="container p-4">
        <div class="text-center text-lg-start">
            <div class="card mb-3">
                <div class="row p-4 g-0 d-flex justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-8 d-lg-flex">
                        <img src="https://hoy.com.do/wp-content/uploads/2020/03/10-cursos-online-gratuitos-aprender-ingles-810x455.jpg" alt="Trendy Pants and Shoes"
                        class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <div class="card-body p-5">
                            <form method="POST" action="">
                                <!-- Email -->
                                <div class="form-outline mb-4">
                                    <input type="text" id="username" name= "username" class="form-control" />
                                    <label class="form-label" for="username">Usuario</label>
                                </div>

                                <!-- Contraseña -->
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name= "password" class="form-control" />
                                    <label class="form-label" for="password">Contraseña</label>
                                </div>

                                <div class="row mb-4">
                                    <div class="col text-center">
                                        <!-- Recuperación de contraseñas -->
                                        <a href="#">Olvidaste la contraseña?</a>
                                    </div>
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
    require_once ("partials/footer.php");
?>
