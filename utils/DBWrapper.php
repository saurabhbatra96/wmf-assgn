<?php
/**
 * This class acts as the data access layer.
 */
class DBWrapper {
	// Future me [TODO]: These don't belong here! There should be a more secure way of doing this.
	private $host = "localhost";
	private $user = "root";
	private $pass = "root";
	private $dbname = "test";

	private $conn;

	public function __construct() {
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
		if ($mysqli->connect_errno) {
			throw new Exception("Error connecting to DB: ".$mysqli->connect_error);
		}
	}

	public function doInsertOrUpdate($currency, $rate) {
		// Insert or update record based on whether the key - currency
		// was present before or not.
		$query_string = 'insert into currency_rates(currency, conv_rate) values("'.$currency.'", '.$rate.') on duplicate key update currency="'.$currency.'", conv_rate='.$rate.';';

		if ($this->conn->query($query_string)) {
			echo $currency." now set to ".$rate.".\n";
		} else {
			throw new Exception("Error inserting values: ".$currency.",".$rate.".");
			
		}
	}

	public function doSelectAll() {
		$result = array();
		$query_string = 'select currency, conv_rate as rate from currency_rates;';
		$response = $this->conn->query($query_string);

		if ($reponse = $this->conn->query($query_string)) {
			while ($row = $response->fetch_assoc()) {
				$result[$row['currency']] = $row['rate'];
			}
		} else {
			throw new Exception("Error getting values from DB.");
		}

		return $result;
	}

	public function close() {
		$this->conn->close();
	}
}
?>