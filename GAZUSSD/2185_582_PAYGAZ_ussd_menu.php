            <?php

/*
 * GAZ USSD Collections
 *
 * @author Muyinda ROgers
 *
 */

include 'DynamicMenuController.php';
include './NCUGconfigs.php';

class GAZUSSD extends DynamicMenuController {

	private $MENU_STATUS = true;
	private $KEY_CUSTOMER_MOBILE_NUMBER = "customerMobileNumber";
	private $KEY_AMOUNT = "amount";
	private $MAX_AMOUNT = 4000000;
	private $MIN_AMOUNT = 500;
	private $STATUS_CODE = 2;
	private $MERCHANT_WHITELIST = array();
	private $SERVICE_DESCRIPTION = "NC BANK MENU ";
	private $walletUrl = 'http://132.147.160.57:8300/wallet/IS_APIs/CustomerRegistration/fetchCustomerData';
	private $serverURL = 'http://132.147.160.57:8300/wallet/Cloud_APIs/index';
	//    private $accessPoint = "*268#";
	private $accessPoint = "NIC_UG";
	//            "*268#";
	private $IMCREQUESTID = 1;
	private $SAMPLEMSSDN = '256783262929';
	private $USERNAME = "system-user";
	private $PASSWORD = "lipuka";
	//regex configs
	private $phone_reg = "/^(25677|25678|25639|25671|25670|25675|25679|77|78|39|71|70|75|79|077|078|039|071|070|075|079)[0-9]{7}$/";
	private $mtn_reg = "/^(77|78|39|25677|25678|25639|077|078|039)(\d{7})$/";
	private $airtel_reg = "/^(075|25675|75|25670|70|070)(\d{7})$/";
	private $warid_reg = "/^(25670|70|070)(\d{7})$/";
	private $utl_reg = "/^(71|071|25671)(\d{7})$/";
	private $orange_reg = "/^(079|25679|79)(\d{7})$/";

	private $hubJSONAPIUrl = "http://10.250.250.29:9000/hub/services/paymentGateway/JSON/index.php";
	private $hubValidationFunction = "BEEP.validateAccount";
	private $hubAuthSuccessCode = "131";
	private $hubValidationSuccessCode = "307";

	private $umemeServiceID = '28';
	private $umemeServiceCode = 'UMEME';
	private $nwscServiceID = '27';
	private $nwscServiceCode = 'NWSC';
	private $kccaServiceID = '233';
	private $kccaServiceCode = 'KCCA';
	private $uraServiceID = '30';
	private $uraServiceCode = 'URA';
	private $nwscAreas = "Kampala,Jinja,Entebbe,Lugazi,Iganga,Kawuku,Kajjansi,Mukono,Others";

	private $AUTHORIZATION = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImdhelRvcFVwLm11bGFAY2VsbHVsYW50LmNvbSIsInBhc3N3b3JkIjoiJDJhJDEwJDJCM2IzY1luWG5yOVRkSlhWbUgwQU8ydXhSSkUvRFY3L0NuSTYzS3RycVNVZWNIQ1R1cEsyIiwidXNlcm5hbWUiOiJNdWxhX0NlbGx1bGFudCIsInJhbmRvbSI6Ik1VTEFfR0FaNDI4NjYxMTIzIiwiaWF0IjoxNTUzNzg0NTAxfQ.WBpkwbMWuRx5sgqjkmAuwgvaG1dFrduoY2bhdmi2EDw";

	private $BEEPUSERNAME = "gazpay";
	private $BEEPPASSWORD = "abcd@12345";

	private $NARRATION = "GAZ PAYMENT";
	private $SERVICECODE = "PAY077PAY077";
	private $SERVICEID = 2114;
	private $CURRENCY = "KES";

	function startPage() {

		$message = "Select Option. \n1: Verify card   \n2: Topup card \n3: Card balance \n4: Card ministatement \n\n 0) Exit";

		$this->displayText = $message;
		$this->sessionState = "CONTINUE";
		$this->nextFunction = "menuSwiter";
		$this->previousPage = "startPage";

	}

	function menuSwiter($input) {
		switch ($input) {
		case '1':
			# code...
			$this->registerCard();

			break;
		case '2':
			$this->topUpCardMenu();
			break;
		case '3':
			$this->cardBalanceMenu();
			break;
		case '4':
			$this->cardMiniStatementMenu();
			break;

		default:
			$this->ehdMenu();
			break;
		}
	}

	function registerCard() {
		$this->displayText = "Coming Soon";
		$this->sessionState = "END";

	}
	function topUpCardMenu() {
		$this->displayText = "Enter Card Number";
		$this->sessionState = "CONTRINUE";
		$this->nextFunction = "getCardNumber";
		$this->previousPage = "topUpCardMenu";

	}

	function getCardNumber($input) {
		if ($input == "") {
			$this->displayText = "Invalid Input \nEnter Card Number";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "getCardNumber";
			$this->previousPage = "getCardNumber";
		} else {
			$this->saveSessionVar("CARDNUMBER", $input);
			$this->displayText = "Select payment option \n1) Mobile Money ";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "selectPaymentOption";
			$this->previousPage = "getCardNumber";

		}

	}

	function selectPaymentOption($input) {

		$this->saveSessionVar("PAYMENTOPTION", $input);

		switch ($input) {
		case '1':
			# code...
			$this->displayText = "Enter Mobile Number ";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "getMobileNumber";
			$this->previousPage = "selectPaymentOption";
			#
			break;

		default:
			$this->displayText = "Invalid Input \nSelect payment option \n1) Mobile Money";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "selectPaymentOption";
			$this->previousPage = "selectPaymentOption";
			break;
		}

	}

	function getMobileNumber($input) {

		if ($input == "") {
			$this->displayText = "Invalid Input \n Enter Mobile Number ";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "getMobileNumber";
			$this->previousPage = "getMobileNumber";
		} else {
			$this->saveSessionVar("MOBILENUMBER", "256" . (int) $input);
			$this->displayText = "Enter TopUp Amount ";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "getAmount";
			$this->previousPage = "getMobileNumber";

		}

	}

	function getAmount($input) {
		if ($input == "") {
			$this->displayText = "Invalid Input \nEnter TopUp Amount";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "getAmount";
			$this->previousPage = "getAmount";
		} else {
			$this->saveSessionVar("CARDAMOUNT", (float) $input);
			$CARDNUMBER = $this->getSessionVar("CARDNUMBER");
			$CARDAMOUNT = $this->getSessionVar("CARDAMOUNT");
			$MOBILENUMBER = $this->getSessionVar("MOBILENUMBER");

			$this->displayText = "You are paying Toping Up  : " . $CARDAMOUNT . " UGX Shillings  on card number :" . $CARDNUMBER . " from " . $MOBILENUMBER . " \n 1)Confirm Payment ";
			$this->sessionState = "CONTRINUE";
			$this->nextFunction = "finalizePayment";
			$this->previousPage = "getAmount";
		}

	}

	function finalizePayment($input) {

		$transaction_id = rand();
		$CARDNUMBER = $this->getSessionVar("CARDNUMBER");
		$CARDAMOUNT = $this->getSessionVar("CARDAMOUNT");
		$MOBILENUMBER = $this->getSessionVar("MOBILENUMBER");

		$credentials = array(
			"username" => $this->BEEPUSERNAME,
			"password" => $this->BEEPPASSWORD,
		);

		$packet = array();

		$extraData = json_encode(array(

			"authorization" => $this->AUTHORIZATION,
			"cardmask" => $CARDNUMBER,
			"transactioncode" => $transaction_id,
			"amount" => $CARDAMOUNT,

		)

		);

		$packet = array(

			'serviceID' => $this->SERVICEID,
			// 'serviceCode' => $this->$SERVICECODE,

			'requestExtraData' => null,
			'extraData' => $extraData,
			"payerTransactionID" => $transaction_id,
			"invoiceNumber" => $transaction_id,
			"MSISDN" => $MOBILENUMBER,
			"amount" => $CARDAMOUNT,
			"accountNumber" => $CARDNUMBER,
			"narration" => "GAZ TOPUP",
			"currencyCode" => "KES",
			"customerNames" => "--",
			"paymentMode" => "MOBILE MONEY",
			"datePaymentReceived" => date("Y-m-d H:i:s"),
		);

		$data[] = $packet;
		$payload = array(
			"credentials" => $credentials,
			"packet" => $data,
		);

		$spayload = array(
			// "function"=>"BEEP.validateAccount",
			"function" => "BEEP.postPayment",
			"payload" => json_encode($payload),
		);

		$response = $this->postToCPGPayload($payload, $this->hubJSONAPIUrl, "BEEP.postPayment");

		$responsedata = json_decode($response);

		$this->displayText = ":::" . (string) $responsedata->results[0]->statusDescription;
		$this->sessionState = "END";

	}

	function cardBalanceMenu() {
		$this->displayText = "COMING SOON";
		$this->sessionState = "END";
	}
	function cardMiniStatementMenu() {
		$this->displayText = "COMING SOON";
		$this->sessionState = "END";
	}

	function ehdMenu() {
		$this->displayText = "Thank you for using Gaz";
		$this->sessionState = "END";
	}

	function postToCPGPayload($params, $url, $method) {
		$payload = array('function' => $method, 'payload' => json_encode($params));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

		$output = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $output;
	}

}

$ncBankUSSD = new GAZUSSD();
echo $ncBankUSSD->navigate();
