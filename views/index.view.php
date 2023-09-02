<?php
    require_once("partials/head.php");

    require_once("partials/header.php");    

    require_once("partials/nav.php");    
?>
    <main >
        This is the main
    </main>

<?php
    //Cerrar la conexión a la base de datos
    $conn -> close ();
    require_once ("partials/footer.php");
?>