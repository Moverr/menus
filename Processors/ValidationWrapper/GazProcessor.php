
<?php

/**
 * @author rodgers.muyinda@cellulant.com
 *
 */
/*
// live includes
require_once __DIR__ . '/../../lib/integrationConfigs/GazConfigs.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';
 */

// TEST INCLUDES
require_once '../../lib/GazConfigs.php';
require_once '../../lib/Config.php';
require_once '../../lib/BeepLogger.php';

class GazProcessor {

	private $log;
	private $request;
	private $authorization = GazConfigs::AUTHORIZATION;
	private $tovutiAPI = GazConfigs::MERCHANTURL . "/auth/customerAccount";

	public function __construct() {
		$this->log = new BeepLogger();
	}

	function attachBeepLogger($log) {
		$this->log = $log;
	}

	public function processRecord($data) {
		$this->request = $data;
		return $this->validateCardMask($data);
	}

	function validateCardMask($data) {

		$cardmask = $data->accountNumber;

		$params = array(
			"cardmask" => $cardmask,

		);
		$response = $this->postData(json_encode($params), $this->authorization);

		$result = $this->processResponse($response);

		return $result;

	}

	function processResponse($response) {
		$result = json_decode($response);

		if ((int) $result->error->error_code == 200) {
			$status['accountNumber'] = $result;
			$status['statusCode'] = Config::AUTHENTICATION_SUCCESS;
			$status['statusDescription'] = "Account has been validated successfully";
			$status['accountValid'] = "yes";
			$status['accountActive'] = "yes";
			$status['extraData'] = $result->Message;
			return $status;

		} else {

			$status['statusCode'] = Config::AUTHENTICATION_FAILED;
			$status['statusDescription'] = "Account has not veen verified";
			$status['accountValid'] = "no";
			$status['accountActive'] = "no";
			$status['extraData'] = (string) $response;
			return $status;

		}

	}

	function postData($fields, $authorization) {

		$fields_string = null;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->tovutiAPI);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization:' . $authorization,
			'Content-type:application/json',

		));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

}
