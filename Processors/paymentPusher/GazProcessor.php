  <?php

require_once __DIR__ . '/../../lib/integrationConfigs/GazConfigs.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';
require_once __DIR__ . '/../../lib/CoreUtils.php';
require_once __DIR__ . '/../../lib/Encryption.php';
include_once __DIR__ . '/../../lib/IXR_Library.php';

/* rodgers.muyinda@cellulant.com  */

class GazProcessor {

	private $log;
	private $authorization = GazConfigs::AUTHORIZATION;
	private $tovutiAPI = GazConfigs::MERCHANTURL . "/topup";

	public function __construct() {
		$this->log = new BeepLogger();

	}

	public function processRecord(PaymentHandler $data) {

		$this->log->info(Config::INFO, $data->beepTransactionID, $this->log->printArray($data));
		return $this->processTopup($data);
	}

	function processTopup($data) {

		$status['beepTransactionID'] = (int) $data->beepTransactionID;
		$status['payerTransactionID'] = $data->payerTransactionID;

		$payload = json_decode($data->paymentExtraData, true);
		$authorization = $this->authorization;
		$params = $this->populateEntity($payload);
		$response = $this->postData(json_encode($params), $authorization);
		$responsedata = json_decode($response);
		return $this->populateResponse($responsedata);

	}

	function populateResponse($responsedata) {

		$error_code = $response_data->error->error_code;

		if ($error_code == 200) {

			$message = $response_data->Message;
			$transactionRef = $response_data->TransactionalRef;

			$status['statusCode'] = Config::PUSH_STATUS_PAYMENT_ACCEPTED;
			$status['statusDescription'] = $message . " ! " . $transactionRef;

		} else {

			$error_message = $response_data->error->error_message;
			$status['statusCode'] = Config::PUSH_STATUS_PAYMENT_REJECTED;
			$status['statusDescription'] = $error_message;

		}

		return $status;
	}

	function populateEntity($payload) {
		$cardmask = $payload['cardmask'];
		$transactioncode = $status['beepTransactionID'];
		$amount = $payload['amount'];

		$params = array(
			"cardmask" => $cardmask,
			"transactioncode" => $transactioncode,
			"amount" => $amount,

		);
		return $params;
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
