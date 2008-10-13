<?php

/**
 * Singleton class for dealing with HTTP communication
 */
class HttpCommunicator {
	static $instance;
	
	private function __construct() {
    }
	

	/**
	 * Returns an instance of the HttpCommunicator
	 */
	public static function getInstance() {
		if (!isset ($instance)) {
			$instance = new HttpCommunicator();
		}
		return $instance;
	}

	/**
	 * Fetches a remote file
	 * @param $url the file 
	 * @return the contents of the file including HTTP headers as a string
	 */
	public function getRemoteFile($url) {
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
			$result .= fgets($socket, 4096);
		}

		fclose($socket);

		return $result;
	}

	/**
	 * Returns the http headers (if they exist) for an http result
	 * @param $result the result of an http request
	 * @return the headers
	 */
	public function getHttpHeaders($result) {
		//HTTP headers end with \r\n\r\n
		$result_array = split("\r\n\r\n", $result);
		if (count($result_array) >= 1)
			return $result_array[0];
		else
			return '';
	}
	
	/**
	 * Returns the http data from an http result (i.e. the fetched file)
	 * @param $result the result of an http request
	 * @return the data
	 */
	public function getHttpData($result) {
		//HTTP headers end with \r\n\r\n
		$result_array = split("\r\n\r\n", $result);
		if (count($result_array) >= 2)
			return $result_array[1];
		else
			return '';
	}
}