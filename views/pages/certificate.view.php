<?php
//Librería para generar PDF
require ("libraries/fpdf186/fpdf.php");
//Conexión a la base de datos
require ("classes/db_connection.class.php");
$conn = DBConnection::dbConnection();

if(isset ($_GET["cursoid"]) && isset ($_GET["userid"])) {
    $courseid = $_GET["cursoid"];
    $userid = $_GET["userid"];

    $sql = "SELECT concat_ws(' ', u.firstname, u.lastname) as `nombre completo`, cd.name as `curso` FROM users u JOIN courses_details cd ON cd.userid = u.id WHERE cd.id = '$courseid' AND u.id = '$userid';";
    $result = $conn -> query ($sql);

    if($result -> num_rows == 0) {
        http_response_code(404);

        require_once ("partials/head.php");
    
        require_once ("partials/nav.php");  
    
        require_once ("views/error/404.php");

        require_once ("partials/footer.php");

    } else {
    
    $row = $result -> fetch_assoc();

    $fullName = $row ["nombre completo"];
    $course = $row ["curso"];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
    }    
}


?>