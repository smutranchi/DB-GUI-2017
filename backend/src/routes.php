<?php

use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../classes/ClassVideos.php';
require __DIR__ . '/../classes/ClassUsers.php';
require __DIR__ . '/../classes/ClassUsersLikeVideos.php';

//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;

// Routes

/*$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/
//homepage of the video
$app->get('/', function (Request $request, Response $response, array $args) {
    if(session_id() == ''){
        session_start(); 
    } 
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getVideos();
    // Render index view
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "router" => $this->router]);
});

$app->get('/topten', function (Request $request, Response $response, array $args) {
    if(session_id() == ''){
        session_start(); 
    } 
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getTopTen();
    // Render index view
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "topten" => "true", "router" => $this->router]);
});

$app->get('/login', function (Request $request, Response $response, array $args) {
	if(session_id() == ''){session_start();}	
	if(  isset($_SESSION['username']) )
	{
		return $response->withRedirect('/');
	}
    $messager = "";
    return $this->view->render($response, 'login.phtml', ["messager" => $messager, "router" => $this->router]);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
	if(session_id() == ''){session_start();}	
	session_destroy();
	unset($_SESSION['username']);
    return $response->withRedirect('/'); 
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $messager = "";
    $user = new ClassUsers($this->db);
    
    $json = $request->getBody();   
    $mydata = json_decode($json,true);    
    $username = $mydata["username"];
    $pass = $mydata["password"];

    $check = $user->checkLogin($username,$pass);

    
    $url = "";
    if(!$check)
        $messager = "Please input corect username and password!";
    else
    {    
        if(session_id() == ''){session_start();}    
        $_SESSION['username']=$username;
        $url = "/";
    }
    $data = array('messager' => $messager , 'url' => $url);   
    return $response->withJson($data,200,
        JSON_UNESCAPED_UNICODE);    
});

$app->get('/addvideos', function (Request $request, Response $response) {    
	if(session_id() == ''){session_start();}	
	if(!isset($_SESSION['username']) )
	{
		return $response->withRedirect('/login');
	}
    return $this->view->render($response, 'addvideo.phtml', ["router" => $this->router]);
});

$app->post('/addvideos', function (Request $request, Response $response) {    
	
	$data = $request->getParsedBody();	
	$title = filter_var($data['txttitle'], FILTER_SANITIZE_STRING);
    $link = filter_var($data['txtlink'], FILTER_SANITIZE_STRING);
    $classvideos = new ClassVideos($this->db);
    $addvideo =  $classvideos->AddNewVideo($title, $link);    
    return $this->view->render($response, 'addvideo.phtml', ["addvideo" => $addvideo, "router" => $this->router]);
});

$app->get('/play/{id}', function (Request $request, Response $response, $args) {
    if(session_id() == ''){session_start();}
    $video_id = (int)$args['id'];    
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getTopTen();
    $video = $classvideos->getVideoById($video_id);
    $play = $video;
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "play" => $play,"router" => $this->router]);
});

$app->get('/votes/{id}', function (Request $request, Response $response, $args) {    
    if(session_id() == ''){session_start();}
    $video_id = (int)$args['id'];    
    $islike = false;
    $disableBtnLike = "";
    $classlikevideo = new ClassUsersLikeVideos($this->db);
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];        
        $islike = $classlikevideo->checkUserIsLikeVideo($username, $video_id );    
    }
    $classvideos = new ClassVideos($this->db);
    if(!$islike)
    {
        $video = $classvideos->getVideoById($video_id);
        $votes = 0;
        if(count($video)>0)
            $votes = (int)$video[0]['votes']+1;
        $e = $classvideos->VotesVideo($video_id, $votes);  
        $userlike = $classlikevideo->UserVotesVideo($username, $video_id ); 
    }
    else
    {
        $disableBtnLike = "disabled='disabled'";
    }    
    $videos =  $classvideos->getVideos();    
    $play = $classvideos->getVideoById($video_id); 
    return $this->view->render($response, 'index.phtml', ["disableBtnLike" => $disableBtnLike, "videos" => $videos, "play" => $play,"router" => $this->router]);	
});

$app->get('/register', function (Request $request, Response $response, array $args) {
    #if(session_id() == ''){session_start();} 
    return $response->withStatus(200);
});

$app->post('/checkUserExists', function (Request $request, Response $response, array $args) {   
    $json = $request->getBody();   
    $mydata = json_decode($json,true);    
    $username = $mydata["username"];
    $user = new ClassUsers($this->db);
    $check = $user->checkUserExists($username);
    $isexists = "";
    if($check) $isexists = "isexists";
    $data = array('checkExists' => $check , 'username' => $username, 'isexists' => $isexists);   
   return $response->withJson($data,200,
        JSON_UNESCAPED_UNICODE);
});

$app->post('/register', function (Request $request, Response $response, array $args) {
    $json = $request->getBody();   
    $userData = json_decode($json,true);    
    $username = $userData["username"];
    $pass = $userData["password"];
    $fName = $userData["firstName"];
    $lName = $userData["lastName"];
    $email = $userData["email"];
    $user = new ClassUsers($this->db);
    if($user->register($username, $pass){
    $data = array('username' => $username);   
    return $response->withJson($data,200,
        JSON_UNESCAPED_UNICODE);
    }
    else{
	return $response->withRedirect('/register');
    }
});

//for searching video
$app->get('/search-video', function (Request $request, Response $response, $args) {
     if(session_id() == ''){session_start();}  
    return $this->view->render($response, 'search-video.phtml', ["router" => $this->router]);
});

$app->post('/search-video', function (Request $request, Response $response, $args) {
	$data = $request->getParsedBody();	
	$keyword = '';
	$keyword = filter_var($data['keyword'], FILTER_SANITIZE_STRING);
	
	$message = "";
	$videos = '';
	$channels = '';
	$playlists = '';
		
	$DEVELOPER_KEY = 'AIzaSyDyJOLf4HzvRa6yGcgoF_bSa7zK2H4yGjw';

	$client = new Google_Client();
	$client->setDeveloperKey($DEVELOPER_KEY);

	// Define an object that will be used to make all API requests.
	$youtube = new Google_Service_YouTube($client);

	try {

		// Call the search.list method to retrieve results matching the specified
		// query term.
		$searchResponse = $youtube->search->listSearch('id,snippet', array(
		  'q' => $keyword,
		  'maxResults' => 10,
		));

		
        $listVideo = [];
		// Add each result to the appropriate list, and then display the lists of
		// matching videos, channels, and playlists.
        $i = 0;
		foreach ($searchResponse['items'] as $searchResult) {
		  switch ($searchResult['id']['kind']) {
			case 'youtube#video':
			  $videos .= sprintf('<li>%s (%s)</li>',
				  $searchResult['snippet']['title'], $searchResult['id']['videoId']);
                  $listVideo[$i]['title']   =  $searchResult['snippet']['title'];//, 'id':  };
                  $listVideo[$i]['id']      =  $searchResult['id']['videoId'];
                  $i++;
			  break;
			case 'youtube#channel':
			  $channels .= sprintf('<li>%s (%s)</li>',
				  $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                    $listVideo[$i]['title']    =  $searchResult['snippet']['title'];
                    $listVideo[$i]['id']       =  $searchResult['id']['channelId'];
                    $i++;
			  break;
			case 'youtube#playlist':
			  $playlists .= sprintf('<li>%s (%s)</li>',
				  $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
                    $listVideo[$i]['title']       =  $searchResult['snippet']['title'];
                    $listVideo[$i]['id']          =  $searchResult['id']['playlistId'];
                    $i++;
			  break;
		  }
		}

	} catch (Google_Service_Exception $e) {
		$message .= sprintf('<p>A service error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	} catch (Google_Exception $e) {
		$message .= sprintf('<p>An client error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	}
    $message = count($listVideo);
    return $this->view->render($response, 'search-video.phtml', ["keyword" => $keyword, "message" => $message, "videos" => $videos, "listVideo" => $listVideo, "router" => $this->router]);
});

// test new login
$app->get('/old-login', function (Request $request, Response $response, array $args) {
	if(session_id() == ''){session_start();}	
	if(  isset($_SESSION['username']) )
	{
		return $response->withRedirect('/');
	}
    $messager = "";
    return $this->view->render($response, 'old-login.phtml', ["messager" => $messager, "router" => $this->router]);
});

