<?php

require_once('../database/config.php');

$conn = Doctrine_Manager :: connection(DSN);

//First find all the notifications we have to send for any new albums that came out

//find every new album within the past 24 hours, and find each user who has the
//artist that made the album in the library, and the user does not have the album already

//select * from user_artists ua, albums a where ua.artist_id=a.artist_id and a.album_id not in (select album_id from user_albums where user_id=2) and a.date_added >= '2008-11-02';
$past_24hrs = date('Y-m-d', time() - 24*60*60);
$new_albums =Doctrine_Query::create()
						->from('Album a')
						->where('a.date_added >=?', $past_24hrs)
						->execute();

foreach($new_albums as $new_album) {
	
	$query = Doctrine_Query::create()
						->from('User u')
						->leftJoin('u.Artist ua')
						->where('ua.artist_id=? AND ? NOT IN (SELECT ualb.album_id FROM UserAlbum ualb WHERE ualb.user_id=u.user_id)',array($new_album['artist_id'],$new_album['album_id']));
	$users =  $query->execute();
	if ($users->count() > 0)  {
								
		foreach($users as $user) {
			print('Notification for '. $user['first_name'] .' in relation to the album '.$new_album['name'].'<br/>');	
		}
	}
}

						
//for when a person adds a new artist and the artist has had a new album in the past month
//do it by the date the user added that artist
//first get all users that added stuff in the past 24 hours
$new_user_artists = Doctrine_Query::create()
						->from('UserArtist ua')
						->where('ua.date_added>=?', $past_24hrs)
						->execute();
						
foreach($new_user_artists as $new_user_artist) {
	$user = $new_user_artist['User']; 
	//check if the artist has a new album
	$new_artist = $new_user_artist['Artist'];
		$new_albums = $query = Doctrine_Query::create()
						->from('Album a')
						->where('a.artist_id=? AND a.album_id NOT IN (SELECT ualb.album_id FROM UserAlbum ualb WHERE ualb.user_id=?) AND a.date_added<?',array($new_artist['artist_id'],$new_user_artist['user_id'],$past_24hrs))
						->execute();
		foreach($new_albums as $new_album) {
			print('Notification for '. $user['first_name'] .' in relation to the album '.$new_album['name'].'<br/>');
		}
}
