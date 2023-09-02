<?php
    require_once("partials/head.php");

    require_once("partials/header.php");    

    require_once("partials/nav.php");    
?>

<main class="container py-4 px-2 mb-1">
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
            <form id="course_form" method="POST" action="<?php echo root;?>create" autocomplete="off">
                
                <div class="input-group mb-3">
                    <label class="input-group-text is-required" for="course">Curso: </label>
                    <input class="form-control" type="text" id="course" placeholder="Nombre del curso" name="course" autofocus>
                </div>

                <div class="mb-3">
                    <input class="btn btn-success"  type="submit" value="Agregar">
                </div>

            </form>
        </div>
<!-- Lista de cursos -->
        <div class="col table-responsive-sm">
            <table class="table table-sm shadow">
                <thead class="text-center">
                    <tr>
                        <th class='px-2' scope="col">Cursos</th>
                        <th class='px-2' scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php
                        $result = $conn -> query("SELECT id, name FROM courses;");

                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                $html = "<tr>";
                                $html .= "<td class='px-4'>" . ucfirst($row['name']) . "</td>";
                                $html .= "<td class='text-center'>";
                                $html .= "<a href='" . root . "delete?courseid=" . $row['id'] . "' " . "class='btn btn-danger' title='Eliminar'>Eliminar</a>";
                                $html .= "<a href='" . root . "edit?courseid=" . $row['id'] . "' " . "class='btn btn-info mx-1' title='Editar'>Editar</a>";
                                $html .= "</td>";
                                $html .= "</tr>";
                                echo $html;
                            }
                        } else {
                 
                            $html = "<tr class='p-4'>";
                            $html .= "<td colspan='2'>";
                            $html .= "No hay cursos agregados...";
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