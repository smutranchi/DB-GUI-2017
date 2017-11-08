<?php

class ClassUsersLikeVideos 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function UserVotesVideo($username, $videos_id) {

        $sql = "insert into users_like_videos
            (username, videos_id) values
            (:username, :videos_id)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "username" => $username,
            "videos_id" => $videos_id,            
        ]);

        if(!$result) {
            return 'Error! No database connection.';

        }
        return 'Thank you for registering!';
    }
       
    public function checkUserIsLikeVideo($username, $videos_id) {
        $sql = "SELECT *
            from users_like_videos WHERE username = '$username' AND videos_id = $videos_id";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        return count($results)> 0 ? true : false;
    }
}
