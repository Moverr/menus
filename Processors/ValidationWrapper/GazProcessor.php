
<?php

/**
 * @author rodgers.muyinda@cellulant.com
 *
 */
require_once __DIR__ . '/../../lib/integrationConfigs/GazConfigs.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';

class GazProcessor {

	private $log;
	private $request;
	private $authorization = GazConfigs::AUTHORIZATION;
	private $tovutiUrl = GazConfigs::MERCHANTURL . "/auth/customerAccount";

	public function __construct() {
		$this->log = new BeepLogger();
	}

	public function processRecord(ValidationHandler $data) {
		$this->request = $data;
		$response = $this->validateCardMask();
		return $this->processResponse($response);
	}

	function validateCardMask() {
		$cardmask = $this->request->accountNumber;
		$params = array(
			"cardmask" => $cardmask,

		);
		$response = $this->postData(json_encode($params), $this->authorization);
		return $response;
	}

	function processResponse($response) {
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

	function postData($fields, $authorization) {

		$fields_string = null;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->tovutiUrl);
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
