<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");

//Clase de las opciones
require_once ("classes/role.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

require_once("partials/head.php");  

require_once("partials/nav.php");   

/************************************Edición de curso interfaz **************************************/

if(isset($_GET["courseid"])) {
    $courseId = $_GET["courseid"];

    $result = $conn -> query ("SELECT name FROM courses WHERE id = '$courseId ';");

    if($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();    
?>  
    <main class="container p-4">
    <!-- Formulario para agregar cursos -->
        <div class="row mt-5 justify-content-center">
            <?php
                // Mensaje 
                if(isset($_SESSION['message'])) {
                    echo "<span class='text-" . $_SESSION['message_alert'] . "'>" . $_SESSION['message'] ."</span>";
                    //Eliminar mensaje
                    unset($_SESSION['message_alert'], $_SESSION['message']);
                }
            ?>
            <form class="col-auto" id="course_edit_form" method="POST" action="<?php echo root . "update?courseid=" . $courseId ;?>" autocomplete="off">
                
                <div class="input-group mb-3">
                    <label class="input-group-text is-required" for="course">Curso: </label>
                    <input class="form-control" value="<?php echo $row["name"];?>" type="text" id="course" placeholder="Nombre del curso" name="course" autofocus>
                </div>

                <div class="text-center mb-3">
                    <input class="btn btn-secondary" title="Guardar cambios" type="submit" value="Guardar cambios">
                </div>

            </form>
        </div> 
    </main>
<?php
    } else {
        http_response_code(404);
        require "views/error/404.php";
    }
}

/************************************Edición de usuario interfaz **************************************/

if(isset($_GET["userid"])) {
    $userId = $_GET["userid"];

    $result = $conn -> query ("SELECT u.username, u.firstname, u.lastname, u.password, u.email, r.role FROM users u JOIN roles r ON r.id = u.role_id WHERE u.id = '$userId';");

    if($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
?>  
<main class="container">
<!-- Formulario para agregar cursos -->
    <div class="row my-5 justify-content-center">
        <div class="col-md-4 mb-4 text-center">
            <?php
                // Mensaje 
                if(isset($_SESSION['message'])) {
                    echo "<span class='text-" . $_SESSION['message_alert'] . "'>" . $_SESSION['message'] ."</span>";
                    //Eliminar mensaje
                    unset($_SESSION['message_alert'], $_SESSION['message']);
                }
            ?>
            <form id="student_form" method="POST" action="<?php echo root . "update?userid=". $userId ;?>"  autocomplete="off">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Editar alumno</h5>
                        <div class="card-text">
                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="user">Usuario: </label>
                                <input class="form-control" value="<?php echo $row ["username"];?>" type="text" id="user" placeholder="Nombre del alumno" name="user" autofocus>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="firstname">Nombres: </label>
                                <input class="form-control" value="<?php echo $row ["firstname"];?>" type="text" id="firstname" placeholder="Nombre del alumno" name="firstname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="lastname">Apellidos: </label>
                                <input class="form-control" value="<?php echo $row ["lastname"];?>" type="text" id="lastname" placeholder="Nombre del alumno" name="lastname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="email">Correo: </label>
                                <input class="form-control" value="<?php echo $row ["email"];?>" type="text" id="email" placeholder="Nombre del alumno" name="email">
                            </div>

                            <div class="mb-3">
                                <select class="form-select" name="role" id="role">
                                    <?php 
                                    $options = new RoleList("roles");
                                    $html = $options -> roleOptions();    
                                    
                                    echo $html;
                                    ?>
                                </select> 
                            </div>

                            <div class="mb-3">
                                <input class="btn btn-secondary" title="Guardar cambios" type="submit" value="Guardar cambios">
                            </div>                                        
                        </div>
                    </div>
                </div>            
            </form>
        </div>
    </div>
</main>

<?php
    } else {
        http_response_code(404);
        require "views/error/404.php";
    }
}
 
/*************************Asignar curso******************************** */

if(isset($_GET["assign"])) {
    $userId = $_GET["assign"];

    $result = $conn -> query("SELECT name FROM courses WHERE name NOT IN (SELECT name FROM courses_details WHERE userid = '$userId');");
    if($result -> num_rows > 0) {
?>
<main class="container">
<!-- Formulario para agregar cursos -->
    <div class="row my-5 justify-content-center">
        <div class="col-md-4 mb-4">
            <?php
                // Mensaje 
                if(isset($_SESSION['message'])) {
                    echo "<span class='text-" . $_SESSION['message_alert'] . "'>" . $_SESSION['message'] ."</span>";
                    //Eliminar mensaje
                    unset($_SESSION['message_alert'], $_SESSION['message']);
                }
            ?>
            <form id="course_assign_form" method="POST" action="<?php echo root . "create?userid=". $userId ;?>"  autocomplete="off">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-center">Cursos</h5>
                        <div class="card-text">
                                <?php 
                                    $html = "";
                                    while($row = $result -> fetch_assoc()) {
                                        $html .= '<div class="form-check">';
                                        $html .= '<input class="form-check-input" name="courses[]" type="checkbox" value="' . $row ['name'] . '" id="' . $row ['name'] .'">';
                                        $html .= '<label class="form-check-label" for="' . $row ['name'] .'">';
                                        $html .=  $row ['name'];
                                        $html .= '</label>';
                                        $html .= '</div>';
                                    }
                                    echo $html;
                                ?>
                            <div class="mt-4 text-center">
                                <input class="btn btn-primary"  type="submit" value="Agregar">
                            </div>                                        
                        </div>
                    </div>
                </div>            
            </form>
        </div>
    </div>
</main>
<?php
    } else {
?>
<main class="container p-4 mb-2">
    <div class="mb-5"></div>
    <section class="row justify-content-center">        
        <h3 class="col-auto mb-3 text-success">No hay cursos disponibles</h3>
        <div class="text-center">
            <a href="<?php echo root . "alumnos";?>" class="btn btn-secondary">Regresar</a>
        </div>
    </section>
</main>
<?php        
    }
}

//Cerrar la conexión a la base de datos
$conn -> close ();

require_once ("partials/footer.php");

?>