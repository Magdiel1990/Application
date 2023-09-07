<nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4">
  <a class="navbar-brand" href="<?php echo root ;?>">Inicio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo root . "cursos";?>">Cursos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo root . "alumnos";?>">Alumnos</a>
      </li>
      <li class="nav-item">
        <a id="exit" class="nav-link" href="<?php echo root . "salir";?>">Salir</a>
      </li>
    </ul>
  </div>
</nav>

<script>
  //Mensaje de confirmación de salida de la aplicación
  let exit = document.getElementById("exit");

  exit.addEventListener("click", function(event){
    if (confirm("Desea salir de la aplicación?")) {
      return true;
    } else {
      event.preventDefault();
      return false;
    }
  });
</script>