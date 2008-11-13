<?php
require_once ('RssFeed.php');

class ITunesRssFeed extends RssFeed {

	private $current_tag = '';
	private $current_data = '';
	private $current_artist = '';
	private $artists = array ();

	public function __construct($url) {
		parent :: __construct($url);
	}

	//see http://us3.php.net/manual/en/function.xml-set-element-handler.php

	private function start_element_handler($xml_parser, $name, $attributes) {
		$this->current_tag = $name;
	}
	
	/**
	 * Handles the data after we approach its end element
	 */
	private function end_element_handler($xml_parser, $name) {
		if ($this->current_tag == 'ITMS:ARTIST') {
			$this->current_artist = $this->current_data;
		} 
		if ($this->current_tag == 'ITMS:ALBUM') {
			//add album to the artist
			$this->artists[$this->current_artist]['album']['album'] = $this->current_data;
		}
		if ($this->current_tag == 'ITMS:ALBUMLINK') {
			//add album link
			$this->artists[$this->current_artist]['album']['albumlink'] = $this->current_data;
		}
		if ($this->current_tag == 'ITMS:COVERART') {
			//add album link
			$this->artists[$this->current_artist]['album']['coverart'] = $this->current_data;
		}
		$this->current_tag = '';
		$this->current_data = '';
	}

	
	/**
	 * Just appends the data inbetween start/end elements
	 */
	private function character_data_handler($xml_parser, $data) {
		$this->current_data .= $data;
	}

	/**
	 * Attempts to parse the xml from the rss feed and returns an associate array in 
	 * which the keys are the artist names and the values are an array of albums
	 */
	public function getArtists() {
		//Parse the xml we got
		$xml_parser = xml_parser_create();
		xml_set_object($xml_parser, $this);
		//setup the handlers
		xml_set_element_handler($xml_parser, start_element_handler, end_element_handler);
		xml_set_character_data_handler($xml_parser, character_data_handler);
		if (!xml_parse($xml_parser, $this->getFeedData())) {
			//TODO throw an error
			print ('Error parsing xml');
		} else {
			return $this->artists;
		}
	}
}