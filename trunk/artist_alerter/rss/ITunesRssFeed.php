<?php
require_once('RssFeed.php');

 class ITunesRssFeed extends RssFeed {
 	
 	public function __construct($url) {
 		parent::__construct($url);
 	}
 	
 }