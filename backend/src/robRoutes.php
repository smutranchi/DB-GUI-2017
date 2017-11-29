<?php
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../classes/ClassVideos.php';
require __DIR__ . '/../classes/ClassUsers.php';
require __DIR__ . '/../classes/ClassUsersLikeVideos.php';


$app->get('/login', function (Request $request, Response $response, array $args) {
        if(session_id() == ''){session_start();}
    return $request;
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $json = $request->getBody();
    $mydata = json_decode($json,true);
    $username = $mydata["username"];
    $pass = $mydata["password"];
    $pass = md5($pass);
      $sql = "SELECT user_id
            from users WHERE username = '$username' AND password = '$pass'";
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
    $url = " ";
        if(count($results)> 0 ? true : false){
        if(session_id() == ''){session_start();}
        $url = "/";
        }
        $myJSON = json_encode(array($results));
        $response = $response->withRedirect('/');       
        $response = $response->withJSON($myJSON);
    return $response;
});

$app->get('/addvideos', function (Request $request, Response $response) {
        if(session_id() == ''){session_start();}
        if(!isset($_SESSION['username']) )
        {
                return $response->withRedirect('/login');
        }
    return $response;
});

$app->post('/addvideos', function (Request $request, Response $response) {
        $data = $request->getBody();
        $data = json_decode($data,true);
        $title = $data["title"];
        $link = $data["link"];
        $classvideos = new ClassVideos($this->db);
        $addvideo =  $classvideos->AddNewVideo($title, $link);
        $JSON = json_encode(array("title" => $title, "link" => $link));
        $response =  $response->withJSON($JSON);
        $response =  $response->withRedirect("/");
        return $response;
});

$app->get('/active/{id}', function ( Request $request, Response $response, array $args) {
        $active_id = (int)$args['id'];
        $sql = "  SELECT library.url FROM library INNER JOIN
                active ON library.song_id = active.song_id
                  WHERE active_id = $active_id;";
        $stmt = $this->db->query($sql);
              $results = [];
        while($row = $stmt->fetch()) {
            $results[] = $row;
        }
        $JSON = json_encode(array($results));
        $response = $response->withJSON($JSON);
        $response = $response->withRedirect("/active/" + $active_id);
        return $response;
});

$app->post('/active/{id}/like',  function ( Request $request, Response $response, array $args) {
        $json = $request->getBody();
        $mydata = json_decode($json,true);
        $active_id = (int)$args['id'];
        $user_id = $mydata["user_id"];
        $sql = "SELECT access_code  FROM active INNER JOIN 
                playlists ON active.playlist_id = playlists.playlist_id
                 WHERE active_id = '$active_id';";
        $stmt = $this->db->query($sql);
        $sqlArray =  $stmt->fetch();
        $access_code = implode($sqlArray);
        echo $access_code;
        echo $user_id;
        $sql = "SELECT access_id FROM access
        WHERE access_code = '$access_code'
        AND user_id = '$user_id';";
        $stmt1 = $this->db->query($sql);
        $sqlArray = $stmt1->fetch();
        echo gettype($sqlArray);
        $intArr = implode( $sqlArray);
        echo $intArr;
        $access_id = implode($sqlArray);
        echo $access_id;

        $sql = "SELECT like_id FROM user_likes WHERE user_id = '$user_id' AND access_id = '$access_id' 
                AND active_id = $active_id;";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
                $results[] = $row;
        }
        //check if the user already liked the video
        if(count($results)> 0 ? true : false){
        //$response = $response->withRedirect("/active/");
        //might need to return some stuff JSON later
        echo "here2";
        return  $response;
        }
        echo "gets Here";
        $sql = "UPDATE active SET likes = likes + 1
                    WHERE active_id = '$active_id';";
        $this->db->query($sql);
        $sql = "INSERT INTO user_likes (access_id, user_id, active_id) VALUES 
                ('$access_id','$user_id','$active_id');";
        $this->db->query($sql);
        //$response = $response->withRedirect("/active/{id}");
        //might need to return some stuff JSON later*/
        return $response;
});

$app->post('/active/{id}/dislike',  function ( Request $request, Response $response, array $args) {
        $json = $request->getBody();
        $mydata = json_decode($json,true);
        $active_id = (int)$args['id'];
        $user_id = $mydata["user_id"];
        $sql = "SELECT access_code  FROM active INNER JOIN 
                playlists ON active.playlist_id = playlists.playlist_id
                 WHERE active_id = '$active_id';";
        $stmt = $this->db->query($sql);
        $sqlArray =  $stmt->fetch();
        $access_code = implode($sqlArray);
        echo $access_code;
        echo $user_id;
        $sql = "SELECT access_id FROM access
        WHERE access_code = '$access_code'
        AND user_id = '$user_id';";
        $stmt1 = $this->db->query($sql);
        $sqlArray = $stmt1->fetch();
        echo gettype($sqlArray);
        $intArr = implode( $sqlArray);
        echo $intArr;
        $access_id = implode($sqlArray);
        echo $access_id;

        $sql = "SELECT like_id FROM user_likes WHERE user_id = '$user_id' AND access_id = '$access_id' 
                AND active_id = $active_id;";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
                $results[] = $row;
        }
        //check if the user already liked the video
        if(count($results)> 0 ? true : false){
        //$response = $response->withRedirect("/active/");
        //might need to return some stuff JSON later
        return  $response;
        }
        $sql = "UPDATE active SET likes = likes - 1
                 WHERE active_id = '$active_id';";
        $this->db->query($sql);
        $sql = "INSERT INTO user_likes (access_id, user_id, active_id) VALUES 
                ('$access_id','$user_id','$active_id');";
        $this->db->query($sql);
        //$response = $response->withRedirect("/active/{id}");
        //might need to return some stuff JSON later
        return $response;
});     


$app->get('/user/{id}', function( Request $request, Response $response, array $args){
        $user_id = (int) $args['id'];
        $sql = "SELECT username,fName,lName,email FROM users WHERE user_id = '$user_id'";
         $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
                $results[] = $row;
        }
        $json = json_encode($results);
        $response = $response->withJSON($json);
        return $response;
});

$app->post('/user/{id}', function( Request $request, Response $response, array $args){
        $json = $request->getBody();
        $mydata = json_decode($json,true);
        $user_id = (int) $args['id'];
        $username = $mydata["username"];
        $fName = $mydata["fName"];
        $lName = $mydata["lName"];
        $email = $mydata["email"];
        $sql = "UPDATE users 
                SET username = '$username', fName = '$fName', lName = '$lName', email = '$email'
                WHERE user_id = '$user_id';";
        $this->db->query($sql);
        $response = $response->withJSON($json);
});

