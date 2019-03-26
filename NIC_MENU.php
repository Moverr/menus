<?php

/*
 * MTN UG Mula USSD Menu Payments
 *
 * @author jennifer
 *
 */
error_reporting(0);
include 'DynamicMenuController.php';
include './DTBUGconfigs.php';

class NCBANKUSSD extends DynamicMenuController {

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
    //validation configs
    private $hubJSONAPIUrl = "http://localhost:9001/hub/services/paymentGateway/JSON/index.php";
    private $hubValidationFunction = "BEEP.validateAccount";
    private $hubAuthSuccessCode = "131";
    private $hubValidationSuccessCode = "307";
    private $beepUsername = "nic_test_api_user";
    private $beepPassword = "nic_t3st_api_us3r";

    function startPage() {
        $this->firstMenu();
        // $this->validateCustomerPin('22222');
//        $this->checkPin();
//        $this->paySelfTest();
    }

    function paySelfTest() {
        /*
          $receipient = 256779820962;
          $sid = 14;
          $encryptedpin = $this->encryptPin(1234,1);
          $accountID = 1985;
          $accountAlias = 'teddy';
          $amount = 10;
         */
        $encryptedpin = $this->encryptPin(1234, 1);
        /*
          $fields = array(
          "serviceID" => $sid,
          "flavour" => "self",
          "pin" => $encryptedpin,
          "accountAlias" => $accountAlias,
          "amount" => $amount,
          "accountID" => $accountID,
          "columnA" => $receipient
          );
         */
        $fields = [
            "MSISDN" => '256783262929',
            "USERNAME" => "system-user",
            "PASSWORD" => "lipuka",
            "PIN" => 1234
        ];
//authenticateCustomerPin
        $url = $this->serverURL;
        $request = xmlrpc_encode_request('validatePIN', $fields);
        $results = $this->http_post($url, $fields, $request);
        $message .= " --- " . print_r(xmlrpc_decode($results), TRUE);
//                (var_dump($server_output));
        $this->displayText = $message;
    }

    function init() {
        $fields_string = null;
        $fields = null;
        $fields = array(
            "MSISDN" => $this->_msisdn,
            "USERNAME" => $this->USERNAME,
            "PASSWORD" => $this->PASSWORD
        );
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $response = $this->http_post($this->walletUrl, $fields, $fields_string);
        $clientProfile = json_decode($response, true);
        $this->saveSessionVar("CLIENTPROFILE", $clientProfile);
//        $this->firstMenu();
    }

    function firstMenu() {
        if (null !== $this->getSessionVar('CLIENTPROFILE')) {
            $this->init();
        }
        $clientProfile = $this->getSessionVar('CLIENTPROFILE');

        if ($clientProfile['SUCCESS'] != 1) {
            $error = $clientProfile['ERRORS'];
            $this->displayText = $error;
            $this->sessionState = "END";
            $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        } else {
            $clientProfiledata = $this->populateClientProfile($clientProfile);
            $clientAccountDetails = $this->populateAccountDetails($clientProfile);
            $authenticatedPIN = $this->getSessionVar('AUTHENTICATEDPIN');
            if ($authenticatedPIN != null) {
                if ($authenticatedPIN['STATUSCODE'] == 1) {
                    $message = "Hello " . ($clientProfiledata['customerNames']) . "\n1. Merchants \n" . "2. Balance Enquiry \n" .
                            "3. Bill Payment \n" . "4. Funds Transfer \n" . "5. Bank to Mobile \n" . "6. Airtime Purchase \n" .
                            "7. Mini statement \n" . "8. Cheque Requests \n" . "9. Change PIN";

                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "menuSwitcher";
                    $this->previousPage = "startPage";
                } else {
                    //todo validate pin :
                    $message = "Enter Your mobile banking Pin";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "validatePinMenu";
                    $this->previousPage = "startPage";
                }
            } else {
                //todo validate pin :
                $message = "Enter Your mobile banking Pin";
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "validatePinMenu";
                $this->previousPage = "startPage";
            }
        }
    }

    // VALIDATE PIN MENU
    function validatePinMenu($input) {
        $clientProfile = $this->getSessionVar('CLIENTPROFILE');

        $response = $this->validateCustomerPin($input);
        $this->logMessage("Result from validateCustomerPin function=> ", $response, 4);
        if ($response['STATUSCODE'] == 100) {
            $message = "Hello " . $this->getSessionVar('customerNames') . ",\n Incorrect Pin entered. Please enter correct PIN";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validatePinMenu";
            $this->previousPage = "startPage";
        } else if ($response['STATUSCODE'] == 1) {
            $message = "Hello " . $this->getSessionVar('customerNames') . ",\n1. Merchants \n" . "2. Balance Enquiry \n" .
                    "3. Bill Payment \n" . "4. Funds Transfer \n" . "5. Bank to Mobile \n" . "6. Airtime Purchase \n" .
                    "\n7. Mini statement \n" . "\n8. Cheque Requests \n" . "\n9. Change PIN";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = $this->SERVICE_DESCRIPTION;
            $this->nextFunction = "menuSwitcher";
            $this->previousPage = "startPage";
        } else {
            $message = "Hello Client, \nSomething went wrong, kindly contact customer care";
            $this->displayText = $message;
            $this->sessionState = "END";
        }
    }

    function validateCustomerPin($pin) {
        $this->logMessage("Validating PIN " . $pin, null, 4);
//        "MSISDN" => $this->_msisdn,
        $payload = array(
            "MSISDN" => $this->_msisdn,
            "USERNAME" => $this->USERNAME,
            "PASSWORD" => $this->PASSWORD,
            "PINHASH" => $this->encryptPin($pin, $this->IMCREQUESTID)
        );
        $pinrequest = [
            "pinRequest" => $payload
        ];
        //todo: missing information

        $this->logMessage("URL Used:: " . $this->serverURL, null, 4);
        $validationResponse = $this->invokeWallet("authenticateCustomerPin", $pinrequest);
        $this->logMessage("Validate PIN wallet Response:: ", $validationResponse, 4);

        $response = $this->populatePinResponse($validationResponse, $pin);
        $this->saveSessionVar("AUTHENTICATEDPIN", $response);
        return $response;
    }

    function populatePinResponse($record, $rawpin) {
        $response = json_decode($record, true);
        $profileID = isset($response['DATA']['profileID']) ? $response['DATA']['profileID'] : null;
        $pinHash = isset($response['DATA']['pinHash']) ? $response['DATA']['pinHash'] : null;
        $responseData = [
            "PROFILEID" => $profileID,
            "PINHASH" => $pinHash,
            "RAWPIN" => $rawpin,
            "STATUSCODE" => $response["STAT_CODE"],
            "STATTYPE" => $response["STAT_TYPE"],
            "STATDESCRIPTION" => $response["STAT_DESCRIPTION"]
        ];

        return $responseData;
    }

    function menuSwitcher($input) {

        if (is_numeric($input)) {
            switch ('' . $input) {
                case '1':
# code...
                    $this->MerchantsMenu();
                    break;
                case '2':
# code...
                    $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
                    $message = "\n\nChoose Account\n";
                    $index = 0;
                    foreach ($ACCOUNTS as $account) {
                        $index = $index + 1;
                        $message .= $index . ") " . $account['ACCOUNTNUMBER'] . "\n";
                    }
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "BalanceEnquiryMenu";
                    $this->previousPage = "startPage";
                    break;
                case '3':
                    $service = $this->getSessionVar('selectedService');
                    $this->previousPage = "startPage";
                    $this->processPayBill($input);
                    break;

                case '4':
# code...
                    $this->FundsTransferMenu();
                    break;
                case '5':
# code...
                    $this->BankToMobileMenu();
                    break;
                case '6':
                    $message = " Top Up"
                            . "\n1) Own Phone"
                            . "\n2) Other Phone";
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "AirtimePurchaseMenu";
                    $this->previousPage = "startPage";
                    break;
                case '7':
                    $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
                    $message = "Choose Account ";
                    $count = 0;
                    foreach ($ACCOUNTS as $account) {
                        $count = $count + 1;
                        $message .= "\n" . $count . ")" . $account['ACCOUNTNUMBER'];
                    }
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "MiniStatementMenu";
                    $this->previousPage = "startPage";
                    break;
                case '8':
# code...
                    $message = "Account Request"
                            . "\n1) Cheque Book Request"
                            . "\n2) Stop Cheque ";
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "ChequeRequestMenu";
                    $this->previousPage = "startPage";
                    break;
                case '9':
# code...
                    $this->ChangePinMenu();
                    break;
                case '0':
# code...
                    break;
                case '00':
# code...
                    break;
                case '000':
# code...
                    break;
                default:
# code...
                    $this->displayText = "Invalid input. Please enter a menu number ";
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "menuSwitcher";
                    $this->previousPage = "menuSwitcher";
                    break;
            }
        } else {
            $this->displayText = "Invalid input. Please enter a menu number ";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "validateMobileNumber";
            $this->previousPage = "validateMobileNumber";
        }
    }

    function checkPin() {
//        xmlrpc_server_call_method ( resource $server , string $xml , mixed $user_data [, array $output_options ] )
        $fields_string = null;
        $fields = null;
// "MSISDN" => $this->_msisdn,
        $fields = array(
            "MSISDN" => '256783262929',
            "PIN" => '1234',
            "USERNAME" => "system-user",
            "PASSWORD" => "lipuka"
        );
//        foreach ($fields as $key => $value) {
//            $fields_string .= $key . '=' . $value . '&';
//        }
//        rtrim($fields_string, '&');
        $message = "MOMO";
        $url = $this->serverURL;
        $request = xmlrpc_encode_request('fetchCustomerData', $fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $results = curl_exec($ch);
        curl_close($ch);
        $message .= " --- " . print_r(xmlrpc_decode($results), TRUE);
//                (var_dump($server_output));
        $this->displayText = $message;
    }

    function ServiceNotAvailable() {
        $message = "Service not available \n\n" . "0. Home \n" . "00. Back ";
        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "menuSwitcher";
        $this->previousPage = "startPage";
    }

    function MerchantsMenu() {
        $this->serviceNotAvailable();
    }

    function generalMenu($input) {
        if ($input == '0') {
            $this->displayText = "Thank you for supporting NC BANK";
            $this->sessionState = "END";
        } else if ($input == '0') {
            $this->displayText = "Thank you for supporting NC BANK";
            $this->sessionState = "END";
        } else if ($input == '0') {
            $this->displayText = "Thank you for supporting NC BANK";
            $this->sessionState = "END";
        } else if ($input == '0') {
            $this->displayText = "Thank you for supporting NC BANK";
            $this->sessionState = "END";
        }
    }

// 2:BALANCE ENQUIRY
    function BalanceEnquiryMenu($input) {
        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        switch ($input) {
            case '0':
                $this->firstMenu();
                break;
            case '00':
                $this->firstMenu();
                break;
            case '000':
                $this->firstMenu();
                break;
            default:
                $selectedAccount = null;
                foreach ($ACCOUNTS as $account) {
                    if ($account['ID'] == $input) {
                        $selectedAccount = $account;
                        break;
                    }
                }
                if ($selectedAccount == null) {

                    $message = "Invalid Input \n\nChoose Account\n";
                    $index = 0;
                    foreach ($ACCOUNTS as $account) {
                        $index = $index + 1;
                        $message .= $index . ") " . $account['ACCOUNTNUMBER'] . "\n";
                    }
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "BalanceEnquiryMenu";
                    $this->previousPage = "BalanceEnquiryMenu";
                } else {
                    $PINRECORD = $this->getSessionVar('AUTHENTICATEDPIN');
//                  $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);
                    $requestPayload = array(
                        "serviceID" => 10,
                        "flavour" => 'self',
                        "pin" => $this->encryptPin($PINRECORD['RAWPIN'], 1),
                        //$this->encryptPin($PINRECORD['RAWPIN'],$this->IMCREQUESTID), //$this->encryptPin($PINRECORD['RAWPIN'],1)
                        "accountAlias" => $selectedAccount['ACCOUNTNAME'],
                        "accountID" => $selectedAccount['ACCOUNTCBSID'],
                    );
                    $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);

                    $result = $this->invokeSyncWallet($requestPayload, $logRequest['DATA']['LAST_INSERT_ID']);
                    $response = json_decode($result);
//                $this->displayText = "" . print_r($result, true); 
                    $this->logMessage("Balance Enquiry Response:: ", $response, 4);
                    $this->displayText = "" . ($response->DATA->MESSAGE);
                    $this->sessionState = "END";
                }
                break;
        }
    }

    function BillPaymentsMenu() {
        $this->serviceNotAvailable();
    }

    function FundsTransferMenu() {
        $this->serviceNotAvailable();
    }

    function BankToMobileMenu() {
        $this->serviceNotAvailable();
    }

    //: MENU ITEM 6 AIRTIME PURCHASE
    function TopUpAmountMenu($input) {
        if (!is_numeric($input)) {
            $message = "Invalid Number Entered. Please enter number again";
            $message .= "\n\n0. Home \n" . "00. Back";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = $this->SERVICE_DESCRIPTION;
            $this->nextFunction = "TopUpAmountMenu";
            $this->previousPage = "TopUpAmountMenu";
        }

        $this->saveSessionVar("AirtimeRecipient", $input);
        $message = "Enter Top Up Amount";
        $message .= "\n0. Home \n" . "00. Back";

        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "AirtimeMerchantChooseAccount";
        $this->previousPage = "AirtimePurchaseMenu";
    }

    function finishBuyingAirtime($input) {
        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        $recipientNumber = $this->getSessionVar("AirtimeRecipient");
        $amount = $this->getSessionVar("airtimeAmount");
        $selectedAccount = null;
        foreach ($ACCOUNTS as $account) {
            if ($account['ID'] == $input) {
                $selectedAccount = $account;
                break;
            }
        }
        $this->saveSessionVar("selectedSourceAccount", $selectedAccount);
        $PINRECORD = $this->getSessionVar('AUTHENTICATEDPIN');

        //dynamically get a recipient network ID
        $networkID = $this->getRecipientNetworkID($recipientNumber);

        $requestPayload = array(
            "serviceID" => "BILL_PAY",
            "flavour" => 'open',
            "pin" => $this->encryptPin($PINRECORD['RAWPIN'], $this->IMCREQUESTID),
            "columnC" => $recipientNumber,
            "accountAlias" => $selectedAccount['ACCOUNTNAME'],
            "accountID" => $selectedAccount['ACCOUNTCBSID'],
            "amount" => $amount,
            "merchantCode" => $this->getAirtimeWalletMerchantCodes($recipientNumber),
            "columnC" => $this->getAirtimeWalletMerchantCodes($recipientNumber),
            "enroll" => "No",
            "CBSID" => 1,
            "columnD" => "NULL",
            "columnA" => $recipientNumber,
        );
        $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);

        $result = $this->invokeSyncWallet($requestPayload, $logRequest['DATA']['LAST_INSERT_ID']);
        $response = json_decode($result);
//                $this->displayText = "" . print_r($result, true); 
        $this->logMessage("Airtime Purchase feedback:: ", $response, 4);
        $this->displayText = $response->DATA->MESSAGE;
        $this->sessionState = "END";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
    }

    function AirtimeMerchantChooseAccount($input) {

        $this->saveSessionVar("airtimeAmount", $input);

        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        $message = "Select Account \n";
        if ($ACCOUNTS != null) {
            $message = "Choose Account \n";
            $count = 0;
            foreach ($ACCOUNTS as $account) {
                $count = $count + 1;
                $selectedAccount = $account;
                $message .= $count . ")" . $selectedAccount['ACCOUNTNUMBER'] . "\n";
            }
        }
        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "finishBuyingAirtime";
        $this->previousPage = "AirtimeMerchantChooseAccount";
    }

    function AirtimePurchaseMenu($input) {
        switch ($input) {
            case '1':
                $message = "Enter Top Up Amount";
                $message .= "\n0. Home \n" . "00. Back";

                $this->saveSessionVar("AirtimeRecipient", $this->_msisdn);
                //get the network id
                $networkID = $this->getProvider($this->_networkID);

                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "AirtimeMerchantChooseAccount";
                $this->previousPage = "AirtimePurchaseMenu";
                break;
            case '2':
//                $this->TopUpAmountMenu($input);
                $message = "Enter Other number to send Airtime";
                $message .= "\n0. Home \n" . "00. Back \n";
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "TopUpAmountMenu";
                $this->previousPage = "AirtimePurchaseMenu";
                break;
            case '0':
                $this->firstMenu();
                break;
            case '00':
                $this->firstMenu();
                break;
            case '000':
                $this->firstMenu();
                break;
            default:
                $message = "Invalid Selection\n Top Up"
                        . "\n.1 Own Phone"
                        . "\n.2 Other Phone";
                $message .= "\n\n0. Home \n" . "00. Back";
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "AirtimePurchaseMenu";
                $this->previousPage = "startPage";
                break;
        }
    }

    //: MENU ITEM 7 MINI STATEMENT
    function MiniStatementMenu($input) {
        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        switch ($input) {
            case '0':
                $this->firstMenu();
                break;
            case '00':
                $this->firstMenu();
                break;
            case '000':
                $this->firstMenu();
                break;
            default:
                $selectedAccount = null;
                foreach ($ACCOUNTS as $account) {
                    if ($account['ID'] == $input) {
                        $selectedAccount = $account;
                        break;
                    }
                }
                if ($selectedAccount == null) {

                    $message = "Invalid Input \n\nChoose Account\n";
                    $index = 0;
                    foreach ($ACCOUNTS as $account) {
                        $index = $index + 1;
                        $message .= $index . ") " . $account['ACCOUNTNUMBER'] . "\n";
                    }
                    $message .= "\n\n0. Home \n" . "00. Back";
                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "MiniStatementMenu";
                    $this->previousPage = "MiniStatementMenu";
                } else {
                    $PINRECORD = $this->getSessionVar('AUTHENTICATEDPIN');
//                  $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);
                    $requestPayload = array(
                        "serviceID" => 11,
                        "flavour" => 'self',
                        "pin" => $this->encryptPin($PINRECORD['RAWPIN'], 1),
                        //$this->encryptPin($PINRECORD['RAWPIN'],$this->IMCREQUESTID), //$this->encryptPin($PINRECORD['RAWPIN'],1)
                        "accountAlias" => $selectedAccount['ACCOUNTNAME'],
                        "accountID" => $selectedAccount['ACCOUNTCBSID'],
                    );
                    $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);

                    $result = $this->invokeSyncWallet($requestPayload, $logRequest['DATA']['LAST_INSERT_ID']);

                    $response = json_decode($result);
                    $this->logMessage("Balance Enquiry Response:: ", $response, 4);
                    $this->displayText = "" . substr(($response->DATA->MESSAGE),155)."...";

                    $this->sessionState = "END";
                }

                break;
        }
    }

    //todo:  CHEQUE REQUESTS MENU
    function ChequeRequestMenu($input) {
        switch ($input) {
            case "1":
                $leaves = [50, 100];
                $message = "Select number of leaves";
                $count = 0;
                foreach ($leaves as $leaf) {
                    $count = $count + 1;
                    $message .= "\n" . $count . ") " . $leaf;
                }
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "RequestCheckbook";
                $this->previousPage = "startPage";
                break;
            case "2":
                $message = "Enter cheque number";
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "StopChequeMenu";
                $this->previousPage = "startPage";
                break;
            default:
                break;
        }
    }

    function RequestCheckbook($input) {

        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        switch ($input) {
            case '0':
                $this->firstMenu();
                break;
            case '00':
                $this->firstMenu();
                break;
            case '000':
                $this->firstMenu();
                break;
            default:
                $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
                $message = "Select Account"
                        . "\n";
                if ($ACCOUNTS != null) {
                    $message = "Choose Account \n";
                    $count = 0;
                    foreach ($ACCOUNTS as $account) {
                        $count = $count + 1;
                        $selectedAccount = $account;
                        $message .= $count . ")" . $selectedAccount['ACCOUNTNUMBER'] . "\n";
                    }
                }
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "finalizeCheckBookRequest";
                $this->previousPage = "RequestCheckbook";



                break;
        }
    }

    function finalizeCheckBookRequest($input) {
        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');


        if (!is_numeric($input)) {
            $this->displayText = "Invalid Input, Enter correct option ";
            $message .= "\n\n0. Home \n" . "00. Back ";
            $this->nextFunction = "finalizeCheckBookRequest";
            $this->previousPage = "finalizeCheckBookRequest";
        } else {
            $selectedAccount = null;
            foreach ($ACCOUNTS as $account) {
                if ($account['ID'] == $input) {
                    $selectedAccount = $account;
                    break;
                }
            }
            if ($selectedAccount == null) {
                $this->displayText = "Invalid Input, Enter correct option ";
                $message .= "\n\n0. Home \n" . "00. Back";
                $this->nextFunction = "finalizeCheckBookRequest";
                $this->previousPage = "finalizeCheckBookRequest";
            } else {

                $PINRECORD = $this->getSessionVar('AUTHENTICATEDPIN');

                $requestPayload = array(
                    "serviceID" => 15,
                    "flavour" => 'noFlavour',
                    "pin" => $this->encryptPin($PINRECORD['RAWPIN'], 1),
                    //$this->encryptPin($PINRECORD['RAWPIN'],$this->IMCREQUESTID), //$this->encryptPin($PINRECORD['RAWPIN'],1)
                    "accountAlias" => $selectedAccount['ACCOUNTNAME'],
                    "accountID" => $selectedAccount['ACCOUNTCBSID'],
                    "columnA" => 50,
                );
                $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);
                $result = $this->invokeSyncWallet($requestPayload, $logRequest['DATA']['LAST_INSERT_ID']);
                $response = json_decode($result);
//                $this->displayText = "" . print_r($result, true); 
                $this->logMessage("Balance Enquiry Response:: ", $response, 4);
                $this->displayText = "" . ($response->DATA->MESSAGE);
                $this->sessionState = "END";
            }
        }
    }

    //TODO:  TO CHEQUE NUMBER MENU \
    function ToChequeNumber($input) {
        $message = "To cheque number";
        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "StopChequeMenu";
        $this->previousPage = "startPage";
    }

    //TODO: STOP CHEQUE MENU
    function StopChequeMenu($input) {

        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
        switch ($input) {
            case '0':
                $this->firstMenu();
                break;
            case '00':
                $this->firstMenu();
                break;
            case '000':
                $this->firstMenu();
                break;
            default:

                $message = "Select Account"
                        . "\n";
                if ($ACCOUNTS != null) {
                    $message = "Choose Account \n";
                    $count = 0;
                    foreach ($ACCOUNTS as $account) {
                        $count = $count + 1;
                        $selectedAccount = $account;
                        $message .= $count . ")" . $selectedAccount['ACCOUNTNUMBER'] . "\n";
                    }
                }
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "finishCheckbookCancellation";
                $this->previousPage = "StopChequeMenu";
                break;
        }
    }

    function finishCheckbookCancellation($input) {

        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');


        $selectedAccount = null;
        foreach ($ACCOUNTS as $account) {
            if ($account['ID'] == $input) {
                $selectedAccount = $account;
                break;
            }
        }

        $PINRECORD = $this->getSessionVar('AUTHENTICATEDPIN');
        $requestPayload = array(
            "serviceID" => 16,
            "flavour" => 'noFlavour',
            "pin" => $this->encryptPin($PINRECORD['RAWPIN'], 1),
            //$this->encryptPin($PINRECORD['RAWPIN'],$this->IMCREQUESTID), //$this->encryptPin($PINRECORD['RAWPIN'],1)
            "accountAlias" => $selectedAccount['ACCOUNTNAME'],
            "accountID" => $selectedAccount['ACCOUNTCBSID'],
            "columnA" => 12345,
        );
        $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);

        $result = $this->invokeSyncWallet($requestPayload, $logRequest['DATA']['LAST_INSERT_ID']);
//        $response = json_decode($result);
//        $this->logMessage("Balance Enquiry Response:: ", print_r($response, true), 4);
//        if ($response->STATUS_CODE == 1) {
        $this->displayText = "" . print_r($result->STAT_DESCRIPTION, true);
//        }


        $this->sessionState = "END";
    }

    function ChangePinMenu() {
        $this->serviceNotAvailable();
    }

    function PromptPin() {
        $message .= "Enter Pin to confirm \n0. Home \n" . "00. Back ";
        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "menuSwitcher";
        $this->previousPage = "startPage";
    }

    function SignOutMenu() {
        
    }

    ////////////Process Pay Bill and Pay TVs
    function processPayBill($input) {

        if ($this->previousPage == "startPage") {
            $this->displayText = "Select Utility. \n1: UMEME \n2: NWSC \n3: Pay TV";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processPayBill";
            $this->previousPage = "utilitySelected";
        } else if ($this->previousPage == "utilitySelected") {
            switch ($input) {
                case 1:
                    $this->processUmeme($input);
                    break;

                case 2:
                    $this->processNwsc($input);
                    break;

                case 3:
                    $this->processPayTV($input);
                    break;

                default:
                    $this->displayText = "Select Utility. \n1: UMEME \n2: NWSC \n3: Pay TV";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processPayBill";
                    $this->previousPage = "utilitySelected";
                    break;
            }
        }
    }

    function processPayTV($input) {

        if ($this->previousPage == "utilitySelected") {
            $this->displayText = "Select TV Merchant. \n1: GoTV \n2: DSTV \n3: Startimes \n4: Azam"
                    . "\n5: Zuku TV \n6: Kwese TV";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processPayTV";
            $this->previousPage = "payTVSelected";
        } else if ($this->previousPage == "payTVSelected") {
            switch ($input) {
                case 1:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::GOTV_CODE);
                    $this->processMultiChoiceTV($input);
                    break;

                case 2:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::DSTVUG_CODE);
                    $this->processMultiChoiceTV($input);
                    break;

                case 3:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::STARTIMES_CODE);
                    $this->processStarTimes($input);
                    break;

                case 4:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::AZAM_CODE);
                    $this->processAzamTV($input);
                    break;

                case 5:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::ZUKU_CODE);
                    $this->processZukuTV($input);
                    break;

                case 6:
                    $this->saveSessionVar("menuOptionSelected", DTBUGconfigs::KWESE_CODE);
                    $this->processKweseTV($input);
                    break;

                default:
                    $this->displayText = "Select TV Merchant. \n1: GoTV \n2: DSTV \n3: Startimes \n4: Azam"
                            . "\n5: Zuku TV \n6: Kwese TV";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processPayTV";
                    $this->previousPage = "payTVSelected";
                    break;
            }
        }
    }

    //PayTV functions
    function processStarTimes($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        $selectedMenuService = $this->getSessionVar("menuOptionSelected");

        if ($this->previousPage == "payTVSelected") {
            $this->displayText = "Enter Your Startimes Account Number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processStarTimes";
            $this->previousPage = "enterAccNumber";
        } elseif ($this->previousPage == "enterAccNumber") {

            $this->saveSessionVar("startimesAccountNumber", $input);

            $packageText = "Select package \n";
            $starttimesPackages = explode(",", DTBUGconfigs::STARTIMES_PACKAGES);

            for ($i = 0; $i < sizeof($starttimesPackages); $i++) {
                $packageText .= $i + 1 . ". " . $this->getPackageName($starttimesPackages[$i]) . " - " . $this->getPackagePrice($starttimesPackages[$i]) . "\n";
            }

            $this->displayText = $packageText;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processStarTimes";
            $this->previousPage = "selectPackage";
        } elseif ($this->previousPage == "selectPackage") {

            $starttimesPackages = explode(",", DTBUGconfigs::AZAM_PACKAGES);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($starttimesPackages) || $input < 1) {
#prompt user to enter select package again
                $this->previousPage = "enterAccNumber";
                $this->processStarTimes($this->getSessionVar("startimesAccountNumber"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedPackage = trim($this->getPackageName($starttimesPackages[$selectedIndex]));
                $selectedPackagePrice = trim($this->getPackagePrice($starttimesPackages[$selectedIndex]));
                $this->saveSessionVar("selectedPackage", $selectedPackage);
                $this->saveSessionVar("selectedPackagePrice", $selectedPackagePrice);
                $accountNumber = $this->getSessionVar("startimesAccountNumber");

                $accountDetails = $this->validatePayTVAccount(DTBUGconfigs::STARTIMES_CODE, DTBUGconfigs::STARTIMES_SERVICE_ID, DTBUGconfigs::STARTIMES_SERVICE_CODE, $accountNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid Startimes Account Number. Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processStarTimes";
                    $this->previousPage = "enterAccNumber";
                } else {
                    $customerName = $accountDetails['customerName'];

                    $this->saveSessionVar("startimesCustomerName", $customerName);

                    $this->displayText = "Name: {$customerName}, Account No: " . $accountNumber . " Package selected: " . $selectedPackage . " Amount: " . number_format($selectedPackagePrice) . ". Enter Amount to pay";

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processStarTimes";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("startimesAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("startimesAmount", $amount);
            }

            $message = "You are paying " . DTBUGconfigs::STARTIMES_CODE . "UGX. " . $this->getSessionVar("startimesAmount");
            $message .= ". Account name: " . $this->getSessionVar("startimesCustomerName") . ". ";
            $message .= "Account " . $this->getSessionVar("startimesAccountNumber");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processStarTimes";
            $this->previousPage = "confirmPayment";
        } elseif ($this->previousPage == "confirmPayment") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', DTBUGconfigs::BILLPAY_SERVICE);

                    $this->saveSessionVar('amount', $this->getSessionVar("startimesAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("startimesAmount"));
                    $this->saveSessionVar('merchantCode', DTBUGconfigs::STARTIMES_WALLET_MERCHANT_CODE);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("startimesAccountNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('package', $this->getSessionVar("selectedPackage"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processStarTimes($input);
                    break;
            }
        }
    }

    function processZukuTV($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        $selectedMenuService = $this->getSessionVar("menuOptionSelected");

        if ($this->previousPage == "payTVSelected") {
            $this->displayText = "Enter Your Zuku Account Number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processZukuTV";
            $this->previousPage = "enterAccNumber";
        } elseif ($this->previousPage == "enterAccNumber") {

            $this->saveSessionVar("zukuAccountNumber", $input);

            $packageText = "Select package \n";
            $zukuPackages = explode(",", DTBUGconfigs::ZUKU_PACKAGES);

            for ($i = 0; $i < sizeof($zukuPackages); $i++) {
                $packageText .= $i + 1 . ". " . $this->getPackageName($zukuPackages[$i]) . " - " . $this->getPackagePrice($zukuPackages[$i]) . "\n";
            }

            $this->displayText = $packageText;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processZukuTV";
            $this->previousPage = "selectPackage";
        } elseif ($this->previousPage == "selectPackage") {

            $zukuPackages = explode(",", DTBUGconfigs::ZUKU_PACKAGES);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($zukuPackages) || $input < 1) {
#prompt user to enter select package again
                $this->previousPage = "enterAccNumber";
                $this->processZukuTV($this->getSessionVar("zukuAccountNumber"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedPackage = trim($this->getPackageName($zukuPackages[$selectedIndex]));
                $selectedPackagePrice = trim($this->getPackagePrice($zukuPackages[$selectedIndex]));
                $this->saveSessionVar("selectedPackage", $selectedPackage);
                $this->saveSessionVar("selectedPackagePrice", $selectedPackagePrice);
                $accountNumber = $this->getSessionVar("zukuAccountNumber");

                $accountDetails = $this->validatePayTVAccount(DTBUGconfigs::ZUKU_CODE, DTBUGconfigs::ZUKU_SERVICE_ID, DTBUGconfigs::ZUKU_SERVICE_CODE, $accountNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid Zuku Account Number. Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processZukuTV";
                    $this->previousPage = "enterAccNumber";
                } else {
                    $customerName = $accountDetails['customerName'];

                    $this->saveSessionVar("zukuCustomerName", $customerName);

                    $this->displayText = "Name: {$customerName}, Account No: " . $accountNumber . " Package selected: " . $selectedPackage . " Amount: " . number_format($selectedPackagePrice) . ". Enter Amount to pay";

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processZukuTV";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("zukuAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("zukuAmount", $amount);
            }

            $message = "You are paying " . DTBUGconfigs::ZUKU_CODE . "UGX. " . $this->getSessionVar("zukuAmount");
            $message .= ". Account name: " . $this->getSessionVar("zukuCustomerName") . ". ";
            $message .= "Account " . $this->getSessionVar("zukuAccountNumber");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processZukuTV";
            $this->previousPage = "confirmPayment";
        } elseif ($this->previousPage == "confirmPayment") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', DTBUGconfigs::BILLPAY_SERVICE);

                    $this->saveSessionVar('amount', $this->getSessionVar("zukuAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("zukuAmount"));
                    $this->saveSessionVar('merchantCode', DTBUGconfigs::ZUKU_WALLET_MERCHANT_CODE);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("zukuAccountNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('package', $this->getSessionVar("selectedPackage"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processZukuTV($input);
                    break;
            }
        }
    }

    function processKweseTV($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        $selectedMenuService = $this->getSessionVar("menuOptionSelected");

        if ($this->previousPage == "payTVSelected") {
            $this->displayText = "Enter Your Kwese Account Number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processKweseTV";
            $this->previousPage = "enterAccNumber";
        } elseif ($this->previousPage == "enterAccNumber") {

            $this->saveSessionVar("kweseAccountNumber", $input);

            $packageText = "Select package \n";
            $kwesePackages = explode(",", DTBUGconfigs::KWESE_PACKAGES);

            for ($i = 0; $i < sizeof($kwesePackages); $i++) {
                $packageText .= $i + 1 . ". " . $this->getPackageName($kwesePackages[$i]) . " - " . $this->getPackagePrice($kwesePackages[$i]) . "\n";
            }

            $this->displayText = $packageText;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processKweseTV";
            $this->previousPage = "selectPackage";
        } elseif ($this->previousPage == "selectPackage") {

            $kwesePackages = explode(",", DTBUGconfigs::KWESE_PACKAGES);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($kwesePackages) || $input < 1) {
#prompt user to enter select package again
                $this->previousPage = "enterAccNumber";
                $this->processKweseTV($this->getSessionVar("kweseAccountNumber"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedPackage = trim($this->getPackageName($kwesePackages[$selectedIndex]));
                $selectedPackagePrice = trim($this->getPackagePrice($kwesePackages[$selectedIndex]));
                $this->saveSessionVar("selectedPackage", $selectedPackage);
                $this->saveSessionVar("selectedPackagePrice", $selectedPackagePrice);
                $accountNumber = $this->getSessionVar("kweseAccountNumber");

                $accountDetails = $this->validatePayTVAccount(DTBUGconfigs::KWESE_CODE, DTBUGconfigs::KWESE_SERVICE_ID, DTBUGconfigs::KWESE_SERVICE_CODE, $accountNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid Kwese Account Number. Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processKweseTV";
                    $this->previousPage = "enterAccNumber";
                } else {
                    $customerName = $accountDetails['customerName'];

                    $this->saveSessionVar("kweseCustomerName", $customerName);

                    $this->displayText = "Name: {$customerName}, Account No: " . $accountNumber . " Package selected: " . $selectedPackage . " Amount: " . number_format($selectedPackagePrice) . ". Enter Amount to pay";

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processKweseTV";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("kweseAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("kweseAmount", $amount);
            }

            $message = "You are paying " . DTBUGconfigs::KWESE_CODE . "UGX. " . $this->getSessionVar("kweseAmount");
            $message .= ". Account name: " . $this->getSessionVar("kweseCustomerName") . ". ";
            $message .= "Account " . $this->getSessionVar("kweseAccountNumber");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processKweseTV";
            $this->previousPage = "confirmPayment";
        } elseif ($this->previousPage == "confirmPayment") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', DTBUGconfigs::BILLPAY_SERVICE);

                    $this->saveSessionVar('amount', $this->getSessionVar("kweseAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("kweseAmount"));
                    $this->saveSessionVar('merchantCode', DTBUGconfigs::KWESE_WALLET_MERCHANT_CODE);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("kweseAccountNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('package', $this->getSessionVar("selectedPackage"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processKweseTV($input);
                    break;
            }
        }
    }

    //Going to use this function for both gotv and dstv
    function processMultiChoiceTV($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        $selectedMenuService = $this->getSessionVar("menuOptionSelected");

        if ($this->previousPage == "payTVSelected") {
            $this->displayText = "Enter Smart Card /IUC Number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processMultiChoiceTV";
            $this->previousPage = "enterIUCNumber";
        } elseif ($this->previousPage == "enterIUCNumber") {

            $this->saveSessionVar("multichoiceAccount", $input);

            $packageText = "Select package \n";
            $gotvPackage = explode(",", $selectedMenuService == DTBUGconfigs::GOTV_CODE ? DTBUGconfigs::GOTV_PACKAGES : DTBUGconfigs::DSTV_PACKAGES);

            for ($i = 0; $i < sizeof($gotvPackage); $i++) {
                $packageText .= $i + 1 . ". " . $this->getPackageName($gotvPackage[$i]) . " - " . $this->getPackagePrice($gotvPackage[$i]) . "\n";
            }

            $this->displayText = $packageText;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processMultiChoiceTV";
            $this->previousPage = "selectPackage";
        } elseif ($this->previousPage == "selectPackage") {

            $gotvPackage = explode(",", $selectedMenuService == DTBUGconfigs::GOTV_CODE ? DTBUGconfigs::GOTV_PACKAGES : DTBUGconfigs::DSTV_PACKAGES);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($gotvPackage) || $input < 1) {
#prompt user to enter select package again
                $this->previousPage = "enterIUCNumber";
                $this->processMultiChoiceTV($this->getSessionVar("multichoiceAccount"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedPackage = trim($this->getPackageName($gotvPackage[$selectedIndex]));
                $selectedPackagePrice = trim($this->getPackagePrice($gotvPackage[$selectedIndex]));
                $this->saveSessionVar("selectedPackage", $selectedPackage);
                $this->saveSessionVar("selectedPackagePrice", $selectedPackagePrice);
                $accountNumber = $this->getSessionVar("multichoiceAccount");

                $serviceID = $selectedMenuService == DTBUGconfigs::GOTV_CODE ? DTBUGconfigs::GOTV_SERVICE_ID : DTBUGconfigs::DSTV_SERVICE_ID;
                $serviceCode = $selectedMenuService == DTBUGconfigs::GOTV_CODE ? DTBUGconfigs::GOTV_SERVICE_CODE : DTBUGconfigs::DSTV_SERVICE_CODE;

                $accountDetails = $this->validatePayTVAccount($selectedMenuService, $serviceID, $serviceCode, $accountNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid account UIC Number. Please enter it again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processMultiChoiceTV";
                    $this->previousPage = "enterIUCNumber";
                } else {
                    $customerName = $accountDetails['customerName'];

                    $this->saveSessionVar("MCCustomerName", $customerName);

                    $this->displayText = "Name: {$customerName}, Smart Card No: " . $accountNumber . " Package selected: " . $selectedPackage . " Amount: " . number_format($selectedPackagePrice) . ". Enter Amount to pay";

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processMultiChoiceTV";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("MCAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("MCAmount", $amount);
            }

            $message = "You are paying " . $selectedMenuService . " UGX. " . $this->getSessionVar("MCAmount");
            $message .= ". Account name: " . $this->getSessionVar("MCCustomerName") . ". ";
            $message .= "UIC Number " . $this->getSessionVar("multichoiceAccount");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processMultiChoiceTV";
            $this->previousPage = "confirmGoTVPayment";
        } elseif ($this->previousPage == "confirmGoTVPayment") {
            switch ($input) {
                case 1:

                    $walletMerchantCode = $selectedMenuService == DTBUGconfigs::GOTV_CODE ? DTBUGconfigs::GOTV_WALLET_MERCHANT_CODE : DTBUGconfigs::DSTV_WALLET_MERCHANT_CODE;

                    $this->saveSessionvar('serviceID', 'BILL_PAY');

                    $this->saveSessionVar('amount', $this->getSessionVar("MCAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("MCAmount"));
                    $this->saveSessionVar('merchantCode', $walletMerchantCode);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("multichoiceAccount"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('package', $this->getSessionVar("selectedPackage"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processMultiChoiceTV($input);
                    break;
            }
        }
    }

    function processAzamTV($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        $selectedMenuService = $this->getSessionVar("menuOptionSelected");

        if ($this->previousPage == "payTVSelected") {
            $this->displayText = "Enter Your Azam Account number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processAzamTV";
            $this->previousPage = "enterAccNumber";
        } elseif ($this->previousPage == "enterAccNumber") {

            $this->saveSessionVar("azamAccountNumber", $input);

            $packageText = "Select package \n";
            $azamPackages = explode(",", DTBUGconfigs::AZAM_PACKAGES);

            for ($i = 0; $i < sizeof($azamPackages); $i++) {
                $packageText .= $i + 1 . ". " . $this->getPackageName($azamPackages[$i]) . " - " . $this->getPackagePrice($azamPackages[$i]) . "\n";
            }

            $this->displayText = $packageText;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processAzamTV";
            $this->previousPage = "selectPackage";
        } elseif ($this->previousPage == "selectPackage") {

            $azamPackages = explode(",", DTBUGconfigs::AZAM_PACKAGES);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($azamPackages) || $input < 1) {
#prompt user to enter select package again
                $this->previousPage = "enterAccNumber";
                $this->processAzamTV($this->getSessionVar("azamAccountNumber"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedPackage = trim($this->getPackageName($azamPackages[$selectedIndex]));
                $selectedPackagePrice = trim($this->getPackagePrice($azamPackages[$selectedIndex]));
                $this->saveSessionVar("selectedPackage", $selectedPackage);
                $this->saveSessionVar("selectedPackagePrice", $selectedPackagePrice);
                $accountNumber = $this->getSessionVar("azamAccountNumber");

                $accountDetails = $this->validatePayTVAccount(DTBUGconfigs::AZAM_CODE, DTBUGconfigs::AZAM_SERVICE_ID, DTBUGconfigs::AZAM_SERVICE_CODE, $accountNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid Azam Account Number. Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAzamTV";
                    $this->previousPage = "enterAccNumber";
                } else {
                    $customerName = $accountDetails['customerName'];

                    $this->saveSessionVar("azamCustomerName", $customerName);

                    $this->displayText = "Name: {$customerName}, Account No: " . $accountNumber . " Package selected: " . $selectedPackage . " Amount: " . number_format($selectedPackagePrice) . ". Enter Amount to pay";

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAzamTV";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("azamAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("azamAmount", $amount);
            }

            $message = "You are paying " . DTBUGconfigs::AZAM_CODE . "UGX. " . $this->getSessionVar("azamAmount");
            $message .= ". Account name: " . $this->getSessionVar("azamCustomerName") . ". ";
            $message .= "Account " . $this->getSessionVar("azamAccountNumber");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processAzamTV";
            $this->previousPage = "confirmAzamPayment";
        } elseif ($this->previousPage == "confirmAzamPayment") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', DTBUGconfigs::BILLPAY_SERVICE);

                    $this->saveSessionVar('amount', $this->getSessionVar("azamAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("azamAmount"));
                    $this->saveSessionVar('merchantCode', DTBUGconfigs::AZAM_WALLET_MERCHANT_CODE);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("azamAccountNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('package', $this->getSessionVar("selectedPackage"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processAzamTV($input);
                    break;
            }
        }
    }

    function getPackageName($fullPackageCombined) {
        $packageName = DTBUGconfigs::DEFAULT_PACKAGE_NAME;
        $array = explode("=", $fullPackageCombined);
        if (isset($array[1])) {
            $packageName = $array[0];
        }

        return $packageName;
    }

    function getPackagePrice($fullPackageCombined) {
        $packagePrice = 0;
        $array = explode("=", $fullPackageCombined);
        if (isset($array[1])) {
            $packagePrice = $array[1];
        }
        return $packagePrice;
    }

    //End of PayTV functions



    function processURA($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        if ($this->previousPage == "utilitySelected") {

            $this->displayText = "Enter TIN Number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processURA";
            $this->previousPage = "enterTinNumber";
        } elseif ($this->previousPage == "enterTinNumber") {

            if ($this->getSessionVar("URACustomerName") != null) { //we have already validated the tin
                $message = "Invalid input. You are paying " . $this->getSessionVar("URABalance");
                $message .= ". Customer name: " . $this->getSessionVar("URACustomerName") . ". ";
                $message .= "Account " . $this->getSessionVar("URA_TIN");
                $message .= "\n1: Confirm \n2: Cancel";

                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processURA";
                $this->previousPage = "confirmURAPayment";
            } else {
                $uraTin = $input;
                $accountDetails = $this->validateURATin($uraTin);

                if ($accountDetails == "") {
                    $this->displayText = "Invalid TIN, Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processURA";
                    $this->previousPage = "enterTinNumber";
                } else {

                    $customerName = $accountDetails['customerName'];
                    $balance = $accountDetails['balance'];

                    $this->saveSessionVar("URACustomerName", $customerName);
                    $this->saveSessionVar("URABalance", $balance);
                    $this->saveSessionVar("URA_TIN", $uraTin);

                    $message = "You are paying " . $balance;
                    $message .= ". Customer name: " . $customerName . ". ";
                    $message .= "Account " . $uraTin;
                    $message .= "\n1: Confirm \n2: Cancel";
                    $this->displayText = $message;

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processURA";
                    $this->previousPage = "confirmURAPayment";
                }
            }
        } elseif ($this->previousPage == "confirmURAPayment") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', 'BILL_PAY');

                    $this->saveSessionVar('amount', $this->getSessionVar("URABalance"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("URABalance"));
                    $this->saveSessionVar('merchantCode', $this->uraServiceCode);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("URA_TIN"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processUmeme($input);
                    break;
            }
        }
    }

    function validateURATin($accountNumber) {

        $this->logMessage("Validate URA TIN...", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array(
            'serviceID' => $this->uraServiceID,
            'serviceCode' => $this->uraServiceCode,
            'accountNumber' => $accountNumber,
            'requestExtraData' => ''
        );

        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $this->logMessage("payload to send to hub: ", $spayload, DTBUGconfigs::LOG_LEVEL_INFO);


//$response = post("http://127.0.0.1/BeepJsonAPI/index.php",json_encode($spayload));
        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));
        $this->logMessage("Response from hub: ", $response, DTBUGconfigs::LOG_LEVEL_INFO);
        $responseArray = json_decode($response, true);


        $authStatusCode = $responseArray['authStatus']['authStatusCode'];
        $authStatusDesc = $responseArray['authStatus']['authStatusDescription'];

        if ($authStatusCode != $this->hubAuthSuccessCode) {
            $this->logMessage("Authentication Failed !!!!!!! ", NULL, DTBUGconfigs::LOG_LEVEL_INFO);
            return "";
        }

        $statusCode = $responseArray['results'][0]['statusCode'];
        $responseData = $responseArray['results'][0]['responseExtraData'];

        if ($statusCode != $this->hubValidationSuccessCode) {
            $this->logMessage("INVALID account !!!!!!! ", NULL, DTBUGconfigs::LOG_LEVEL_INFO);
            return "";
        }

        $responseDataArray = json_decode($responseData, true);
        $this->logMessage("Response from validate URA TIN: ", $responseDataArray, DTBUGconfigs::LOG_LEVEL_INFO);

        return $responseDataArray;
    }

    function processUmeme($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        if ($this->previousPage == "utilitySelected") {

            $this->displayText = "Enter meter number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processUmeme";
            $this->previousPage = "enterMeterNumber";
        } elseif ($this->previousPage == "enterMeterNumber") {

            $meterNumber = $input;
            $accountDetails = $this->validateUMEMECustomerAccount($meterNumber);

            if ($accountDetails == "") {

                $this->displayText = "Invalid account Meter number. Please enter meter number again";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processUmeme";
                $this->previousPage = "enterMeterNumber";
            } else {

                $customerName = $accountDetails['customerName'];
                $balance = $accountDetails['balance'];
                $customerType = $accountDetails['customerType'];

                $this->saveSessionVar("umemeCustomerName", $customerName);
                $this->saveSessionVar("umemeBalance", $balance);
                $this->saveSessionVar("umemeCustomerType", $customerType);
                $this->saveSessionVar("umemeMeterNumber", $meterNumber);

                if ($customerType == "POSTPAID" && $balance != 0) {
//     $this->displayText = "Your balance is UGX " . $balance . ". Enter Amount to pay";
                    $this->displayText = "Dear {$customerName}, your balance is " . number_format($balance) . ". Meter number {$meterNumber}.\n Enter amount to pay";
                } else {
// $this->displayText = "Enter Amount to pay";
                    $this->displayText = "Dear {$customerName}, your balance is " . number_format($balance) . "  Meter number {$meterNumber}.\n Enter amount to pay";
                }

                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processUmeme";
                $this->previousPage = "enterAmount";
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("umemeAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("umemeAmount", $amount);
            }

            $umemeBalance = $this->getSessionVar("umemeBalance") == NULL ? 0 : $this->getSessionVar("umemeBalance");
            $this->logMessage("Comparing balance " . $umemeBalance . " and the entered amount " . $this->getSessionVar("umemeAmount"), NULL, DTBUGconfigs::LOG_LEVEL_INFO);
            if (($this->getSessionVar("umemeCustomerType") == 'PREPAID') && $this->getSessionVar("umemeAmount") < ($umemeBalance + $this->umemeMinimum)) {
                $this->saveSessionVar("umemeAmount", NULL);
                $this->displayText = "Invalid amount\n Please enter an amount greater than your balance of " . round($umemeBalance);
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processUmeme";
                $this->previousPage = "enterAmount";
            } else {
                $message = "You are paying " . $this->getSessionVar("umemeAmount");
                $message .= ". Account name: " . $this->getSessionVar("umemeCustomerName") . ". ";
                $message .= "Meter number " . $this->getSessionVar("umemeMeterNumber");
                $message .= "\n1: Confirm \n2: Cancel";
                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processUmeme";
                $this->previousPage = "confirmUmemePay";
            }
        } elseif ($this->previousPage == "confirmUmemePay") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', 'BILL_PAY');

                    $this->saveSessionVar('amount', $this->getSessionVar("umemeAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("umemeAmount"));
                    $this->saveSessionVar('merchantCode', 'UMEME');
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("umemeMeterNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processUmeme($input);
                    break;
            }
        }
    }

    function processNwsc($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        if ($this->previousPage == "utilitySelected") {

            $this->displayText = "Enter meter number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processNwsc";
            $this->previousPage = "enterMeterNumber";
        } elseif ($this->previousPage == "enterMeterNumber") {

            $this->saveSessionVar("nwscMeterNumber", $input);

            $text = "Select area \n";
            $areasArray = explode(",", $this->nwscAreas);

            for ($i = 0; $i < sizeof($areasArray); $i++) {
                $text .= $i + 1 . ". " . $areasArray[$i] . "\n";
            }

            $this->displayText = $text;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processNwsc";
            $this->previousPage = "selectArea";
        } elseif ($this->previousPage == "selectArea") {

            $areasArray = explode(",", $this->nwscAreas);
            $input = (int) $input;

#check for array index out of bounds
            if ($input > sizeof($areasArray) || $input < 1) {
#prompt user to enter select area again
                $this->previousPage = "enterMeterNumber";
                $this->processNwsc($this->getSessionVar("nwscMeterNumber"));
            } else {
#valid index has been selected
                $selectedIndex = $input - 1;
                $selectedArea = trim($areasArray[$selectedIndex]);
                $this->saveSessionVar("selectedArea", $selectedArea);
                $meterNumber = $this->getSessionVar("nwscMeterNumber");

                $accountDetails = $this->validateNWSCCustomerAccount($meterNumber, $selectedArea);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid account Meter number. Please enter meter number again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processNwsc";
                    $this->previousPage = "enterMeterNumber";
                } else {

                    $customerName = $accountDetails['customerName'];
                    $balance = $accountDetails['balance'];
                    $customerType = $accountDetails['customerType'];

                    $this->saveSessionVar("nwscCustomerName", $customerName);

                    if ($balance == 0) {
//$this->displayText = "Enter Amount to pay";
                        $this->displayText = "Dear {$customerName}, Your balance is UGX " . number_format($balance) . ". Enter Amount to pay";
                    } else {
                        $this->displayText = "Dear {$customerName}, Your balance is UGX " . number_format($balance) . ". Enter Amount to pay";
                    }

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processNwsc";
                    $this->previousPage = "enterAmount";
                }
            }
        } elseif ($this->previousPage == "enterAmount") {

            if ($this->getSessionVar("nwscAmount") == null) {
                $amount = (int) $input;
                $this->saveSessionVar("nwscAmount", $amount);
            }

            $message = "You are paying NWSC UGX. " . $this->getSessionVar("nwscAmount");
            $message .= ". Account name: " . $this->getSessionVar("nwscCustomerName") . ". ";
            $message .= "Meter number " . $this->getSessionVar("nwscMeterNumber");
            $message .= "\n1: Confirm \n2: Cancel";
            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processNwsc";
            $this->previousPage = "confirmNwscPay";
        } elseif ($this->previousPage == "confirmNwscPay") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', 'BILL_PAY');

                    $this->saveSessionVar('amount', $this->getSessionVar("nwscAmount"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("nwscAmount"));
                    $this->saveSessionVar('merchantCode', 'NWSC');
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("nwscMeterNumber"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                    $this->saveSessionVar('NWSCarea', $this->getSessionVar("selectedArea"));

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";

                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processNwsc($input);
                    break;
            }
        }
    }

    function processKCCA($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');

        if ($this->previousPage == "utilitySelected") {

            $this->displayText = "Enter Payment Reference Number. PRN";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processKCCA";
            $this->previousPage = "enterMeterNumber";
        } elseif ($this->previousPage == "enterMeterNumber") {

            if ($this->getSessionVar("KCCACustomerName") != null) { //we have already validated the account
                $message = "Invalid input. You are paying " . $this->getSessionVar("KCCABalance");
                $message .= ". Customer name: " . $this->getSessionVar("KCCACustomerName") . ". ";
                $message .= "PRN " . $this->getSessionVar("KCCAPRN");
                $message .= "\n1: Confirm \n2: Cancel";

                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processKCCA";
                $this->previousPage = "confirmKCCAPay";
            } else {

                $meterNumber = $input;
                $accountDetails = $this->validateKCCACustomerAccount($meterNumber);

                if ($accountDetails == "") {

                    $this->displayText = "Invalid PRN, Please try again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processKCCA";
                    $this->previousPage = "enterMeterNumber";
                } else {

                    $customerName = $accountDetails['customerName'];
                    $balance = $accountDetails['balance'];

                    $this->saveSessionVar("KCCACustomerName", $customerName);
                    $this->saveSessionVar("KCCABalance", $balance);
                    $this->saveSessionVar("KCCAPRN", $meterNumber);

                    $message = "You are paying " . $balance;
                    $message .= ". Customer name: " . $customerName . ". ";
                    $message .= "PRN " . $meterNumber;
                    $message .= "\n1: Confirm \n2: Cancel";
                    $this->displayText = $message;

                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processKCCA";
                    $this->previousPage = "confirmKCCAPay";
                }
            }
        } elseif ($this->previousPage == "confirmKCCAPay") {
            switch ($input) {
                case 1:

                    $this->saveSessionvar('serviceID', 'BILL_PAY');

                    $this->saveSessionVar('amount', $this->getSessionVar("KCCABalance"));
                    $this->saveSessionVar('nomination', 'no');
                    $this->saveSessionVar('utilityBillAmount', $this->getSessionVar("KCCABalance"));
                    $this->saveSessionVar('merchantCode', $this->kccaServiceCode);
                    $this->saveSessionVar('utilityBillAccountNo', $this->getSessionVar("KCCAPRN"));
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('billEnrolment', "NO");
                    $this->saveSessionVar('billEnrolmentNumber', 'NULL');

                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                    break;

                case 2:
                    $this->startPage();
                    break;

                default:
                    $this->previousPage = "enterAmount";
                    $this->processUmeme($input);
                    break;
            }
        }
    }

    function validateUMEMECustomerAccount($accountNumber) {

        $this->logMessage("Validate Umeme meter number: " . $accountNumber, NULL, DTBUGconfigs::LOG_LEVEL_INFO);

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array(
            'serviceID' => $this->umemeServiceID,
            'serviceCode' => $this->umemeServiceCode,
            'accountNumber' => $accountNumber,
            'requestExtraData' => ''
        );

        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $this->logMessage("payload to send to hub: ", $spayload, DTBUGconfigs::LOG_LEVEL_INFO);

//$response = post("http://127.0.0.1/BeepJsonAPI/index.php",json_encode($spayload));
        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));
        $this->logMessage("Response from hub: ", $response, DTBUGconfigs::LOG_LEVEL_INFO);
        $responseArray = json_decode($response, true);


        $authStatusCode = $responseArray['authStatus']['authStatusCode'];
        $authStatusDesc = $responseArray['authStatus']['authStatusDescription'];

        if ($authStatusCode != $this->hubAuthSuccessCode) {
            $this->logMessage("Authentication Failed !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

            return "";
        }

        $statusCode = $responseArray['results'][0]['statusCode'];
        $responseData = $responseArray['results'][0]['responseExtraData'];

        if ($statusCode != $this->hubValidationSuccessCode) {
            $this->logMessage("INVALID account !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);
            return "";
        }

        $responseDataArray = json_decode($responseData, true);
        $this->logMessage("Response from validate UMEME: ", $responseDataArray, DTBUGconfigs::LOG_LEVEL_INFO);

        return $responseDataArray;
    }

    function validateKCCACustomerAccount($accountNumber) {
        $this->logMessage("Validate KCCA PRN: " . $accountNumber, NULL, DTBUGconfigs::LOG_LEVEL_INFO);

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array(
            'serviceID' => $this->kccaServiceID,
            'serviceCode' => $this->kccaServiceCode,
            'accountNumber' => $accountNumber,
            'requestExtraData' => ''
        );

        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $this->logMessage("payload to send to hub: ", $spayload);


//$response = post("http://127.0.0.1/BeepJsonAPI/index.php",json_encode($spayload));
        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));
        $this->logMessage("Response from hub: ", $response, DTBUGconfigs::LOG_LEVEL_INFO);
        $responseArray = json_decode($response, true);


        $authStatusCode = $responseArray['authStatus']['authStatusCode'];
        $authStatusDesc = $responseArray['authStatus']['authStatusDescription'];

        if ($authStatusCode != $this->hubAuthSuccessCode) {
            $this->logMessage("Authentication Failed !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

            return "";
        }

        $statusCode = $responseArray['results'][0]['statusCode'];
        $responseData = $responseArray['results'][0]['responseExtraData'];

        if ($statusCode != $this->hubValidationSuccessCode) {
            $this->logMessage("INVALID account !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

            return "";
        }

        $responseDataArray = json_decode($responseData, true);
        $this->logMessage("Response from validate KCCA: ", $responseDataArray, DTBUGconfigs::LOG_LEVEL_INFO);

        return $responseDataArray;
    }

    function validateNWSCCustomerAccount($accountNumber, $area) {
        $this->logMessage("Validate NWSC meter number: " . $accountNumber, NULL, DTBUGconfigs::LOG_LEVEL_INFO);

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array(
            'serviceID' => $this->nwscServiceID,
            'serviceCode' => $this->nwscServiceCode,
            'accountNumber' => $accountNumber,
            'requestExtraData' => "{\"area\": \"$area\"}"
        );

        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $this->logMessage("payload to send to hub: ", $spayload, DTBUGconfigs::LOG_LEVEL_INFO);


//$response = post("http://127.0.0.1/BeepJsonAPI/index.php",json_encode($spayload));
        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));
        $this->logMessage("Response from hub: ", $response, DTBUGconfigs::LOG_LEVEL_INFO);
        $responseArray = json_decode($response, true);


        $authStatusCode = $responseArray['authStatus']['authStatusCode'];
        $authStatusDesc = $responseArray['authStatus']['authStatusDescription'];

        if ($authStatusCode != $this->hubAuthSuccessCode) {
            $this->logMessage("Authentication Failed !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

            return "";
        }

        $statusCode = $responseArray['results'][0]['statusCode'];
        $responseData = $responseArray['results'][0]['responseExtraData'];

        if ($statusCode != $this->hubValidationSuccessCode) {
            $this->logMessage("INVALID account !!!!!!!", NULL, DTBUGconfigs::LOG_LEVEL_INFO);

            return "";
        }

        $responseDataArray = json_decode($responseData, true);
        $this->logMessage("Response from validate NWSC: ", $responseDataArray, DTBUGconfigs::LOG_LEVEL_INFO);

        return $responseDataArray;
    }

    /* ================== end bill processing ========== */

    function validateCustomerAccount($merchantCode, $serviceID, $serviceCode, $meterNumber, $area) {

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array();

        if ($merchantCode == "NWSC") {

            $packet = array(
                'serviceID' => $serviceID,
                'serviceCode' => $serviceCode,
                'accountNumber' => $meterNumber,
                'requestExtraData' => "{\"area\": \"$area\"}"
            );
        } else {
            $packet = array(
                'serviceID' => $serviceID,
                'serviceCode' => $serviceCode,
                'accountNumber' => $meterNumber,
                'requestExtraData' => ''
            );
        }

        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));

        $responseArray = json_decode($response, true);

        $responseData = $responseArray['results'][0]['responseExtraData'];

        $responseDataArray = json_decode($responseData, true);


        return $responseDataArray;
    }

    function validatePayTVAccount($merchantCode, $serviceID, $serviceCode, $accountNumber) {

        $credentials = array(
            "username" => $this->beepUsername,
            "password" => $this->beepPassword
        );

        $packet = array();


        $extraData = json_encode(array(
            "area" => "",
            "customerMobile" => $this->_msisdn,
            "merchantCode" => $merchantCode)
        );

        $packet = array(
            'serviceID' => $serviceID,
            'serviceCode' => $serviceCode,
            'accountNumber' => $accountNumber,
            'requestExtraData' => $extraData,
            'extraData' => $extraData,
        );


        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
            "function" => $this->hubValidationFunction,
            "payload" => json_encode($payload)
        );

        $response = $this->postValidationRequestToHUB($this->hubJSONAPIUrl, json_encode($spayload));

        $responseArray = json_decode($response, true);

        $responseData = $responseArray['results'][0]['responseExtraData'];

        $responseDataArray = json_decode($responseData, true);


        return $responseDataArray;
    }

    function postValidationRequestToHUB($url, $fields) {
        $fields_string = null;

        $ch = curl_init();
//set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//execute post
        $result = curl_exec($ch);
//close connection
        curl_close($ch);
        return $result;
    }

    function reload($input) {
        switch ($input) {

            case 0:
                $this->displayText = "Thank you for using DTB mobile";
                $this->sessionState = "END";
                break;

            case 1:
                $this->displayText = "Please select a service.\n" . $this->CBSservices;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
                break;
            default:
                $this->displayText = "Thank you for using DTB mobile";
                $this->sessionState = "END";
                break;
        }
    }

    function servicesOff($input) {
        switch ($input) {
            case 1 :
                $this->displayText = "Select:\n$this->CBSservices";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "selectBankAccount";
                break;

            default :
                $this->displayText = "Thank you for banking with" . DTBUGconfigs::BANK_SIGNATURE;
                $this->sessionState = "END";
                break;
        }
    }

    /////End Of Pay Bill and Pay TVs/////////////////


    function validateMobileNumber($input) {
        if (strlen($input) == 12 && is_numeric($input)) {
            $this->saveSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER, $input);
            $this->displayText = "Please enter the amount";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "validateAmount";
            $this->previousPage = "validateMobileNumber";
        } else {
            $this->displayText = "Invalid input. Please enter customer mobile "
                    . "number in the format 2567XXXXXXXX";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "validateMobileNumber";
            $this->previousPage = "validateMobileNumber";
        }
    }

    function validateAmount($input) {
        if (is_numeric($input)) {
            if ($input < $this->MIN_AMOUNT || $input > $this->MAX_AMOUNT) {
                $this->displayText = "Invalid input. Enter amount between 500 and 4000000";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "validateAmount";
                $this->previousPage = "validateAmount";
            } else {
                $this->saveSessionVar($this->KEY_AMOUNT, $input);
                $customerMobile = $this->getSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER);
                $this->displayText = "Transaction Details:\nPayment of UGX"
                        . $input . " from " . $customerMobile
                        . "\nEnter \n1. Confirm\n2. Change Details";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "confirmDetails";
                $this->previousPage = "validateAmount";
            }
        } else {
            $this->displayText = "Invalid input. Please enter the amount";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "validateAmount";
            $this->previousPage = "validateAmount";
        }
    }

    function editCustomerNumber($input) {
        if (strlen($input) == 12 && is_numeric($input)) {
            $amount = $this->getSessionVar($this->KEY_AMOUNT);
            $this->saveSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER, $input);
            $this->displayText = "Transaction Details:\nPayment of UGX"
                    . $amount . " from " . $input
                    . "\nEnter \n1. Confirm\n2. Change Details";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "confirmDetails";
            $this->previousPage = "editCustomerNumber";
        } else {
            $customerMobile = $this->getSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER);
            $this->displayText = "Invalid input. Please enter new customer mobile "
                    . "number in the format 2567XXXXXXXX";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "editCustomerNumber";
            $this->previousPage = "editCustomerNumber";
        }
    }

    function editAmount($input) {
        if (is_numeric($input)) {
            if ($input < $this->MIN_AMOUNT || $input > $this->MAX_AMOUNT) {
                $this->displayText = "Invalid input. Enter new  amount between 500 and 4000000";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "editAmount";
                $this->previousPage = "editTransactionDetails";
            } else {
                $this->saveSessionVar($this->KEY_AMOUNT, $input);
                $customerMobile = $this->getSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER);
                $this->displayText = "Transaction Details:\nPayment of UGX"
                        . $input . " from " . $customerMobile
                        . "\nEnter \n1. Confirm\n2. Change Details";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "confirmDetails";
                $this->previousPage = "editAmount";
            }
        } else {
            $this->displayText = "Invalid input. Please enter the new amount";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "editAmount";
            $this->previousPage = "editTransactionDetails";
        }
    }

    function editTransactionDetails($input) {
        if (is_numeric($input)) {
            if ($input == 1) {
                $customerMobile = $this->getSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER);
                $this->displayText = "Enter new customer number current(" . $customerMobile . ")";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "editCustomerNumber";
                $this->previousPage = "confirmDetails";
            } else if ($input == 2) {
                $currentAmount = $this->getSessionVar($this->KEY_AMOUNT);
                $this->displayText = "Enter new amount current(" . $currentAmount . ")";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "editAmount";
                $this->previousPage = "confirmDetails";
            } else {
                $this->displayText = "Invalid input. Please enter one of the specified numbers";
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = "MTN Mula";
                $this->nextFunction = "editTransactionDetails";
                $this->previousPage = "confirmDetails";
            }
        } else {
            $this->displayText = "Invalid input. Please enter a number";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "editTransactionDetails";
            $this->previousPage = "confirmDetails";
        }
    }

    function confirmDetails($input) {
        $amount = $this->getSessionVar($this->KEY_AMOUNT);
        $customerNumber = $this->getSessionVar($this->KEY_CUSTOMER_MOBILE_NUMBER);
        if ($input == 1) {
            $requestPayload = array(
                "CustomerMSISDN" => $customerNumber,
                "Amount" => $amount,
            );
            $logRequest = $this->logChannelRequest($requestPayload, $this->STATUS_CODE, NULL, 359);
            if ($logRequest['SUCCESS'] == TRUE) {
                $display = "Your request for payment of " . $amount
                        . " from " . $customerNumber . " is being processed."
                        . " You will receive confirmation shortly. "
                        . "Thank you for using Mula";
            } else {
                $display = "An error occurred and we could not process your request. Please try again later.";
            }
            $this->displayText = $display;
            $this->serviceDescription = "MTN Mula";
            $this->sessionState = "END";
        } elseif ($input == 2) {
            $this->displayText = "Please select details to correct:"
                    . "\n1. Customer mobile number (" . $customerNumber . ")"
                    . "\n2. Transaction amount (UGX " . $amount . ")";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "editTransactionDetails";
            $this->previousPage = "confirmDetails";
            $this->serviceDescription = "MTN Mula";
        } else {
            $this->displayText = "Invalid input:\nPayment of UGX"
                    . $amount . " from " . $customerNumber
                    . "\nPlease Enter \n1. Confirm\n2. Change Details";
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = "MTN Mula";
            $this->nextFunction = "confirmDetails";
            $this->previousPage = "confirmDetails";
        }
    }

    function renderErrorMessage() {
        $this->displayText = "Sorry we are not able to process your request at "
                . "this time. Please try again later.";
        $this->sessionState = "END";
    }

    function populateClientProfile($clientProfile) {
        $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
        $clientProfile = array();
        if ($clientProfiledata != null) {
            $clientprofileID = $clientProfiledata [0];
            $profileactive = $clientProfiledata [1];
            $customeractive = $clientProfiledata [1];
            $profile_pin_status = $clientProfiledata [2];
            $firstName = $clientProfiledata [3] != null ? $clientProfiledata [3] : "";
            $lastName = $clientProfiledata [4] != null ? $clientProfiledata [4] : "";
            $customerNames = $firstName . " " . $lastName;
            $clientProfile = [
                "clientprofileID" => $clientprofileID,
                "profileactive" => $profileactive,
                "customeractive" => $customeractive,
                "profile_pin_status" => $profile_pin_status,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "customerNames" => $customerNames
            ];
            $this->saveSessionVar('clientprofileID', $clientProfile["clientprofileID"]);
            $this->saveSessionVar('profileactive', $clientProfile["profileactive"]);
            $this->saveSessionVar('customeractive', $clientProfile["customeractive"]);
            $this->saveSessionVar('profile_pin_status', $clientProfile["profile_pin_status"]);
            $this->saveSessionVar('firstName', $clientProfile["firstName"]);
            $this->saveSessionVar('lastName', $clientProfile["lastName"]);
            $this->saveSessionVar('customerNames', $clientProfile["customerNames"]);
        }
        return $clientProfile;
    }

    function populateAccountDetails($clientProfile) {
        $clientAccountData = explode('#', $clientProfile ['accountDetails']);
//        [accountDetails] =>
//        31|3000001968|teddy|1|Uganda Shilling |800|UGX |31
//        #
//        8|3000025673|TOM KAMUKAMA|1|Uganda Shilling |800|UGX |31
//        [nominationDetails] =>
//        hi|3000010207|Kampala|NIC
//        [EXCEPTION] =>
//        )
        if ($clientAccountData != null) {
            $ACCOUNTS = $clientAccountData;
            $ACCOUNTSDATA = [];
            $count = 0;
            foreach ($ACCOUNTS as $ACCOUNT) {
                $count ++;
                $singleAccount = explode("|", $ACCOUNT);
                $ACCOUNTCBSID = $singleAccount[0];
                $ACCOUNTNUMBER = $singleAccount[1];
                $ACCOUNTNAME = $singleAccount[2];
//todo: undefined not known
                $ACCOUNTCURRENCYINWORDS = $singleAccount[4];
                $ACCOUNTBALANCE = $singleAccount[5];
                $ACCOUNTCURRENCY = $singleAccount[6];
                $ACCOUNTDATA = [
                    "ID" => $count,
                    "ACCOUNTCBSID" => $ACCOUNTCBSID,
                    "ACCOUNTNUMBER" => $ACCOUNTNUMBER,
                    "ACCOUNTNAME" => $ACCOUNTNAME,
                    "ACCOUNTCURRENCYINWORDS" => $ACCOUNTCURRENCYINWORDS,
                    "ACCOUNTBALANCE" => $ACCOUNTBALANCE,
                    "ACCOUNTCURRENCY" => $ACCOUNTCURRENCY
                ];
                $ACCOUNTSDATA [] = $ACCOUNTDATA;
            }
            $this->saveSessionVar('ACCOUNTS', $ACCOUNTSDATA);
            return $ACCOUNTSDATA;
        }
    }

    function postData($url, $fields) {
        $fields_string = null;
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    function invokeWallet($walletFunction, $payload) {
        //Get the wallet url
        $walletUrl = $this->serverURL;
        try {
            //make API call
            $client = new IXR_Client($walletUrl);
            $client->debug = false;
            if (!$client->query($walletFunction, $payload)) {
                $this->logMessage("IXR_Client error occurred - " . $client->getErrorCode() . ":" . $client->getErrorMessage(), null, 4);
            }
            //get response
            $result = $client->getResponse();
            $data = json_decode($result, true);
            $this->logMessage("|Wallet URL: " . $walletUrl . " | Response from wallet:", $data, 4);

            return $result;
        } catch (Exception $exception) {
            $this->logMessage("Exception occured:" . $exception->getMessage(), null, 4);
            return "MVERS" . $exception->getMessage();
        }
    }

    public function invokeAsyncWallet($payload, $channelRequestID) {
        try {
            $username = "admin";
            $password = "admin";
            $apiUrl = $this->serverURL;
            $apiFunction = "processCloudRequest"; //logRequest;
            //convert array into XML format
            //formulate xml payload.
            $request_xml = "<Payload>";
            foreach ($payload as $key => $value) {
                $request_xml .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $request_xml .= "</Payload>";
            $payload = $request_xml;
            $credentials = array(
                'cloudUser' => $username,
                'cloudPass' => $password,
            );
            if (is_array($channelRequestID)) {
                $channelRequestID = $channelRequestID['LAST_INSERT_ID'];
            }
            //define cloud packet data
            $cloudPacket = array(
                "MSISDN" => $this->_msisdn,
                "destination" => $this->accessPoint, //create this in accessPoints
                "IMCID" => "2",
                "channelRequestID" => $channelRequestID,
                "networkID" => 1,
                "cloudDateReceived" => date('Y-m-d H:i:s'),
                "payload" => base64_encode($payload),
                "imcRequestID" => $this->IMCREQUESTID,
                "requestMode" => "0", //0 if sync and 1 when async
                "clientSystemID" => 77,
                "systemName" => 'USSD',
            );
            //package our data
            $params = array(
                'credentials' => $credentials,
                'cloudPacket' => $cloudPacket,
            );
            //make API call
            $client = new IXR_Client($apiUrl);
            $client->debug = false;
            $client->query($apiFunction, $params);
            $client->query("processCloudRequest", $cloudPacket);
            $response = $client->getResponse();

            if (!$response) {
                $error_message = $client->getErrorMessage();

                $this->logMessage("IXR_Client error occurred - " . $client->getErrorCode() . ":" . $error_message, null, 4);
                return $error_message;
            }
            $this->logMessage("|Wallet URL: " . $apiUrl . " | Response from wallet: ", $response, 4);
            return $response;
        } catch (Exception $exception) {
            $this->logMessage("Exception occured: " . $exception->getMessage(), null, 4);
            return FALSE;
        }
    }

    public function invokeSyncWallet($payload, $channelRequestID) {
        try {
            $username = "admin";
            $password = "admin";
//            $apiUrl = $this->walletSyncRequestURL;
            $apiUrl = $this->serverURL;
            $apiFunction = "processCloudRequest";
            //convert array into XML format
            //formulate xml payload.
            $request_xml = "";
            $request_xml = "<Payload>";
            foreach ($payload as $key => $value) {
                $request_xml .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $request_xml .= "</Payload>";
            $payload = $request_xml;
            $credentials = array(
                'cloudUser' => $username,
                'cloudPass' => $password,
            );
            //define cloud packet data
            $cloudPacket = array(
                "MSISDN" => $this->_msisdn,
                "destination" => $this->accessPoint,
                //$this->accessPoint, //create this in accessPoints
                "IMCID" => "2",
                "channelRequestID" => $channelRequestID,
                "networkID" => 1,
                "cloudDateReceived" => date('Y-m-d H:i:s'),
                "payload" => base64_encode($payload),
                "imcRequestID" => $this->IMCREQUESTID,
                "requestMode" => 1, //this means that this is a synchronous  //0 if sync and 1 when async
                "clientSystemID" => 77,
                "systemName" => 'USSD'
            );
            //package our data
            $params = array(
                'credentials' => $credentials,
                'cloudPacket' => $cloudPacket,
            );
            //make API call
            $client = new IXR_Client($apiUrl);
            $client->debug = false;
            if (!$client->query($apiFunction, $params)) {
                $this->logMessage("IXR_Client error occurred - " . $client->getErrorCode() . ":" . $client->getErrorMessage(), null, 4);
            }
            //get response
            $result = $client->getResponse();

            return $result;
        } catch (Exception $exception) {
            $this->logMessage("Exception occured:" . $exception->getMessage(), null, 4);
            return $exception->getMessage();
        }
    }

    function http_post($url, $fields, $fields_string) {
        try {
////open connection
            $ch = curl_init($url);
//set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_MUTE,1);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//new options
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
//curl_setopt($ch, CURLOPT_CAINFO, REQUEST_SSL_CERTIFICATE);
//execute post
            $result = curl_exec($ch);
//close connection
            curl_close($ch);
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function call($url, $params) {
        error_reporting(E_ALL);
// get arguments
        $method = array_shift($params);
        $post = xmlrpc_encode_request($method, $params);
        $ch = curl_init();
// set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// issue the request
        $response = curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errorno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        return xmlrpc_decode($response);
    }

    function getRecipientNetworkID($msisdn) {
        if (preg_match($this->mtn_reg, $msisdn)) {
            return "MTN";
        } else if (preg_match($this->airtel_reg, $msisdn)) {
            return "AIRTEL";
        } else if (preg_match($this->orange_reg, $msisdn)) {
            return "ORANGE";
        } else if (preg_match($this->utl_reg, $msisdn)) {
            return "UTL";
        } else if (preg_match($this->warid_reg, $msisdn)) {
            return "WARID";
        } else {
            return "UNSupportedNetwork";
        }
    }

    function getAirtimeWalletMerchantCodes($msisdn) {
        if (preg_match($this->mtn_reg, $msisdn)) {
            return "MTNTOPUP";
        } else if (preg_match($this->airtel_reg, $msisdn)) {
            return "AIRTELTOPUP";
        } else if (preg_match($this->orange_reg, $msisdn)) {
            return "AFRCELTOPUP";
        } else if (preg_match($this->utl_reg, $msisdn)) {
            return "UTL";
        } else if (preg_match($this->warid_reg, $msisdn)) {
            return "AIRTELTOPUP";
        } else {
            return "NULL";
        }
    }

    function getProvider($networkID) {
        $providers = array(
            "64110" => "MTN",
            "64101" => "Airtel",
            "732125" => "Africell"
        );
        return $providers[$networkID];
    }

    function logMessage($message, $result = null, $logLevel = DTBUGconfigs::LOG_LEVEL_INFO) {
        if ($result != null) {
            CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message . print_r($result, true)), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
        } else {
            CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
        }
    }

}

$ncBankUSSD = new NCBANKUSSD;
echo $ncBankUSSD->navigate();
