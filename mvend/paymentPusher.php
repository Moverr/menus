  <?php

// LIVE INCLUDES

/*
require_once __DIR__ . '/../../lib/integrationConfigs/mvendConfig.php';
require_once __DIR__ . '/../../lib/Config.php';
require_once __DIR__ . '/../../lib/logger/BeepLogger.php';
require_once __DIR__ . '/../../lib/CoreUtils.php';
require_once __DIR__ . '/../../lib/Encryption.php';
include_once __DIR__ . '/../../lib/IXR_Library.php';
include_once __DIR__ . '/../../lib/mvendConfig.php';

 */

// TEST INCLUDES
require_once './lib/mvendConfig.php';
require_once './lib/Config.php';

require_once './lib/mvendConfig.php';
require_once './lib/BeepLogger.php';

/* rodgers.muyinda@cellulant.com  */
class paymentPusher {

	private $log;
	private $beepTransactionID;
	private $payerTransactionID;
	private $checkout_URL = "http://10.250.250.29:9001/hub/channels/api/momoCheckout/index.php";

	public function __construct() {
		// $this->log = new BeepLogger();
		// $this->log->info(Config::INFO, "", "Class initialized Successfully");
	}

	function attachBeepLogger($log) {
		$this->log = $log;
	}

	public function processRecord($data) {
		$this->log->info(Config::INFO, $data->beepTransactionID, $this->log->printArray($data));
		return $this->processPayment($data);
	}

	function processPayment($data) {
		$status['beepTransactionID'] = (int) $data->beepTransactionID;
		$status['payerTransactionID'] = $data->payerTransactionID;
		$params = $this->populateEntity($data);
		$response = $this->postData(json_encode($params));

		print_r($response);

		$status = $this->populateResponse($response, $status);

		return $status;

	}

	//formulate reponse
	function populateResponse($response, $status = null) {
		$responseData = json_decode($response);

		$status['statusDescription'] = (string) json_encode($response);

		$successCodes = explode(",", mvendConfig::SUCCESS_CODES);
		$error_codes = explode(",", mvendConfig::FAILURE_CODES);

		if (in_array("COMPLETED", $successCodes)) {
			$status['statusCode'] = Config::PUSH_STATUS_PAYMENT_ACCEPTED;
			$status['receipt'] = $responseData->receipt_no;

		} else if (in_array($responseData->status, $error_codes)) {
			$status['statusCode'] = Config::PUSH_STATUS_PAYMENT_REJECTED;
		} else {
			$status['statusCode'] = Config::PUSH_STATUS_PAYMENT_ESCALTE;
		}
		return $status;
	}

	//populate entity
	function populateEntity($data) {

		$accountNumber = $data->accountNumber;
		$transactioncode = (int) $data->beepTransactionID;
		$amount = $data->amount;

		$extrasJSON = $data->paymentExtraData == NULL ? "" : json_decode($data->paymentExtraData, true);

		$payload = array();
		$payload['requesttype'] = mvendConfig::REQUESTTYPE;

		$auth['userid'] = mvendConfig::USERID;
		$auth['password'] = mvendConfig::PASSWORD;

		$authenticationString[] = $auth;

		$payload['authentication'] = $authenticationString;

		$productid = isset($extrasJSON['productid']) ? $extrasJSON['productid'] : "";
		$duration = isset($extrasJSON['duration']) ? $extrasJSON['duration'] : "";
		$serviceprovider = isset($extrasJSON['serviceprovider']) ? $extrasJSON['serviceprovider'] : "";

		$params = array(
			"transactionid" => $transactioncode,
			"serviceprovider" => $serviceprovider,
			"accountnumber" => $accountNumber,
			"productid" => $productid,
			"duration" => $duration,
			"amount" => $amount,
		);
		$payload['parameters'] = $params;

		return $payload;
	}

	function postData($fields) {

		$fields_string = null;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, mvendConfig::URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type:application/json',

		));
		$result = curl_exec($ch);

		curl_close($ch);
		return $result;
	}

}
?>