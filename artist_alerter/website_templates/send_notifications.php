<?php

require_once('../database/config.php');

$conn = Doctrine_Manager :: connection(DSN);

function sendMail($from, $namefrom, $to, $nameto, $subject, $message) {	
	/*  your configuration here  */
	$smtpServer = "ssl://smtp.gmail.com"; //does not accept STARTTLS
	$port = "465"; // try 587 if this fails
	$timeout = "45"; //typical timeout. try 45 for slow servers
	$username = "teamvictorioussecret"; 
	$password = "sddisawesome";
	$localhost = $_SERVER['REMOTE_ADDR']; 
	$newLine = "\r\n"; //var just for newlines
	 
	/*  you shouldn't need to mod anything else */
	
	//connect to the host and port
	$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
	//echo $errstr." - ".$errno;
	$smtpResponse = fgets($smtpConnect, 4096);
	if(empty($smtpConnect))
	{
	   $output = "Failed to connect: $smtpResponse";
	   //echo $output;
	   return $output;
	}
	else
	{
	   $logArray['connection'] = "Connected to: $smtpResponse";
	   //echo "connection accepted<br>".$smtpResponse."<p />Continuing<p />";
	}
	
	//you have to say HELO again after TLS is started
	   fputs($smtpConnect, "HELO $localhost". $newLine);
	   $smtpResponse = fgets($smtpConnect, 4096);
	   $logArray['heloresponse2'] = "$smtpResponse";
	  
	//request for auth login
	fputs($smtpConnect,"AUTH LOGIN" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authrequest'] = "$smtpResponse";
	
	//send the username
	fputs($smtpConnect, base64_encode($username) . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authusername'] = "$smtpResponse";
	
	//send the password
	fputs($smtpConnect, base64_encode($password) . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['authpassword'] = "$smtpResponse";
	
	//email from
	fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['mailfromresponse'] = "$smtpResponse";
	
	//email to
	fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['mailtoresponse'] = "$smtpResponse";
	
	//the email
	fputs($smtpConnect, "DATA" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['data1response'] = "$smtpResponse";
	
	//construct headers
	$headers = "MIME-Version: 1.0" . $newLine;
	$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
	$headers .= "To: $nameto <$to>" . $newLine;
	$headers .= "From: $namefrom <$from>" . $newLine;
	
	//observe the . after the newline, it signals the end of message
	fputs($smtpConnect, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['data2response'] = "$smtpResponse";
	
	// say goodbye
	fputs($smtpConnect,"QUIT" . $newLine);
	$smtpResponse = fgets($smtpConnect, 4096);
	$logArray['quitresponse'] = "$smtpResponse";
	$logArray['quitcode'] = substr($smtpResponse,0,3);
	fclose($smtpConnect);
	//a return value of 221 in $retVal["quitcode"] is a success
	return($logArray);
}

//First find all the notifications we have to send for any new albums that came out

//find every new album within the past 24 hours, and find each user who has the
//artist that made the album in the library, and the user does not have the album already

//select * from user_artists ua, albums a where ua.artist_id=a.artist_id and a.album_id not in (select album_id from user_albums where user_id=2) and a.date_added >= '2008-11-02';
$past_24hrs = date('Y-m-d', time() - 24*60*60);
$new_albums =Doctrine_Query::create()
						->select('a.artist_id, a.album_id, a.name, a.date_added, artist.name')
						->from('Album a')
						->innerJoin('Artist artist')
						->where('a.date_added >=?', $past_24hrs)
						->execute(array(), Doctrine::HYDRATE_ARRAY);
						
$emails_to_send = array();

$album_info_url = 'http://'.$_SERVER['SERVER_NAME']. dirname($_SERVER['PHP_SELF']) .'/view_album_info.php';
foreach($new_albums as $new_album) {
	
	$query = Doctrine_Query::create()
						->select('u.user_id')
						->from('User u')
						->where('u.Artist.artist_id=? AND ? NOT IN (SELECT ualb.album_id FROM UserAlbum ualb WHERE ualb.user_id=u.user_id)',array($new_album['artist_id'],$new_album['album_id']));
	$users =  $query->execute(array(), Doctrine::HYDRATE_ARRAY);
	if ($users)  {
		foreach($users as $user) {
			$text = 'The artist \''. $new_album['Artist']['name'] .'\''; 
			$text .=  ' just released a new album entitled \''. $new_album['name'].'\'.';
			$text .= ' For more details please click <a href="'.$album_info_url.'?id='.$new_album['album_id'].'">here</a>.'; 
			 $emails_to_send[$user['user_id']][] = $text;
			//print('Notification for '. $user['first_name'] .' in relation to the album '.$new_album['name'].'<br/>');	
		}
	}
}
						
//for when a person adds a new artist and the artist has had a new album in the past month
//do it by the date the user added that artist
//first get all users that added stuff in the past 24 hours
$new_user_artists = Doctrine_Query::create()
						->select('ua.date_added, artist.artist_id, artist.name')
						->from('UserArtist ua')
						->innerJoin('ua.Artist artist')
						->where('ua.date_added>=?', $past_24hrs)
						->execute(array(), Doctrine::HYDRATE_ARRAY);
						
foreach($new_user_artists as $new_user_artist) {
	//check if the artist has a new album
	$new_albums = $query = Doctrine_Query::create()
					->select('a.artist_id, a.album_id, a.date_added, a.name')
					->from('Album a')
					->where('a.artist_id=? AND a.album_id NOT IN (SELECT ualb.album_id FROM UserAlbum ualb WHERE ualb.user_id=?) AND a.date_added<?',array($new_user_artist['artist_id'],$new_user_artist['user_id'],$past_24hrs))
					->execute(array(), Doctrine::HYDRATE_ARRAY);
	foreach($new_albums as $new_album) {
		$text = 'The artist \''. $new_user_artist['Artist']['name'] .'\''; 
		$text .=  ' just released a new album entitled \''. $new_album['name'].'\'.';
		$text .= ' For more details please click <a href="'.$album_info_url.'?id='.$new_album['album_id'].'">here</a>.'; 
		 $emails_to_send[$new_user_artist['user_id']][] = $text;
		//print('Notification for '. $user['first_name'] .' in relation to the album '.$new_album['name'].'<br/>');
	}
}

$user_ids = array_keys($emails_to_send);
//var_dump($emails_to_send);
//var_dump($user_ids);
foreach($user_ids as $user_id) {
	$user =Doctrine_Query::create()
						->select('u.email_address, u.user_id, u.first_name')
						->from('User u')
						->where('u.user_id=?', $user_id)
						->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
	print('Sending notification to ' .$user['email_address']);
	print('<br/>');
	$message = 'Hello, new albums have been released by your favorite artists:<br/>';
	$message .= implode($emails_to_send[$user_id],"\n<br/>");
	//print($message);
	sendMail('teamvictorioussecret@gmail.com', 'Artist Alert',$user['email_address'], $user['first_name'], '[Artist Alerter] New Albums Released', $message);
}
