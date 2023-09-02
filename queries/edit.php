<?php
//Conexión a la base de datos
require_once ("classes/db_connection.class.php");

$dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
$conn = $dbConection -> dbConnection ();

require_once("partials/head.php");

require_once("partials/header.php");    

require_once("partials/nav.php");    

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
                    <label class="input-group-text" for="course">Curso: </label>
                    <input class="form-control" value="<?php echo $row["name"];?>" type="text" id="course" placeholder="Nombre del curso" name="course" autofocus>
                </div>

                <div class="text-center mb-3">
                    <input class="btn btn-secondary"  type="submit" value="Editar">
                </div>

            </form>
        </div> 
    </main>
<?php
    } 
}


//Cerrar la conexión a la base de datos
$conn -> close ();

require_once ("partials/footer.php");
?>