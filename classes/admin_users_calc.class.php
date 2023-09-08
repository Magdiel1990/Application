<?php
class AdminUserCalc {
    //Método para determinar el total de usuarios
    private function totalUsers () {
        //Conexión a la base de datos
        $conn = DBConnection::dbConnection();

        $result = $conn -> query ("SELECT id FROM users;");

        $num_rows = $result -> num_rows;

        return $num_rows; 
    }
    //Método para determinar los usuarios que son administradores
    private function adminUsers () {
        //Conexión a la base de datos
        $conn = DBConnection::dbConnection();

        $result = $conn -> query ("SELECT u.id FROM users u JOIN roles r ON r.id = u.role_id WHERE r.role = 'Admin';");

        $num_rows = $result -> num_rows;

        return $num_rows; 
    }
    //Método para establecer las condiciones de borrado de usuario
    public function adminCond () {
        $totalCount = $this -> totalUsers();
        $adminCount = $this -> adminUsers();

        if($totalCount > 0 && $adminCount == 0) {
            return false;
        } else if ($totalCount == 1 && $adminCount == 1) {
            return false;
        } else {
            return true;
        }        
    } 
}

?>