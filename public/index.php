<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../classes/ClassVideos.php';
require __DIR__ . '/../classes/ClassUsers.php';


$config['displayErrorDetails'] = true;
$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "123456";
$config['db']['dbname'] = "myplaylist";


$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer( __DIR__ . '/../templates/');

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/', function (Request $request, Response $response, array $args) {
	session_start(); 
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getVideos();
    // Render index view
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "router" => $this->router]);
});

$app->get('/topten', function (Request $request, Response $response, array $args) {
	session_start(); 
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getTopTen();
    // Render index view
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "topten" => "true", "router" => $this->router]);
});

$app->get('/login', function (Request $request, Response $response, array $args) {
	session_start();	
	if(  isset($_SESSION['username']) )
	{
		return $response->withRedirect('/');
	}
    $messager = "";
    return $this->view->render($response, 'login.phtml', ["messager" => $messager, "router" => $this->router]);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
	session_start();	
	session_destroy();
	unset($_SESSION['username']);
    return $response->withRedirect('/'); 
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $messager = "";
    $user = new ClassUsers($this->db);
    $data = $request->getParsedBody();   
    $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
    $pass = filter_var($data['password'], FILTER_SANITIZE_STRING);
    
    $check = $user->checkLogin($username,$pass);

    if(!$check)
    	$messager = "Please input corect username and password!";
    else
    {    
     	session_start();	
    	$_SESSION['username']=$username;
    	return $response->withRedirect('/'); 
    }
    return $this->view->render($response, 'login.phtml', ["messager" => $messager, "router" => $this->router]);
});

$app->get('/addvideos', function (Request $request, Response $response) {    
	session_start();	
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
    $video_id = (int)$args['id'];    
    $classvideos = new ClassVideos($this->db);
    $videos =  $classvideos->getTopTen();
    $video = $classvideos->getVideoById($video_id);
    $play = $video;
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "play" => $play,"router" => $this->router]);
});

$app->get('/votes/{id}', function (Request $request, Response $response, $args) {
    $video_id = (int)$args['id'];    
    $classvideos = new ClassVideos($this->db);
    $video = $classvideos->getVideoById($video_id);
    $votes = 0;
    if(count($video)>0)
    	$votes = (int)$video[0]['votes']+1;
    $e = $classvideos->VotesVideo($video_id, $votes);  
    $videos =  $classvideos->getTopTen();    
    $play = $classvideos->getVideoById($video_id); 
    return $this->view->render($response, 'index.phtml', ["videos" => $videos, "play" => $play,"router" => $this->router]);	
});

$app->run();
