<?php
//Clase de las opciones
    require_once ("classes/role.class.php");

    require_once("partials/head.php");

    require_once("partials/header.php");    

    require_once("partials/nav.php");    
?>

<main class="container">
<!-- Formulario para agregar cursos -->
    <div class="row mt-5 justify-content-center">
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
                                <input class="form-control" type="text" id="user" placeholder="Nombre del alumno" name="user" autofocus>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="firstname">Nombres: </label>
                                <input class="form-control" type="text" id="firstname" placeholder="Nombre del alumno" name="firstname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="lastname">Apellidos: </label>
                                <input class="form-control" type="text" id="lastname" placeholder="Nombre del alumno" name="lastname">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="password">Contraseña: </label>
                                <input class="form-control" type="text" id="password" placeholder="Nombre del alumno" name="password">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="email">Correo: </label>
                                <input class="form-control" type="text" id="email" placeholder="Nombre del alumno" name="email">
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

                            <!-- SELECT with the role-->

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
                        $result = $conn -> query("SELECT id, username FROM users;");

                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                $html = "<tr>";
                                $html .= "<td class='px-4'>" . ucfirst($row['username']) . "</td>";
                                $html .= "<td class='text-center'>";
                                $html .= "<a href='" . root . "delete?userid=" . $row['id'] . "' " . "class='btn btn-danger' title='Eliminar'>Eliminar</a>";
                                $html .= "<a href='" . root . "edit?userid=" . $row['id'] . "' " . "class='btn btn-info mx-1' title='Editar'>Editar</a>";
                                $html .= "</td>";
                                $html .= "</tr>";
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

<?php
    //Cerrar la conexión a la base de datos
    $conn -> close ();
    require_once ("partials/footer.php");
?>