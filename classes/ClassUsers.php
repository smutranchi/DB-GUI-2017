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

    public function checkUserExists($user) {        
        $sql = "SELECT *
            from users WHERE username = '$user'";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return count($results)> 0 ? true : false;
    }

    public function register($user,$pass) {
        $pass = md5($pass); 

        $sql = "insert into users
            (username, pwd) values
            (:user, :pass)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "user" => $user,
            "pass" => $pass
        ]);

        if(!$result) {
            return 'Error! No database connection.';

        }
        return 'Thank you for registering!';
    }
    
}
