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
            <form class="mt-2" id="student_form" method="POST" action="<?php echo root;?>create" autocomplete="on">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Agregar usuario</h5>
                        <div class="card-text">
                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="user">Usuario: </label>
                                <input class="form-control" type="text" id="user" name="user" autofocus required  minlength="5" maxlength="30">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="firstname">Nombres: </label>
                                <input class="form-control" type="text" id="firstname" name="firstname" required minlength="5" maxlength="30">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="lastname">Apellidos: </label>
                                <input class="form-control" type="text" id="lastname" name="lastname" required minlength="5" maxlength="40">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="password">Contraseña: </label>
                                <input class="form-control" type="password" id="password" name="password" required minlength="5" maxlength="50">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="repeat_password">Repita contraseña: </label>
                                <input class="form-control" type="password" id="repeat_password" name="repeat_password" required minlength="5" maxlength="50">
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text is-required" for="email">Correo: </label>
                                <input class="form-control" type="email" id="email" name="email" required minlength="11" maxlength="70
                                ">
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
                        <div class="text-danger" id="message"></div>
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

                                $html = "<tr>";
                                $html .= "<td class='px-4'>" . ucfirst($row['username']) . " - " . $row['role'] . "</td>";
                                $html .= "<td class='text-center'>";
                                $html .= "<div class='btn-group'>";
                                $html .= "<a href='" . root . "delete?userid=" . $row['id'] . "' " . "class='btn btn-danger delBtn' title='Eliminar'>Eliminar</a>";
                                $html .= "<a href='" . root . "edit?userid=" . $row['id'] . "' " . "class='btn btn-info' title='Editar'>Editar</a>";
                                $html .= "<a href='" . root . "edit?assign=" . $row['id'] . "' " . "class='btn btn-warning' title='Agregar curso'>Agregar</a>";
                                $html .= "</div>";
                                $html .= "</td>";
                                $html .= "</tr>";

                                $resultCourses = $conn -> query ("SELECT id, name FROM courses_details WHERE userid = '" . $row['id'] . "';");
                                
                                while ($rowCourses = $resultCourses -> fetch_assoc()) {
                                    $html .= "<tr class='bg-light'><td colspan = '2'><a href='" . root . "delete?cursoid=" . $rowCourses['id'] . "' title='eliminar' style='text-decoration: none; padding: 18px'>" . $rowCourses['name'] . "</a>";
                                    $html .= "<a class='btn btn-success' href='" . root . "certificado?cursoid=" . $rowCourses['id'] . "&userid=" . $row['id'] . "' title='Generar certificado'>Certificado</a>";
                                    $html .= "</td></tr>";
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

<script>
    //Validación de formulario con Javascript
    student_validation();

    //Mensaje de confirmación para eliminar
    delete_message ();

    function student_validation() {
        //Elemento de formulario
        let form = document.getElementById("student_form");
        
        //Agregando evento al formulario
        form.addEventListener("submit", function(event){ 
        let username_element = document.getElementById("user");
        let username = username_element.value;
        let firstname_element = document.getElementById("firstname");
        let firstname = firstname_element.value;
        let lastname_element = document.getElementById("lastname");
        let lastname = lastname_element.value;
        let password_element = document.getElementById("password");
        let password = password_element.value;
        let repeat_password_element = document.getElementById("repeat_password");
        let repeat_password = repeat_password_element.value;
        let email = document.getElementById("email").value;
        let message = document.getElementById("message"); 
        //Expresión regular
        let regExp = /[a-zA-Z,;:\t\h]+|(^$)/;
        //Validación de que las variables no vengan vacías
        if(username == "" || firstname == "" || lastname == "" || password == "" || repeat_password == "" || email == "") {
            event.preventDefault();
            message.innerHTML = "¡Completar los campos requeridos!";             
            return false;
        }
        //Coincidencia de las contraseñas
        if(password !== repeat_password) {
            repeat_password_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Las contraseñas deben coincidir!";             
            return false;
        }
        //Validación de la cantidad de caracteres
        if(firstname.length < 5 || firstname.length > 30){
            firstname_element.focus();
            event.preventDefault();
            message.innerHTML = "¡El nombre debe tener de 5 a 30 caracteres!";                 
            return false;
        } 

        if(lastname.length < 5 || lastname.length > 40){
            lastname_element.focus();
            event.preventDefault();
            message.innerHTML = "¡El apellido debe tener de 5 a 40 caracteres!";                 
            return false;
        } 

        if(username.length < 5 || username.length > 30){
            username_element.focus();
            event.preventDefault();
            message.innerHTML = "¡El nombre de usuario debe tener de 5 a 30 caracteres!";                 
            return false;
        } 

        if(password.length < 5 || password.length > 50){
            password_element.focus();
            event.preventDefault();
            message.innerHTML = "¡La contraseña debe tener entre 5 a 50 caracteres!";                 
            return false;
        } 
        //Validación de la expresión regulars
        if(!firstname.match(regExp)) {
            firstname_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Nombre incorrecto!";                 
            return false;
        }

        if(!lastname.match(regExp)) {
            lastname_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Apellido incorrecto!";                 
            return false;
        }
        
        if(!username.match(regExp)) {
            username_element.focus();
            event.preventDefault();
            message.innerHTML = "¡Nombre de usuario incorrecto!";                 
            return false;
        }  

        return true;

        });
    }

    //Mensaje de confirmación de borrado del curso
    function delete_message () {
        let deletionBtn = document.getElementsByClassName("delBtn");

        for(let i = 0; i < deletionBtn.length; i++) {
            deletionBtn[i].addEventListener("click", function(event){    
                if (confirm("Desea eliminar este usuario?")) {
                    return true;
                } else {
                    event.preventDefault();
                    return false;
                }
            });
        }
        
    }
</script>

<?php
    //Cerrar la conexión a la base de datos
    $conn -> close ();
    require_once ("partials/footer.php");
?>