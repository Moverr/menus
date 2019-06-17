
<?php

/**
 * @author egima
 *
 */
require_once __DIR__ . '/../../lib/integrationConfigs/ALTXConfigs.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';

class ALTXProcessor {

	private $log;
	private $request;
	private $curlErr = "";
	private $httpStatus = 0;

	/*
		     * Class constructor
	*/

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

		// $payload = json_decode($data->extraData, true);

		$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImdhelRvcFVwLm11bGFAY2VsbHVsYW50LmNvbSIsInBhc3N3b3JkIjoiJDJhJDEwJDJCM2IzY1luWG5yOVRkSlhWbUgwQU8ydXhSSkUvRFY3L0NuSTYzS3RycVNVZWNIQ1R1cEsyIiwidXNlcm5hbWUiOiJNdWxhX0NlbGx1bGFudCIsInJhbmRvbSI6Ik1VTEFfR0FaNDI4NjYxMTIzIiwiaWF0IjoxNTUzNzg0NTAxfQ.WBpkwbMWuRx5sgqjkmAuwgvaG1dFrduoY2bhdmi2EDw";

		// $payload['authorization'];
		$cardmask = "GOO1";
		//$payload['cardmask'];

		if ($cardmask == null || empty($cardmask) || $cardmask == '') {
			$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "Caard Mask  not found in payload");
			$this->curlErr = "Card number not provided";
			$resp = $this->formulateResponse(0);
			$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "Returning the following response: " . json_encode($resp));
			return $resp;
		}

		if ($authorization == null || empty($authorization) || $authorization == '') {
			$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "Authorization   not found in payload");
			$this->curlErr = "Authorization number not provided";
			$resp = $this->formulateResponse(0);
			$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "Returning the following response: " . json_encode($resp));
			return $resp;
		}

		$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "processRecord() | "
			. "Account validation request received for processing is :"
			. json_encode($data));
		//Do account look Up
		$response = $this->postValidationRequestToHUB("fcsexternalservice.azurewebsites.net/auth/customerAccount");

		$resp = $this->formulateResponse($response);
		$this->log->info(ALTXConfigs::INFO, $this->request->accountNumber, "Returning the following response: " . json_encode($resp));
		return $resp;
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
		curl_setopt($ch, CURLOPT_URL, $this->RemobiUrl);
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

	/**
	 * @param $statusCode
	 * @param $statusDesc
	 * @param null $result
	 * @return Response on about account status
	 */
	private function formulateResponse($result = null) {

		$record = json_decode($result);

		$response = array();
		$statusCode = $record->error->error_code;
		if ($statusCode == 200) {
			$response["statusCode"] = Config::GENERIC_SUCCESS;
			$response["statusDescription"] = "Card Number  recognized";
			$response["accountValid"] = "yes";
			$response["accountActive"] = "yes";
			$response["customerName"] = "";
			$response['extraData'] = (string) $result;
		} elseif ($statusCode == 404) {
			$response["statusCode"] = Config::GENERIC_SUCCESS;
			$response["statusDescription"] = "Card Number is not recognized";
			$response["accountValid"] = "no";
			$response["accountActive"] = "no";
			$response['extraData'] = '';
		} elseif ($statusCode == 400) {
			$response["statusCode"] = Config::GENERIC_FAILURE;
			$response["statusDescription"] = "Bad request"; //"Account number is Invalid";
			$response["accountValid"] = "no";
			$response["accountActive"] = "no";
			$response['extraData'] = "";
		} else {
			$response["statusCode"] = Config::GENERIC_FAILURE;
			$response["statusDescription"] = $this->curlErr;
			$response["accountValid"] = "no";
			$response["accountActive"] = "no";
			$response['extraData'] = "";
		}

		return $response;
	}

}
