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
//    http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php
        

//    http://132.147.160.57:8300/wallet/Cloud_APIs/authenticateCustomerPin
//    /authenticateCustomerPin

    function startPage() {

        $this->init();
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
            "PIN"=>1234
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



        $this->saveSessionVar("CLIENTPROFILE", $clientProfile);

        $this->firstMenu();
    }

    function firstMenu() {

        $clientProfile = $this->getSessionVar('CLIENTPROFILE');
        $this->displayText = "" . print_r($clientProfile, true);


        $clientProfiledata = $this->populateClientProfile($clientProfile);
        $clientAccountDetails = $this->populateAccountDetails($clientProfile);

        $this->displayText = "" . print_r($clientAccountDetails, true);





        /*
          if ($clientProfile['SUCCESS'] != 1) {

          $error = $clientProfile['ERRORS'];
          $this->displayText = $error;
          $this->sessionState = "END";
          $this->serviceDescription = $this->SERVICE_DESCRIPTION;
          } else {



          $clientProfiledata = $this->populateClientProfile($clientProfile);
          $clientAccountDetails = $this->populateAccountDetails($clientProfile);
         * 

          $message = $message = "Hello " . ($clientProfiledata['customerNames']) . ", Welcome to NC Bank \n\n" . "Home Menu \n" . "1. Merchants \n" . "2. Balance Enquiry \n" . "3. Bill Payment \n" . "4. Funds Transfer \n" . "5. Bank to Mobile \n" . "6. Airtime Purchase \n" . "7. Mini statement \n" . "8. Cheque Requests \n" . "9. Change PIN \n";

          $this->displayText = $message;

          $this->sessionState = "CONTINUE";
          $this->serviceDescription = $this->SERVICE_DESCRIPTION;
          $this->nextFunction = "menuSwitcher";
          $this->previousPage = "startPage";
          }
         */
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

                    $message = " Top Up"
                            . "\n1) Own Phone"
                            . "\n2) Other Phone";


                    $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

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




                    $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

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




                    $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

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

    public function call($url, $params) {


        error_reporting(E_ALL);

// get arguments

        $method = array_shift($params);

        $post = xmlrpc_encode_request($method, $params);

        /*
          $post = str_replace("\n", "", $post);
          $post = str_replace(" ", "", $post);
          echo $post;
         */

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

// check for curl errors
//        if ($curl_errorno != 0) {
//            die("Curl ERROR: {$curl_errorno} - {$curl_error}n");
//        }
//
//// check for server errors
//        if ($response_code != 200) {
//            die("ERROR: non-200 response from server: {$response_code} - {$response}n");
//        }
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
                $message = " Account Not Found";
                if ($selectedAccount != null) {
                    $message = "Account Number : " . $selectedAccount['ACCOUNTNUMBER'];
                    $message .= "\nAccount Names : " . $selectedAccount['ACCOUNTNAME'];
                    $message .= "\nAccount Balance : " . $selectedAccount['ACCOUNTBALANCE'] . ' ' . $selectedAccount['ACCOUNTCURRENCY'] . ' ';
                }


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

    //: MENU ITEM 6 AIRTIME PURCHASE 

    function TopUpAmountMenu($input) {


        $message = "1)MTN "
                . "\n2)Airtel"
                . "\n3)Africell"
                . "\n4)UTL"
                . "\n5)Smile";
        $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "AirtimeMerchantChooseAccount";
        $this->previousPage = "TopUpAmountMenu";
    }

    function finishBuyingAirtime($input) {
        $message = "Dear Customer, your airtime purchase request was failed. The reference NO. is #12891. For queries 0312388100/0312388155 or email"
                . " ncbankcustomercare@ncgroup.com.";


        $this->displayText = $message;
        $this->sessionState = "END";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
    }

    function AirtimeMerchantChooseAccount($input) {


        $ACCOUNTS = $this->getSessionVar('ACCOUNTS');


        $message = "Select Account"
                . "\n";

        if ($ACCOUNTS != null) {
            $message = "Choose Account ";
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
                $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

                $mssdn = "254779820962";
                $mssdnarray = explode("", $mssdn);


                //get the network id
                //$networkID = $this->getProvider($this->_networkID);


                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "AirtimeMerchantChooseAccount";
                $this->previousPage = "AirtimePurchaseMenu";

                break;
            case '2':
                $message = "Enter Top Up Amount";
                $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

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
                $selectedAccount = null;
//                foreach ($ACCOUNTS as $account) {
//                    if ($account['ID'] == $input) {
//                        $selectedAccount = $account;
//                        break;
//                    }
//                }
                $message = " Top Up"
                        . "\n.1 Own Phone"
                        . "\n.2 Other Phone";


                $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";

                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "AirtimePurchaseMenu";
                $this->previousPage = "startPage";

                break;
        }
    }

    //: MENU ITEM 7 MINI STATEMENT 

    function MiniStatementMenu() {
        $message = " Thank you for using NC mobile banking \n";


        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "MiniStatementMenu";
        $this->previousPage = "startPage";
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
                $this->nextFunction = "MiniStatementMenu";
                $this->previousPage = "startPage";



                break;

            case "2":

                $message = "From cheque number";


                $this->displayText = $message;
                $this->sessionState = "CONTINUE";
                $this->serviceDescription = $this->SERVICE_DESCRIPTION;
                $this->nextFunction = "ToChequeNumber";
                $this->previousPage = "startPage";


                break;


            default:
                break;
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

        $message = "Your transaction was successful #referece_idY";
        $message .= "\n\n0. Home \n" . "00. Back \n" . "000. Logout \n";


        $this->displayText = $message;
        $this->sessionState = "CONTINUE";
        $this->serviceDescription = $this->SERVICE_DESCRIPTION;
        $this->nextFunction = "menuSwitcher";
        $this->previousPage = "startPage";
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

class xmlrpc_client {

    private $url;

    function __construct($url, $autoload = true) {
        $this->url = $url;
        $this->connection = new curl;
        $this->methods = array();
        if ($autoload) {
            $resp = $this->call('system.listMethods', null);
            $this->methods = $resp;
        }
    }

    public function call($method, $params = null) {
        $post = xmlrpc_encode_request($method, $params);
        return xmlrpc_decode($this->connection->post($this->url, $post));
    }

    function getProvider($networkID) {
        $providers = array(
            "64110" => "MTN",
            "64101" => "Airtel",
            "732125" => "Africell"
        );
        return $providers[$networkID];
    }

}

$ncBankUSSD = new NCBANKUSSD;
echo $ncBankUSSD->navigate();
