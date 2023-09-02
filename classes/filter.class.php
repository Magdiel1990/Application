<?php
//Sanitización de los inputs
class Filter {
    private $input;
    private $type; 

    function __construct($input, $type){
        $this -> input = $input;
        $this -> type = $type;
    }

    public function sanitization() {
        $dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
        $conn = $dbConection -> dbConnection ();

        $this -> input = mysqli_real_escape_string($conn, $this -> input);   
        $this -> input = htmlspecialchars($this -> input);
        $this -> input = filter_var($this -> input, $this -> type);
        $this -> input = trim($this -> input);
        $this -> input = stripslashes($this -> input);
        return $this -> input;
    }
}
?>