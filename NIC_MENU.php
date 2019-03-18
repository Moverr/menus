<?php

/*
 * MTN UG Mula USSD Menu Payments
 * 
 * @author jennifer
 *
 */
error_reporting(0);
include 'DynamicMenuController.php';

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

//    http://132.147.160.57:8300/wallet/Cloud_APIs/authenticateCustomerPin
//    /authenticateCustomerPin

    function startPage() {

//        $this->init();
        $this->checkPin();
    }

    function init() {

        $fields_string = null;
        $fields = null;
// "MSISDN" => $this->_msisdn,
        $fields = array(
            "MSISDN" => '256783262929',
            "USERNAME" => "system-user",
            "PASSWORD" => "lipuka"
        );

        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        $response = $this->http_post($this->walletUrl, $fields, $fields_string);
        $clientProfile = json_decode($response, true);

        $this->saveSessionVar("clientProfile", $clientProfile);

        $this->firstMenu();
    }

    function firstMenu() {

        $clientProfile = $this->getSessionVar('clientProfile');

        if ($clientProfile['SUCCESS'] != 1) {

            $error = $clientProfile['ERRORS'];
            $this->displayText = $error;
            $this->sessionState = "END";
            $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        } else {

            $clientProfiledata = $this->populateClientProfile($clientProfile);
            $clientAccountDetails = $this->populateAccountDetails($clientProfile);

            $message = $message = "Hello " . ($clientProfiledata['customerNames']) . ", Welcome to NC Bank \n\n" . "Home Menu \n" . "1. Merchants \n" . "2. Balance Enquiry \n" . "3. Bill Payment \n" . "4. Funds Transfer \n" . "5. Bank to Mobile \n" . "6. Airtime Purchase \n" . "7. Mini statement \n" . "8. Cheque Requests \n" . "9. Change PIN \n";

            $this->displayText = $message;
            $this->sessionState = "CONTINUE";
            $this->serviceDescription = $this->SERVICE_DESCRIPTION;
            $this->nextFunction = "menuSwitcher";
            $this->previousPage = "startPage";
        }
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

                    $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                    $this->nextFunction = "BalanceEnquiryMenu";
                    $this->previousPage = "startPage";


                    break;


                case '3':
# code...
                    $this->BillPaymentsMenu();
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
# code...
                    $this->BankToMobileMenu();

                    break;



                case '7':
# code...
                    $this->MiniStatementMenu();
                    break;


                case '8':
# code...
                    $this->ChequeRequestMenu();
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

    public function call() {

        ini_set("display_error", 1);
        error_reporting(E_ALL);

// get arguments
        $params = func_get_args();
        $method = array_shift($params);

        $post = xmlrpc_encode_request($method, $params);

        /*
          $post = str_replace("\n", "", $post);
          $post = str_replace(" ", "", $post);
          echo $post;
         */

        $ch = curl_init();

// set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// issue the request
        $response = curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errorno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

// check for curl errors
        if ($curl_errorno != 0) {
            die("Curl ERROR: {$curl_errorno} - {$curl_error}n");
        }

// check for server errors
        if ($response_code != 200) {
            die("ERROR: non-200 response from server: {$response_code} - {$response}n");
        }
//    return $response;
//    $response .= 'e>';
        return xmlrpc_decode($response);
    }

    function checkPin() {

//        xmlrpc_server_call_method ( resource $server , string $xml , mixed $user_data [, array $output_options ] )

        $fields_string = null;
        $fields = null;
// "MSISDN" => $this->_msisdn,
        $fields = array(
            "MSISDN" => '256783262929',
            "PINHASH" => '1234',
            "USERNAME" => "system-user",
            "PASSWORD" => "lipuka"
        );

//        foreach ($fields as $key => $value) {
//            $fields_string .= $key . '=' . $value . '&';
//        }
//        rtrim($fields_string, '&');

         $message = "NBONO";
        try{

        $client = new XMLRPC_Client('http://132.147.160.57:8300/wallet/Cloud_APIs/index');
//        $response = $client->call('validatePIN', $fields);
         $message = "" . print_r($client);
        }catch(Exception $er){
            $message = "".print_r($er);
        }



        $message = "" . print_r($client);
        $this->displayText = $message;
    }

    function ServiceNotAvailable() {
        $message = "Service not available \n\n" . "0. Home \n" . "00. Back \n" . "000. Logout \n";
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

//todo: sprint one, Balance Inquiry
    function BalanceEnquiryMenu($input) {

        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');

        $message = "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "BalanceEnquiryMenu";
        $this->previousPage = "startPage";


        switch ($input) {
            case '0':
                break;

            case '00':
                break;
            case '000':

                break;
            default:
                $selectedAccount = null;
                foreach ($ACCOUNTS as $account) {
                    if ($account['ID'] == $input) {
                        $selectedAccount = $account;
                        break;
                    }
                }
                $message = "Account Number : " . $selectedAccount['ACCOUNTNUMBER'];
                $message .= "\nAccount Names : " . $selectedAccount['ACCOUNTNAME'];
                $message .= "\nAccount Balance : " . $selectedAccount['ACCOUNTBALANCE'] . ' ' . $selectedAccount['ACCOUNTCURRENCY'] . ' ';


                $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "BalanceEnquiryMenu";
                $this->previousPage = "startPage";

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

    function AirtimePurchaseMenu() {
        $this->serviceNotAvailable();
    }

    function MiniStatementMenu() {
        $this->serviceNotAvailable();
    }

    function ChequeRequestMenu() {
        $this->serviceNotAvailable();
    }

    function ChangePinMenu() {
        $this->serviceNotAvailable();
    }

    function PromptPin() {
        $message .= "Enter Pin to confirm \n0. Home \n" . "00. Back \n" . "000. Logout \n";
        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "menuSwitcher";
        $this->previousPage = "startPage";
    }

    function SignOutMenu() {
        
    }

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

}

$ncBankUSSD = new NCBANKUSSD;
echo $ncBankUSSD->navigate();
