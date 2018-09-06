<?php
/**
 * This class handles API calls.
 */
class APICallWrapper {

	private $curl;

	public function __construct($url) {
		$curl_obj = curl_init();
		curl_setopt($curl_obj, CURLOPT_URL, $url);
		curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, 1);
		$this->curl = $curl_obj;
	}

	public function getDataAsArray() {
		$response = curl_exec($this->curl);

		$xml = simplexml_load_string($response);
		
		$result = array();

		foreach ($xml->conversion as $element)
			$result[(string) $element->currency] = (float) $element->rate;

		return $result;
	}
}
?>