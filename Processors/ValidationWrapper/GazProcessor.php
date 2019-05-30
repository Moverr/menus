
<?php

/**
 * @author egima
 *
 */
require_once __DIR__ . '/../../lib/integrationConfigs/ALTXConfigs.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';

class GazProcessor {

	private $log;
	private $request;
	private $curlErr = "";
	private $httpStatus = 0;

	private $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImdhelRvcFVwLm11bGFAY2VsbHVsYW50LmNvbSIsInBhc3N3b3JkIjoiJDJhJDEwJDJCM2IzY1luWG5yOVRkSlhWbUgwQU8ydXhSSkUvRFY3L0NuSTYzS3RycVNVZWNIQ1R1cEsyIiwidXNlcm5hbWUiOiJNdWxhX0NlbGx1bGFudCIsInJhbmRvbSI6Ik1VTEFfR0FaNDI4NjYxMTIzIiwiaWF0IjoxNTUzNzg0NTAxfQ.WBpkwbMWuRx5sgqjkmAuwgvaG1dFrduoY2bhdmi2EDw";

	private $tovutiUrl = "http://fcsexternalservice.azurewebsites.net/auth/customerAccount";

	public function __construct() {
		$this->log = new BeepLogger();
	}

	/**
	 * Function process validation request
	 * @param type $data
	 * @return type
	 */
	public function processRecord(ValidationHandler $data) {
		$this->request = $data;

		$payload = json_decode($data->extraData, true);

		// $payload['authorization'];
		$cardmask = $this->request->accountNumber;
		$params = array(

			"cardmask" => $cardmask,

		);

		$response = $this->postValidationRequestToHUB(json_encode($params), $this->authorization);

		$result = json_decode($response);

		if ((int) $result->error->error_code == 200) {
			$status['accountNumber'] = $result;
			$status['statusCode'] = Config::GENERIC_SUCCESS;
			$status['statusDescription'] = "Account has been validated successfully";
			$status['accountValid'] = "yes";
			$status['accountActive'] = "yes";
			$status['extraData'] = $result->Message;
			return $status;

		} else {

			$status['accountNumber'] = $cardmask;
			$status['statusCode'] = 404;
			$status['statusDescription'] = "Account has not veen verified";
			$status['accountValid'] = "no";
			$status['accountActive'] = "no";
			$status['extraData'] = (string) $response;
			return $status;

		}

	}

	/**
	 * @param $url
	 * @param $jsonData
	 * @return array|mixed
	 */
	function postValidationRequestToHUB($fields, $authorization) {

		$fields_string = null;
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $this->tovutiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		// curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization:' . $authorization,
			'Content-type:application/json',

		));

		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);

		return $result;

	}

}
