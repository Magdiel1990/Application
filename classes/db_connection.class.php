<?php
//Clase de conección a base de datos
class DBConnection {
    private $hostname;
    private $username;
    private $password; 
    private $database;

    function __construct ($hostname, $username, $password, $database) { 
        $this -> hostname = $hostname;
        $this -> username = $username;
        $this -> password = $password;
        $this -> database = $database;
    } 
    
    //Conexión a la base de datos
    public function dbConnection() {

        $conn = new mysqli($this -> hostname, $this -> username,  $this -> password, $this -> database);
            
        return $conn;        
    }
}
?>