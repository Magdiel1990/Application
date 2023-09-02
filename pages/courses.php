<?php
    require_once("partials/head.php");

    require_once("partials/header.php");    

    require_once("partials/nav.php");    
?>

<main class="container py-5 px-2">
<!-- Formulario para agregar cursos -->
    <div class="row mt-5 text-center justify-content-center">
        <div class="col-md-4 mb-4">
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
                <thead>
                    <tr class="table_header">
                        <th class='px-2' scope="col">Cursos</th>
                        <th class='px-2' scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php
                        $result = $conn -> query("SELECT c.id, c.name FROM courses AS c JOIN courses_details AS cd JOIN users AS u ON cd.userid = u.id WHERE u.username = '" . $_SESSION ["username"]. "';");
                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                $html = "<tr>";
                                $html .= "<td class='px-2'>" . ucfirst($row['name']) . "</td>";
                                $html .= "<div class='btn-group' role='group'>";

                                $html .= "<a href='" . root . "delete?courseid=" . $row['id'] . "' " . "class='btn btn-outline-danger' title='Eliminar'><i class='fa-solid fa-trash'></i></a>";
                                $html .= "<a href='" . root . "edit?courseid=" . $row['id'] . "' " . "class='btn btn-outline-secondary' title='Editar'><i class='fa-solid fa-pen'></i></a>";
                                $html .= "</div>";
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
    require_once ("partials/footer.php");
?>