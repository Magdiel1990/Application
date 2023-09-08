<?php
//Lista de roles
class RoleList {
    private $table;

    function __construct($table){
        $this -> table = $table;
    }

    public function roleOptions() {
        $conn = DBConnection::dbConnection();

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