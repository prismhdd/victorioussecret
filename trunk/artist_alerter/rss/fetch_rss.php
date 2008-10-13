<?php
/*
 * see http://us3.php.net/manual/en/function.xml-set-element-handler.php
 */
 $current_tag = '';
function start_element_handler($xml_parser, $name, $attributes) {
	global $current_tag;
	if ($name == 'ITMS:ARTIST' || $name == 'ITMS:ALBUM') {
		$current_tag = $name;
	} else {
		$current_tag = '';
	}
	if ($name == 'ITMS:ARTIST')
		print '<br/>';
}

function character_data_handler($xml_parser, $data) {
	global $current_tag;
	if ($current_tag == 'ITMS:ARTIST' || $current_tag == 'ITMS:ALBUM') {
		print $data . ' ';	
	}
}

//Fetches an rss feed from a remote source
require_once('ITunesRssFeed.php');
$feed = new ITunesRssFeed('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=100/rss.xml');
$xml_data =$feed->getFeedData();
//print htmlentities($xml_data);

//Parse the xml we got
$xml_parser = xml_parser_create();
//setup the handlers
xml_set_element_handler($xml_parser, start_element_handler, FALSE);
xml_set_character_data_handler($xml_parser, character_data_handler);
if (!xml_parse($xml_parser, $xml_data)) {
	print('Error parsing xml');
}
?>
