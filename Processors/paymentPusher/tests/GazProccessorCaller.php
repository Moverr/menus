	<?php
header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/**
 * 
 */
class GazProccessorCaller 
{
	private $username = "";
	private $password = "";
	
	
	function __construct(argument)
	{
		# code...
	}

	function payload() {
	$hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";

	$credentials = array(
		"username" => "gazpay",
		"password" => "abcd@12345",
	);

	$packet = array();

	$extraData = json_encode(array(
		"area" => "",
		"customerMobile" => "12",
		"merchantCode" => "233")
	);

	$packet = array(
		'serviceID' => 2114,
		'serviceCode' => "PAY077PAY077",
		'accountNumber' => 1234567,
		'requestExtraData' => null,
		'extraData' => null,
	);

	$data[] = $packet;
	$payload = array(
		"credentials" => $credentials,
		"packet" => $data,
	);

	$spayload = array(
		"function" => "BEEP.validateAccount",
		"payload" => json_encode($payload),
	);

	$respponse = postValidationRequestToHUB($hubJSONAPIUrl, json_encode($spayload));

	var_dump($respponse);

	print_r("<pre>" . json_encode($spayload));

}


function postValidationRequestToHUB($url, $fields, $authorization = null) {
	$fields_string = null;

	var_dump($authorization);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		"Content-type: application/json",
		"Authorization:" . $authorization,
	));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

	$response = curl_exec($curl);

	$curlErrorNumber = curl_errno($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	curl_close($curl);

	return $response;
}




$api_key = null;

function validateUser($data = null) {

	if ($data != null) {

		$url = "http://fcsexternalservice.azurewebsites.net/auth/login";

		$spayload = populateUserEntity($data);

		$respponse = postValidationRequestToHUB($url, json_encode($spayload), null);

		$responseArray = json_decode($respponse);

		//var_dump($responseArray);

		return ($responseArray);

	}
}






function validateCard($data = null, $api_key) {

	if ($data != null) {

		$url = "http://fcsexternalservice.azurewebsites.net/auth/customerAccount";

		$spayload = populateCardEntity($data);

		// var_dump($api_key);

		$respponse = postValidationRequestToHUB($url, json_encode($spayload), $api_key);

		$responseArray = json_decode($respponse);

		echo json_encode($responseArray);

		return ($respponse);

	}

}


function topUpCard($data = null, $api_key) {

	if ($data != null) {

		$url = "http://fcsexternalservice.azurewebsites.net/topup";

		$spayload = populateTopupEntity($data);

		// var_dump($api_key);

		$respponse = postValidationRequestToHUB($url, json_encode($spayload), $api_key);

		$responseArray = json_decode($respponse);

		echo json_encode($responseArray);

		return ($respponse);

	}

}

function populateUserEntity($data = null) {
	$userEntity = array();
	$userEntity['email'] = $data['email'];
	$userEntity['password'] = $data['password'];

	return $userEntity;
}

function populateTopupEntity($data = null) {
	$topupEntity = array();
	$topupEntity['cardmask'] = $data['cardmask'];
	$topupEntity['transactioncode'] = $data['transactioncode'];
	$topupEntity['amount'] = $data['amount'];

	return $topupEntity;
}

function populateCardEntity($data = null) {
	$userEntity = array();
	$userEntity['cardmask'] = $data['cardmask'];
	$userEntity['username'] = $data['username'];
	return $userEntity;
}

function processRecord($data = null) {

	if (($data['type']) == "validateAccount") {

		$userEntity = populateUserEntity($data);

		$cardEntity = populateCardEntity($data);

		$userResponse = validateUser($userEntity);

		$api_key = ($userResponse->apiKey);

		print_r($api_key);

		validateCard($cardEntity, $api_key);
		// echo json_encode($userEntity);
		// validateCard

	}

	if (($data['type']) == "topupaccount") {

		$userEntity = populateUserEntity($data);

		$topEntity = populateTopupEntity($data);

		$userResponse = validateUser($userEntity);

		$api_key = ($userResponse->apiKey);

		topUpCard($topEntity, $api_key);
		// echo json_encode($userEntity);
		// validateCard

	}

}




}

 




// processRecord($_POST);

?>