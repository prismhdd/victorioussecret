<?php

function get_it($url) {

	$url = preg_replace("@^http://@i", "", $url);
	$host = substr($url, 0, strpos($url, "/"));
	$uri = strstr($url, "/");

	$reqheader = "GET $uri HTTP/1.1\r\n" .
	"Host: $host\n" . "User-Agent: ArtistAlert\r\n" .
	"Content-Type: text/xml\r\n" .
	"Connection:  Close\r\n\r\n";
	$socket = fsockopen($host, 80, $errno, $errstr);

	if (!$socket) {
		$result["errno"] = $errno;
		$result["errstr"] = $errstr;
		return $result;
	}

	fputs($socket, $reqheader);

	while (!feof($socket)) {
		$result  .= fgets($socket, 4096);
	}

	fclose($socket);

	return $result;
}

function get_rss_feed($url) {
	return get_it($url);
}

$rss_data = get_rss_feed('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=100/rss.xml');

print htmlentities($rss_data);
?>
