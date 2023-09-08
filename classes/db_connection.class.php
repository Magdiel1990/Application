<?php
//Clase de conección a base de datos
class DBConnection {
    //Información de la base de datos    
    static $hostname = "localhost:3306";
    static $username = "root";
    static $password = "123456";
    static $database = "courses";

//Conexión a la base de datos
    public static function dbConnection(){
        $conn = new mysqli(self::$hostname, self::$username, self::$password, self::$database);
        
//Mensaje de error en la conexión
        if ($conn->connect_error) {
            die("Error en conexión: " . $conn->connect_error);
        }
        return $conn;
    }
}
    
?>

