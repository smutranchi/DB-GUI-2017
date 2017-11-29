<?php

use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';
//require __DIR__ . '/../classes/ClassVideos.php';
//require __DIR__ . '/../classes/ClassUsers.php';
//require __DIR__ . '/../classes/ClassUsersLikeVideos.php';


// get list playlist
$app->get('/playlist', function (Request $request, Response $response, array $args) {
	$pdo = $this->db;
	$stmt = $pdo->prepare('SELECT p.playlist_id, p.title, p.user_id, 
				access_code, a.song_id, l.url
				FROM playlists as p INNER JOIN active as a
				ON p.playlist_id = a.playlist_id
				INNER JOIN library as l 
				ON a.song_id = l.song_id');
	$stmt->execute();
	$row = $stmt->fetchAll();
		return $this->response->withJson($row);
});

// Retrieve playlist with id 
$app->get('/playlist/[{id}]', function ($request, $response, $args) {
        $pdo = $this->db;
	$sth = $pdo->prepare('SELECT p.playlist_id, p.title, p.user_id,
                                access_code, a.song_id, l.url
                                FROM playlists as p INNER JOIN active as a
                                ON p.playlist_id = a.playlist_id
                                INNER JOIN library as l
                                ON a.song_id = l.song_id WHERE p.playlist_id=:id');
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $row = $sth->fetchObject();
        return $this->response->withJson($row);
    });



