INSERT INTO `users`(username, password, fName, lName, email) VALUES ('admin','e10adc3949ba59abbe56e057f20f883e', 'admin', 'admin', 'admin@localhost');
INSERT INTO `users` (username, password, fName, lName, email) VALUES('rob', 'pass', 'rob','keehan','email');
INSERT INTO `users` (username, password, fName, lName, email) VALUES('rick', 'pass', 'rick','simon','email');
INSERT INTO `playlists` (title, user_id, access_code) VALUES('playlist1', 1, '50');
INSERT INTO `access` (user_id, access_code) VALUES(2,50);
INSERT INTO `access` (user_id, access_code) VALUES(3,50);
INSERT INTO `library` (url) VALUES('http://www.youtube.com');
INSERT INTO `active` (user_id, song_id,playlist_id, likes) VALUES(2,1,1,0);
