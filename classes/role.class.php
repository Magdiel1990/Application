<?php
//Lista de roles
class RoleList {
    private $table;

    function __construct($table){
        $this -> table = $table;
    }

    public function roleOptions() {
        $dbConection = new DBConnection ("localhost:3306", "root", "123456", "courses");
        $conn = $dbConection -> dbConnection ();

        $result = $conn -> query ("SELECT * FROM " . $this -> table . ";");

        $html = "";

        if($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
                $html .= "<option value='" . $row["id"] . "'>" . ucfirst($row["role"]) . "</option>";
            }
        }

        return $html;
    }
}
?>