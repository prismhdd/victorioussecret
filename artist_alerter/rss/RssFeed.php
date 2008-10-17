<?php
require_once('HttpCommunicator.php');
/**
 * Represents an RSS feed
 */
abstract class RssFeed {

	/** Where the feed is located */
	protected $url;
	protected $feed_xml;
	
	public function __construct($url) {
		$this->url = $url;
	}

	/**
	 * Fetches the feed data from $url, throws an exception if there was an error
	 * @return the data from the feed
	 */
	protected function getFeedData() {
		//Fetch the http data
		$http_result = HttpCommunicator::getInstance()->getRemoteFile($this->url);
		$http_data = HttpCommunicator::getInstance()->getHttpData($http_result);
		return $http_data;
	}
}