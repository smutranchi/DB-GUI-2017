<?php

class ClassUsers 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkLogin($user,$pass) {
        $pass = md5($pass); 
        $sql = "SELECT *
            from users WHERE username = '$user' AND pwd = '$pass'";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return count($results)> 0 ? true : false;
    }
    
}
