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
            from videos ORDER BY votes DESC LIMIT 0, 10";
            
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
	$sql = "SELECT count(*) FROM  library WHERE url = '$link'";
		

		function get_youtube_id_from_url($url)
			{
			if (stristr($url,'youtu.be/'))
				{preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
			else 
				{@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
			}

			$stmt = $this->db->query($sql);;
			$results = [];
        		while($row = $stmt->fetch()) {
            			$results[] = $row;
       			 }
			if(is_null($results)){
				$sql = "INSERT INTO library (url) VALUES ('$link')";
				$stmt = $this->db->query($sql);
				$JSON = json_encode(array("url" => $link));
				return $JSON;
			}
			else{	
				$JSON = json_encode($results);
				return $JSON;
			}
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
            return 'Error! No database connection.';

        }
        return 'You voted for video!';

    }
    
}
