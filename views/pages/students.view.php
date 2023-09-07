<?php
//Clase de las opciones
    require_once ("classes/role.class.php");

    require_once("partials/head.php");

    require_once("partials/nav.php");    
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
            <form id="student_form" method="POST" action="<?php echo root;?>create" autocomplete="on">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Agregar alumno</h5>
                        <div class="card-text">
                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="user">Usuario: </label>
                                <input class="form-control" type="text" id="user" name="user" autofocus>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="firstname">Nombres: </label>
                                <input class="form-control" type="text" id="firstname" name="firstname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="lastname">Apellidos: </label>
                                <input class="form-control" type="text" id="lastname" name="lastname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="password">Contraseña: </label>
                                <input class="form-control" type="password" id="password" name="password">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="repeat_password">Repita contraseña: </label>
                                <input class="form-control" type="password" id="repeat_password" name="repeat_password">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="email">Correo: </label>
                                <input class="form-control" type="email" id="email" name="email">
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
                                <input class="btn btn-success"  type="submit" value="Agregar">
                            </div>                                        
                        </div>
                    </div>
                </div>            
            </form>
        </div>
<!-- Lista de cursos -->
        <div class="col table-responsive-sm">
            <table class="table table-sm shadow">
                <thead class="text-center">
                    <tr>
                        <th class='px-2' scope="col">Alumnos</th>
                        <th class='px-2' scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php
                        $result = $conn -> query("SELECT u.id, u.username, r.role FROM users u JOIN roles r ON u.role_id = r.id;");

                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                //Administradores no pueden eliminarse                    
                                if($row["role"] == "Admin") {
                                    $visibility = "style = 'display: none;'";
                                } else {
                                    $visibility = "";
                                }

                                $html = "<tr>";
                                $html .= "<td class='px-4'>" . ucfirst($row['username']) . "</td>";
                                $html .= "<td class='text-center'>";
                                $html .= "<div class='btn-group'>";
                                $html .= "<a $visibility href='" . root . "delete?userid=" . $row['id'] . "' " . "class='btn btn-danger' title='Eliminar'>Eliminar</a>";
                                $html .= "<a href='" . root . "edit?userid=" . $row['id'] . "' " . "class='btn btn-info' title='Editar'>Editar</a>";
                                $html .= "<a href='" . root . "edit?assign=" . $row['id'] . "' " . "class='btn btn-warning' title='Editar'>Agregar</a>";
                                $html .= "</div>";
                                $html .= "</td>";
                                $html .= "</tr>";

                                $resultCourses = $conn -> query ("SELECT id, name FROM courses_details WHERE userid = '" . $row['id'] . "';");
                                
                                while ($rowCourses = $resultCourses -> fetch_assoc()) {
                                    $html .= "<tr class='bg-light'><td colspan = '2'><a href='" . root . "delete?cursoid=" . $rowCourses['id'] . "' style='text-decoration: none; padding: 18px'>" . $rowCourses['name'] . "</a></td></tr>";
                                }
                                echo $html;
                            }
                        } else {
                 
                            $html = "<tr class='p-4'>";
                            $html .= "<td colspan='2'>";
                            $html .= "No hay alumnos agregados...";
                            $html .= "</td>";
                            $html .= "</tr>";
                            echo $html;      
                        }                  
                    ?>                
                </tbody>
            </table>
        </div>
    </div>
</main>
<!--
<script>
    //Validación de formulario con Javascript
    student_validation();

    function student_validation() {
        let username = document.getElementById("user").value;
        let firstname = document.getElementById("firstname").value;
        let lastname = document.getElementById("lastname").value;
        let password = document.getElementById("password").value;
        let repeat_password = document.getElementById("repeat_password").value;
        let email = document.getElementById("email").value;
        let role = document.getElementById("role").value;
        
    }
</script>
-->
<?php
    //Cerrar la conexión a la base de datos
    $conn -> close ();
    require_once ("partials/footer.php");
?>