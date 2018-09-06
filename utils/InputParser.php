<?php
/**
 * This class helps parse CLI input.
 */
class InputParser {
	private $REGEX_SINGLE_EXPR = "/^(\w+) ([0-9].[0-9]*)/";
	private $REGEX_ARRAY_EXPR = "/^array/";
	private $REGEX_ARRAY_VALUES_EXPR = "/'(.*?)'/";

	public function parse($text) {
		// Check if array by checking the starting substring.
		if (preg_match($this->REGEX_ARRAY_EXPR, $text)) {
			// Hack to parse array.
			preg_match_all($this->REGEX_ARRAY_VALUES_EXPR, $text, $matches);
			
			$requests = array();

			foreach ($matches[1] as $single) {
				$singleresult = $this->parseSingle($single);
				array_push($requests, $singleresult);
			}

			$result = array(
				'is_array' => true,
				'requests' => $requests,
			);

			return $result;
		} else {
			return $this->parseSingle($text);
		}
		
	}

	public function parseSingle($text) {
		// Parse single amounts only.
		preg_match($this->REGEX_SINGLE_EXPR, $text, $matches);
		$result = array(
			'is_array' => false,
			'currency' => $matches[1],
			'amount' => $matches[2], 
		);

		return $result;
	}
}
?>