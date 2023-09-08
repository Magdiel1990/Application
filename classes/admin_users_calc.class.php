<?php
class AdminUserCalc {
    private function totalUsers () {
        $dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
        $conn = $dbConection -> dbConnection ();

        $result = $conn -> query ("SELECT id FROM users;");

        $num_rows = $result -> num_rows;

        return $num_rows; 
    }

    private function adminUsers () {
        $dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
        $conn = $dbConection -> dbConnection ();

        $result = $conn -> query ("SELECT u.id FROM users u JOIN roles r ON r.id = u.role_id WHERE r.role = 'Admin';");

        $num_rows = $result -> num_rows;

        return $num_rows; 
    }

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