<?php
/**
 * This contains the cron job which gets the API data and stores it in the DB.
 */

require("utils/DBWrapper.php");
require("utils/APICallWrapper.php");

// API call wrapper. Returns the XML data as an array.
$api = new APICallWrapper("https://wikitech.wikimedia.org/wiki/Fundraising/tech/Currency_conversion_sample?ctype=text/xml&action=raw");
$conversion_map = $api->getDataAsArray();

// Store API returned data into MySQL.
try {
	$db = new DBWrapper();
} catch(Exception $e) {
	echo $e->getMessage();
}

foreach ($conversion_map as $currency => $rate) {
	try {
		$db->doInsertOrUpdate($currency, $rate);
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}

$db->close();
?>