<?php
/**
 * This contains the CLI-app. Input can either be a single amount or an array.
 */

require("utils/InputParser.php");
require("utils/DBWrapper.php");

try {
	$db = new DBWrapper();
} catch(Exception $e) {
	echo $e->getMessage();
}

try {
	$conversion_map = $db->doSelectAll();
} catch(Exception $e) {
	echo $e->getMessage();
}

$ip = new InputParser();

while (true) {
	$inp = readline("input:");

	// Check for exit.
	if ($inp === "exit")
		break;

	$result = $ip->parse($inp);
	$resp_string = "";

	// Future me [TODO]: add a check for faulty input - eg. "notacurrency 800"!
	// Future me [TODO]: USD amount should be rounded off so we only have 2 numbers trailing
	// after the floating point.

	// Check if input is in the form of an array or not.
	if ($result['is_array']) {
		$resp_string .= "array(";
		// Convert to USD amount for each request.
		foreach ($result['requests'] as $request) {
			$rate = $conversion_map[$request['currency']];
			$amount = (float) $request['amount'];
			$usd_amount = $rate*$amount;
			$resp_string .= "'USD ".$usd_amount."',";
		}
		$resp_string .= ")";
	} else {
		// Convert to USD amount for single request.
		$rate = $conversion_map[$result['currency']];
		$amount = (float) $result['amount'];
		$usd_amount = $rate*$amount;
		$resp_string .= "USD ".$usd_amount;
	}

	echo "output: ".$resp_string."\n";
}
$db->close();
?>