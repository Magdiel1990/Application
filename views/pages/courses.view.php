<?php
    require_once("partials/head.php");
    
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
            <form class="mt-2" id="course_form" method="POST" action="<?php echo root;?>create" autocomplete="off">
                
                <div class="input-group mb-3">
                    <label class="input-group-text is-required" for="course">Curso: </label>
                    <input class="form-control" type="text" id="course" placeholder="Nombre del curso" name="course" autofocus>
                </div>

                <div class="mb-3">
                    <input class="btn btn-success"  type="submit" value="Crear">
                </div>

                <div class="text-danger" id="message"></div>

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
                                $html .= "<a id='delBtn' href='" . root . "delete?courseid=" . $row['id'] . "' " . "class='btn btn-danger' title='Eliminar'>Eliminar</a>";
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
<script>
    //Validación de formulario con Javascript
    course_validation();

    //Confirmación de borrado de mensaje
    delete_message ();

    function course_validation() {
        //Elemento de formulario
        let form = document.getElementById("course_form");
        
        //Agregando evento al formulario
        form.addEventListener("submit", function(event){ 
        let course_element = document.getElementById("course");
        let course = course_element.value;
        let message = document.getElementById("message"); 
        //Expresión regular
        let regExp = /[a-zA-Z,;:\t\h]+|(^$)/;
        //Validación de que las variables no vengan vacías
        if(course == "") {
            course_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Completar el campo requerido!";             
            return false;
        }

        //Validación de la cantidad de caracteres
        if(course.length < 2 || course.length > 75){
            course_element.focus();
            event.preventDefault();
            message.innerHTML = "¡El nombre de curso debe tener de 2 a 75 caracteres!";                 
            return false;
        } 

        //Validación de la expresión regulars
        if(!course.match(regExp)) {
            course_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Nombre de curso incorrecto!";                 
            return false;
        }

        return true;

        });
    }


    //Mensaje de confirmación de borrado del curso
    function delete_message () {
        let deletionBtn = document.getElementById("delBtn");

        deletionBtn.addEventListener("click", function(event){
            if (confirm("Desea eliminar este curso?")) {
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        });
    }

</script>
<?php
    //Cerrar la conexión a la base de datos
    $conn -> close ();
    require_once ("partials/footer.php");
?>