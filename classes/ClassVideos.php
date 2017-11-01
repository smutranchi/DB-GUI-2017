<?php

class ClassVideos 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getVideos() {
        $sql = "SELECT *
            from videos t";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return $results;
    }

    public function getTopTen() {
        $sql = "SELECT *
            from videos ORDER BY votes DESC";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return $results;
    }
    
     public function getVideoById($id) {
        $sql = "SELECT *
            from videos WHERE id = $id";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return $results;
    }

    public function AddNewVideo($title, $link) {
        //$sql = "INSERT INTO videos (title,link,votes) VALUES('$title','$link',0)";

        $sql = "insert into videos
            (title, link, votes) values
            (:title, :link, :votes )";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "title" => $title,
            "link" => $link,
            "votes" => 0,
        ]);

        if(!$result) {
            return 'error, not connect db';

        }
        return 'add video success!';
    }

    public function VotesVideo($id, $votes) {
        //$sql = "UPDATE videos SET votes = $votes WHERE id = $id";
        $sql = "update videos
            set votes = :votes WHERE id = :id";

        $stmt = $this->db->prepare($sql);    
        $result = $stmt->execute([
            "votes" => $votes,
            "id" => $id           
        ]);

        if(!$result) {
            return 'error, not connect db';

        }
        return 'add video success!';

    }
    
}
