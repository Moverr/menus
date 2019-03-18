
<?php

include 'DynamicMenuController.php';
include './DTBUGconfigs.php';

class UGDTBMobileBanking extends DynamicMenuController {

    private $BANK = "DTB - Uganda";

    /**
     * Wallet client ID
     */
    private $clientID = "";
// ===================ServiceID Variables ==============
    /*
     * DTB
     */
    private $serviceIDs = " ";
    private $agentServiceID = " ";
    private $OTPServiceID = 6;
    private $customerPinChangeServiceID = 7;
    private $CBSBEServiceID = 10;
    private $CBSMiniStatServiceID = 11;
    private $CBSFULLSTATServiceID = 12;
    private $CBSTOCBSFtServiceID = 13;
    private $INTERNALFTServiceID = 13;
    private $B2CMPESAServiceID = 14;
    private $RECEIVEMONEYServiceID = 14;
    private $BillPayServiceID = "BILL_PAY";
    private $NATIONHELAServiceD = 0;
    private $NAKUMATTGLOBALServiceD = 0;
    private $MICARDServiceD = 0;
    private $CHEQUEBOOKREQUESTServiceID = 15;
    private $CBSStopChequeServiceID = 16;
    private $CBSFOREXServiceID = 17;
    private $CBSSafaricomTopupServiceID = 19;
    private $VBBeServiceID = 20;
    private $AirtelTopupServiceID = 60;
    private $OrangeTopupServiceID = 61;
    private $YuTopupServiceID = 62;
    private $emailRegistrationsServiceID = 64;
    private $ABBeServiceID = 93;
    private $ABDepositServiceID = 34;
    private $ABOTPServiceID = 8;
// private $synchronousServices = array(10, 11, 12, 13,17);
    private $synchronousServices = array(10, 11, 13, 17, 18, 119, 'BILL_PAY');
// ===================Menus to Display=====================
    private $CBSservices = "1: Check Balance\n2: Move Money\n3: Buy Airtime\n4: Buy Data\n5: Pay Bill\n6: Query Services\n7: Pin Services\n8: MasterPass";
    private $merchantList = array('NWSC', 'UMEME'); // 'JamboJet', 'JamboPay');
    private $mnoMenuList = array('MTN', 'Airtel', 'Africell');
    private $forexCurrencies = "1: USD\n2: EUR\n3: GBP \n4: KES \n5: TZS";
// ===================ServiceID Variables End==============
    private $count = 0;
    private $num = 1;
    private $confirmatory = "You will receive a confirmatory message shortly.";
    private $enforceNumericPINS = true;
    private $validateBMobilePinInSession = false;
    private $CUSTOMERCARENO = "0722000000";
    private $Currency = "UGX";
//===============This is the URL to access the Wallet.======================
//  private $serverURL = 'http://localhost/wallet/Cloud_APIs/index';
//    private $walletUrl = 'http://localhost/wallet/IS_APIs/CustomerRegistration/fetchCustomerData';
    private $serverURL = 'http://10.254.12.9/UG/wallet/Cloud_APIs/index';
    private $walletUrl = 'http://10.254.12.9/UG/wallet/IS_APIs/CustomerRegistration/fetchCustomerData';
//==========These are the parameters to post data to wallet synchronously===
    private $process_request = 'processCloudRequest';
    private $accessPoint = '*202#';
    private $requestMode = 1;
    private $IMCID = 2;
    private $imcRequestID = 1;
    private $systemName = "DTB";
    private $walletusername = 'admin';
    private $walletpassword = 'admin';
// ======================Min $ Max Values===================================

    private $MINNominationAliasLength = 4;
    private $MAXNominationAliasLength = 15;
    private $MINPINLength = 4;
    private $MAXPINLength = 8;
    private $MIN = 1;
    private $accountLength = 10;

    /* This is the URL to access Bill Presentment */
    private $presentment = 'http://10.1.1.18/multichoiceBillPresentment/multichoice.php';
    private $beepPresentment = 'http://cypher/hub4/C360Beep/C360Server.php';
    private $hub4Presentment = 'http://localhost:9001/hub/services/paymentGateway/XML/index.php';
//validation configs
    private $hubJSONAPIUrl = "http://localhost:9001/hub/services/paymentGateway/JSON/index.php";
    private $hubValidationFunction = "BEEP.validateAccount";
    private $hubAuthSuccessCode = "131";
    private $hubValidationSuccessCode = "307";
    private $beepUsername = "nic_test_api_user";
    private $beepPassword = "nic_t3st_api_us3r";
//merchant configs
    private $umemeServiceID = '28';
    private $umemeServiceCode = 'UMEME';
    private $nwscServiceID = '27';
    private $nwscServiceCode = 'NWSC';
    private $kccaServiceID = '233';
    private $kccaServiceCode = 'KCCA';
    private $uraServiceID = '30';
    private $uraServiceCode = 'URA';
    private $nwscAreas = "Kampala,Jinja,Entebbe,Lugazi,Iganga,Kawuku,Kajjansi,Mukono,Others";
//----------Self Reg ------------------//
//  private $SelfRegServerUrl = 'http://localhost/SelfReg_APIs/SelfReg_Server.php';
//    private $SelfRegApiUrl = 'http://localhost/SelfReg/index.php/APIs/Default';
    private $SelfRegServerUrl = 'http://10.254.12.9/SelfReg_APIs/SelfReg_Server.php';
    private $SelfRegApiUrl = 'http://10.254.12.9/SelfReg/index.php/APIs/Default';

    /* This is the Bill Presentment Function */
    private $fetchAllBills = 'fetchAllCustomerBills';
    private $fetchAllBillsByAccount = '';
    private $fetchBillByMSISDN = 'BEEP.fetchInvoices';
    private $fetchBillByAccountNumber = 'BEEP.fetchInvoicesByAccount';
    private $hppt_post = "http_post";
    private $topupAmounts = array('500', '1000', '2000', '5000', '10000', '50000', 'Other Amount');
    private $pinStatuses = array('0', '1', '2', '3', '4', '5', '6', '7', '8');
//    private $whitelist = array('256787399351', '256781456492', '256704008959', '256706332913', '256701198978', '256701152796', '256700368828');


    private $panamaMinimum = 10;
    private $panamaMaximum = 50;
    private $panamaMtnServiceID = 754;
    private $panamaAirtelServiceID = 756;
    private $panamaOrangeServiceID = 755;
    private $phone_reg = "/^(25677|25678|25639|25671|25670|25675|25679|77|78|39|71|70|75|79|077|078|039|071|070|075|079)[0-9]{7}$/";
    private $mtn_reg = "/^(77|78|39|25677|25678|25639|077|078|039)(\d{7})$/";
    private $airtel_reg = "/^(075|25675|75|25670|70|070)(\d{7})$/";
    private $warid_reg = "/^(25670|70|070)(\d{7})$/";
    private $utl_reg = "/^(71|071|25671)(\d{7})$/";
    private $orange_reg = "/^(079|25679|79)(\d{7})$/";
    private $MAXFTTRANSFER = 100000;
    private $MINFTTRANSFER = 500;
    private $MINMPESATRANSFER = 3000;
    private $MAXMPESATRANSFER = 4000000;

    /**
     * payload params *
     */
    private $payload;

    function startPage($input = null) {
        $this->logMessage("User sent input:  ", $input, DTBUGconfigs::LOG_LEVEL_INFO);

        /*
          if(!in_array($this->_msisdn, $this->whitelist)){
          $this->displayText = "Mobile banking services will be available soon.";
          $this->sessionState = "END";
          return;
          }
         */

// Get profile and client profile details directly from wallet
        $clientProfileJson = $this->fetchCustomerData();
        $clientProfile = json_decode($clientProfileJson, true);
        $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
        $this->logMessage("DTB Customer Details: " . print_r($clientProfiledata, TRUE), NULL, DTBUGconfigs::LOG_LEVEL_INFO);
//        $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
        $clientprofileID = $clientProfiledata [0];
        $profileactive = $clientProfiledata [1];
        $customeractive = $clientProfiledata [1];
        $profile_pin_status = $clientProfiledata ['2'];
        $customerNames = $clientProfiledata [3];
        $customerNames .= (($clientProfiledata [4] == "NULL" || $clientProfiledata [4] == "") ? "" : " " . $clientProfiledata [4]);
        $lastPinChange = $clientProfiledata[7];

        $profileActiveStatus = $customeractive;
        $customerActiveStatus = $customeractive;

        $serviceList = "";
        $aliases = "";
        $this->saveSessionVar('lastPinChange', $lastPinChange);
        $this->saveSessionVar('accountDetails', $clientProfile ['accountDetails']);
        $this->saveSessionVar('enrolmentDetails', $clientProfile ['enrollmentDetails']);
        $this->saveSessionVar('d', $clientProfile ['nominationDetails']);
//$this->saveSessionVar ('clientID',$clientProfileID);
//Fetch the customers accounts and store them. They will be displayed later.
        $allAccountDetails = $this->getSessionVar("accountDetails");

        $accounts = "";
        $accountAlias = "";
        $accountCBSid = "";
        $countAccounts = 0;
        $accountIDs = "";
        $clientAccounts = "";

        $accountDetails = explode("#", $allAccountDetails);
        $storedAliases = array();
        $storedAccountNumbers = array();
        $storedAccountIDs = array();
        $clientAccountsCount = 0;
//For Each Account
        foreach ($accountDetails as $profileEnrolment) {
            $this->count++;
            $singleAccount = explode("|", $profileEnrolment);

            $accountCBSid = $singleAccount[0];
            $accountNumbers = $singleAccount[1];
            $storedAccountNumbers[] = $accountNumbers;
            $accountAlias = $singleAccount[2];
            $storedAliases[] = $accountAlias;
            $storedAccountIDs[] = $accountCBSid;
            $countAccounts++;
            $accountIDs .= $accountCBSid . "^";
            $accounts .= $this->num . "@" . $accountAlias . "!";
            $clientAccounts .= $countAccounts . ": " . $accountAlias . "\n";
            $this->num++;
            $clientAccountsCount++;
        }

        $this->saveSessionVar('clientAccounts', $clientAccounts);
        $this->saveSessionVar('storedAccountNumbers', $storedAccountNumbers);
        $this->saveSessionVar('storedAliases', $storedAliases);
        $this->saveSessionVar('storedAccountID', $storedAccountIDs);
        $this->saveSessionVar('clientAccountsCount', $clientAccountsCount);


//Added to check how many nominations of each type the customer has
        $nominations = array_filter(explode('#', $this->getSessionVar('nominationDetails')));
        $nominationCount = count($nominations);

        $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
        $enrolmentCount = count($enrolments);

        if ($enrolmentCount > 0) {
            $mpesaEnrolments = 0;
            $airtimeEnrolments = 0;
            $airtelMoneyEnrolments = 0;
            $vmpesaEnrolments = 0;
            for ($i = 0; $i < sizeof($enrolments); $i++) {
                $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                if ($enrolmentData[1] == "MPESA") {
                    $mpesaEnrolments++;
                } elseif ($enrolmentData[1] == "AIRTELMONEY") {
                    $airtelMoneyEnrolments++;
                } elseif ($enrolmentData[1] == "VODAMPESA") {
                    $vmpesaEnrolments++;
                } elseif ($enrolmentData[1] == "MTN_AIRTIME" || $enrolmentData[1] == "AIRTELTOPUP" || $enrolmentData[1] == "AFRICELL_AIRTIME" || $enrolmentData[1] == "ZANTELTOPUP") {
                    $airtimeEnrolments++;
                }
            }
            $this->saveSessionVar("mpesaEnrolments", $mpesaEnrolments);
            $this->saveSessionVar("airtimeEnrolments", $airtimeEnrolments);
            $this->saveSessionVar("airtelMoneyEnrolments", $airtelMoneyEnrolments);
            $this->saveSessionVar("vmpesaEnrolments", $vmpesaEnrolments);
        }

        if ($nominationCount > 0) {
            $cardNominations = 0;
            $iftNominations = 0;

            $nominatedAccounts = "";
            $nominatedAccountNumbers = array();
            $displayedAliases = array();
            for ($i = 0; $i < sizeof($nominations); $i++) {
                $nominationData = array_filter(explode("|", $nominations [$i]));
                if ($nominationData[6] == "CARD") {
                    $cardNominations++;
                } else if ($nominationData[6] == "IFT") {
                    $iftNominations++;
                }
            }
            $this->saveSessionVar("cardNominations", $cardNominations);
            $this->saveSessionVar("iftNominations", $iftNominations);
        }

//check if cutomer is registered for mobile banking
        if (!empty($clientprofileID) && in_array($profile_pin_status, $this->pinStatuses)) {

            $now = date("Y-m-d H:i:s");
            $diff = strtotime($now) - strtotime(date($lastPinChange));
            $this->logMessage("Pin last change date {$lastPinChange} and today is {$now} difference: ", $diff, DTBUGconfigs::LOG_LEVEL_INFO);
            $diff2 = floor($diff / 3600 / 24);
            $this->logMessage("Test2 last change date {$lastPinChange} and today is {$now} difference: ", $diff2, DTBUGconfigs::LOG_LEVEL_INFO);

#check if user has expired OTP
            if ($profile_pin_status == 6 or ( $profile_pin_status == 2 && $diff > DTBUGconfigs::PIN_EXPIRE_TIME)) {
                $this->logMessage("User OTP expired: ", $profile_pin_status, DTBUGconfigs::LOG_LEVEL_INFO);
                $this->displayText = "Dear $customerNames, your One Time PIN has expired, please enter account number to reset your PIN:";
                $this->nextFunction = "OTP_Expired";
                $this->previousPage = "activation_pin_input_process";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar('otplevel', 'accountNumber');
            } else if ($profile_pin_status == 2 && $diff <= DTBUGconfigs::PIN_EXPIRE_TIME) {
                $this->displayText = "Dear $customerNames, you need to set your PIN, please enter your one time PIN ";
                $this->nextFunction = "OTP_Expired";
//                $this->previousPage = "activation_pin_input_process";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "currentPIN";
                $this->saveSessionVar('otplevel', 'newPin');
            } else if ($profile_pin_status == 3 or $profile_pin_status == 4) {
                $this->displayText = "Dear $customerNames,your account is currently locked. Please a nearest {$this->BANK} branch";
                $this->sessionState = "END";
            } else {
//Split the input to check if its a one click request
                $newAccessPoint = json_decode($this->_requestPayload, true);
                $this->logMessage("Request Data " . $newAccessPoint['ACCESSPOINT'], $this->_accessPoint, DTBUGconfigs::LOG_LEVEL_INFO);
                $this->logMessage("AccessPoint sent " . $this->_responsePayload->ACCESSPOINT, $this->_accessPoint, DTBUGconfigs::LOG_LEVEL_INFO);
                $getDial = explode('*', $newAccessPoint['ACCESSPOINT']);
                $inputLength = count($getDial);
                $this->logMessage("AccessPoint param length " . $inputLength, $inputLength, DTBUGconfigs::LOG_LEVEL_INFO);
                if ($inputLength >= DTBUGconfigs::PANAMA_REQ_PARAM_NUM) {
                    if ($inputLength == DTBUGconfigs::PANAMA_REQ_PARAM_NUM) {
                        $this->logMessage("OneClick Request to own number ", $this->_msisdn, DTBUGconfigs::LOG_LEVEL_INFO);
                        $amount = rtrim($getDial[3], "#");

                        if (is_numeric($amount) && $amount < 10) {
                            $this->logMessage("Onclick by mistake...Show menu instead ", $this->_msisdn, DTBUGconfigs::LOG_LEVEL_INFO);
                            $this->displayText = "Welcome to DTB Mobile. Please select a service.\n" . $this->CBSservices;
                            $this->saveSessionVar("profileID", $clientprofileID);
                            $this->sessionState = "CONTINUE";
                            $this->nextFunction = "processRequest";
                        } else {
                            $this->panamaHome($amount, $this->_msisdn);
                        }
                    } else {
                        $amount = $getDial[3];
                        $phoneNumber = rtrim($getDial[4], "#");
                        $this->logMessage("OneClick Request to Other number ", $phoneNumber, DTBUGconfigs::LOG_LEVEL_INFO);
                        $this->panamaHome($amount, $phoneNumber);
                    }

//                    $this->displayText = "Dear $customerNames,this is a panama request amount {$amount}";
//                    $this->sessionState = "END";
                } else {
                    $this->logMessage("Displaying user main menu... ", $profile_pin_status, DTBUGconfigs::LOG_LEVEL_INFO);
                    $this->displayText = "Welcome to DTB Mobile. Please select a service.\n" . $this->CBSservices;
                    $this->saveSessionVar("profileID", $clientprofileID);
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processRequest";
                }
            }
        } else if (empty($clientprofileID)) {
            $message = "DTB Mobile lets you check balance,move money from your acc to mobile money and more. Please select an option\n1.Register\n0. Go to exit";
            $this->displayText = $message;
            $this->saveSessionVar("customer_number", $this->_msisdn);
            $this->saveSessionVar("Reglevel", "Questions");
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "customer_self_register";
        }
    }

    /*
     * Process Main menu
     */

    function processSelectedBankingService() {
        $service = $this->getSessionVar('selectedService');
        $this->previousPage = "selectBankingService";

        switch ($service) {
            case 1 :
                $clientAccounts = $this->getSessionVar('clientAccounts');
                $accountIDs = $this->getSessionVar('storedAccountID');

                $this->displayText = "Select account:\n" . $clientAccounts;
                $this->saveSessionVar('vanillaService', 'checkBalance');
                $this->saveSessionVar('serviceID', '10');
                $this->saveSessionVar('amount', '0');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "validateAccountDetails";

                break;

            case 2 :
                $sid = $this->getSessionVar('serviceID');
                $this->displayText = "Send money:\n1: MTN Mobile Money\n2: DTB Account\n3: RTGS \n4: VSLA bank to wallet";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "selectBankingService";
                $this->nextFunction = "processSendMoney";
                break;

            case 3 :

                $this->saveSessionVar("billEnrolment", "NO");
                $this->saveSessionVar("billEnrolmentNumber", "NULL");
                $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
                $this->saveSessionVar('serviceID', 'BILL_PAY');
                $this->saveSessionVar('flavour', 'open');
                $airtimeNoms = $this->getSessionVar('airtimeEnrolments');

                if ($airtimeNoms == 0) {

                    $this->displayText = "Airtime Top up:\n1: My Phone\n2: Other Phone";
//$this->saveSessionVar('serviceID', '19');
                    $this->saveSessionVar('flavour', 'open');
                    $this->saveSessionVar('serviceID', 'BILL_PAY');
                    $this->saveSessionVar("billEnrolment", "NO");
                    $this->saveSessionVar("billEnrolmentNumber", "NULL");
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAirtime";
                } else {
                    $enroledAccounts = "";
                    $enroledAccountNumbers = array();
                    $displayedAliases = array();
                    $counter = 0;
                    $num = 1;
                    $count = 0;
                    $aliases = "";
                    for ($i = 0; $i < sizeof($enrolments); $i++) {
                        $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                        if ($enrolmentData[1] == "MTN_AIRTIME" || $enrolmentData[1] == "AIRTELTOPUP" ||
                                $enrolmentData[1] == "AFRICELL_AIRTIME" || $enrolmentData[1] == "TIGOTOPUP" ||
                                $enrolmentData[1] == "ZANTELTOPUP") {
                            $enroledAccountNumbers[$counter] = $enrolmentData['1'];

                            $num++;
                            $enroledAccounts .= $num . ": " . $enrolmentData ['0'] . "\n";
                            $count++;

                            $aliases .= $enrolmentData ['0'] . "^";
                            $displayedAliases[] = $enrolmentData ['0'];
                            $counter++;
                        }
                    }
                    $num++;
                    $count++;

                    $enroledAccounts .= $num . ": Other";

//  $menu = "Select Account to transfer to:\n1. My number\n $enroledAccounts";
                    $menu = "Select airtime beneficiary:\n1. My number\n $enroledAccounts";
                    $this->displayText = $menu;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processSendMoney";
                    $this->previousPage = "enrolmentPromptAirtime";
                    $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                    $this->saveSessionVar("availableAliases", $displayedAliases);
                    $this->saveSessionVar("mpesaTo", "nomination");
                    $this->saveSessionVar("storedAccountNumbers", $enroledAccountNumbers);
                }

                break;

//  data service
            case 4 :
                $this->saveSessionVar('serviceID', 'BILL_PAY'); //fix me
                $this->saveSessionVar('flavour', 'open');
                $this->displayText = "Data Top up:\n1: AFRICELL";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "selectDataNetwork";
                break;


            case 5 :
                $this->processPayBill($input);
                break;

            case 6 :
// Query services. Done
                $this->displayText = "Please select a service:\n1. Ministatement\n2. Cheque book ordering\n
                3. Stop cheque\n4. Cheque status\n5. Forex rates ";
                $this->saveSessionVar('amount', '0');
                $this->saveSessionVar('vanillaService', 'ministatement');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processVanillaServices";
                break;

            case 7 :
// Change PIN. Done.
                $this->displayText = "Please select a service:\n1. Change PIN";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "pinServices";
                $this->saveSessionVar("pinServices", "changePIN");
                break;
            case 8 :
// MasterPass.
                $this->saveSessionVar('mcLevel', 'home');
                $this->BuyMasterPass(0);
                break;

            /*         case 8 :
              // Change language

              break;
              } */
            default :
//                $this->displayText = "Invalid seletion. Please select: \n" . $this->CBSservices;
//                $this->sessionState = "CONTINUE";
//                $this->nextFunction = "processSelectedBankingService";
                $this->displayText = "Oneclick under implementation. Thank you";
                $this->sessionState = "END";
                $this->nextFunction = "customer_one_click";

                break;
        }
    }

    function OTP_Expired($input) {

        $otplevel = $this->getSessionVar('otplevel');

        if ($otplevel == 'accountNumber') {
//Add steps for getting all the other asked questions
            if (!empty($input) && ( $input != "")) {
                $this->displayText = "Please enter your account name:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'accountName');
                $this->saveSessionVar('accountNumber', $input);
            } else {
                $this->displayText = "Invalid input! \nPlease enter account number to reset your PIN";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'accountNumber');
            }
        } else if ($otplevel == 'accountName') {
            if (!empty($input) && ( $input != "")) {
                $this->displayText = "Please enter your date of birth in the format 'day/month/year':";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'dob');
                $this->saveSessionVar('accountName', $input);
            } else {
                $this->displayText = "Invalid input! \nPlease enter your account name:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'accountNumber');
            }
        } else if ($otplevel == 'dob') {

            if (!empty($input) && ( $input != "")) {
                $this->saveSessionVar('dob', $input);
                $accountNumber = $this->getSessionVar("accountNumber");
                $accountName = $this->getSessionVar("accountName");
                $dob = $input;

//Call service which validates the user information to proceed with the pin reset

                $payloadarray = array(
                    "serviceID" => DTBUGconfigs::ACCOUNT_DETAIL_VAL_SERVICE_ID,
                    "flavour" => "noFlavour",
                    "pin" => "XXXX",
                    "columnA" => DTBUGconfigs::QUESTIONNUMBER,
                    "columnB" => $accountNumber,
                    "columnC" => $input,
                    "columnD" => $accountName,
                );

                // log request into channelRequests
                $successLog = $this->logChannelRequest($payloadarray, 1);
                $this->logMessage("Response from channel Request log: ", $successLog, DTBUGconfigs::LOG_LEVEL_INFO);
                if ($successLog['SUCCESS'] == TRUE) {

                    // send payload to system and get response

                    $processOTP = $this->synchronousProcessing($payloadarray, $successLog['DATA']);
                    $this->logMessage("SyncProcessing result: ", $processOTP, DTBUGconfigs::LOG_LEVEL_INFO);
                    // $this->toFile("reset pin response....." . json_encode($processOTP));

                    if ($processOTP['DATA']['STATUS_CODE'] == DTBUGconfigs::LOG_SUCCESS_CODE) {

                        $this->displayText = "Please enter your new OTP";
                        $this->nextFunction = "OTP_Expired";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "currentPIN";
                        $this->saveSessionVar('otplevel', 'newPin');
                    } else if ($processOTP['DATA']['STATUS_CODE'] == 4) {
                        $this->displayText = $processOTP['DATA']['MESSAGE'];
                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "OTP_Expired";
                        $this->saveSessionVar('otplevel', 'accountNumber');
                    }
                } else {
                    $this->displayText = "Sorry, an error occured when processing your request.";
                    $this->sessionState = "END";
                }
            } else {
                $this->displayText = "Invalid input \nPlease enter your date of birth in the format 'day/month/year':";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'dob');
            }
        } elseif ($otplevel == 'newPin') {
            if (isset($this->previousPage) && $this->previousPage == "currentPIN") {
                $pinLength = strlen($input);
                if ($pinLength < $this->MINPINLength or $pinLength > $this->MAXPINLength) {
// pin not of allowed length
                    $this->displayText = "Invalid entry. PIN should be between $this->MINPINLength and $this->MAXPINLength characters. 
                Please enter your PIN:";
                    $this->nextFunction = "OTP_Expired";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('otplevel', "newPin");
                } elseif (!is_numeric($input) and $this->enforceNumericPINS) {
// pin not numeric
                    $this->displayText = "Invalid entry. Only numerical PINs allowed. Please enter your PIN:";
                    $this->nextFunction = "OTP_Expired";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('otplevel', "newPin");
                } else {
                    $this->saveSessionVar('oldpin', $input);
                    $this->displayText = "Please enter your new PIN:";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "OTP_Expired";
                    $this->saveSessionVar('otplevel', 'confirmPin');
                }
            } else {
                $this->displayText = "Please enter your new PIN:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'confirmPin');
            }
        } elseif ($otplevel == 'confirmPin') {
            $this->displayText = "Please re-enter your new PIN:";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "OTP_Expired";
            $this->saveSessionVar('otplevel', 'finalize');
            $this->saveSessionVar('otpnewpin', $input);
        } elseif ($otplevel == 'finalize') {
            if (($this->getSessionVar('otpnewpin')) != $input) {
                $this->displayText = "Pins do not match. please re-enter your new pin";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "OTP_Expired";
                $this->saveSessionVar('otplevel', 'confirmPin');
            } else {
                $this->logMessage("Processing the new PIN", NULL, DTBUGconfigs::LOG_LEVEL_INFO);
                $oldpinPlain = null !== $this->getSessionVar('oldpin') ? $this->getSessionVar('oldpin') : DTBUGconfigs::DEFAULT_PIN;
                $oldpin = $this->encryptPin($oldpinPlain, 1);
                $newpinPlain = $this->getSessionVar('otpnewpin');
                $newpin = $this->encryptPin($newpinPlain, 1);
                $payloadarray = array(
                    "serviceID" => DTBUGconfigs::PIN_SERVICE_ID,
                    "flavour" => "noFlavour",
                    "pin" => $oldpin,
                    "newPin" => $newpin,
                );

                $statusCode = 1;
                $this->_externalSystemServiceID = 6;

// log request into channelRequests
                $successLog = $this->logChannelRequest($payloadarray, $statusCode);
                $this->logMessage("Response from  final channel Request: ", $successLog, DTBUGconfigs::LOG_LEVEL_INFO);
                if ($successLog['SUCCESS'] == TRUE) {

// send payload to system and get response
                    $processOTP = $this->synchronousProcessing($payloadarray, $successLog['DATA']);
                    $this->logMessage("Response final SynchRequest: ", $processOTP, DTBUGconfigs::LOG_LEVEL_INFO);

                    if ($processOTP['DATA']['STATUS_CODE'] == 1) {
                        $this->displayText = "Your pin has been changed successfully. Thanks you for banking with us!";
                        $this->sessionState = "END";
                        $this->nextFunction = "processRequest";
                    } else
                    if ($processOTP['DATA']['STATUS_CODE'] == 4) {
                        $this->displayText = $processOTP['DATA']['MESSAGE'];
                        $this->sessionState = "END";
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request.";
                        $this->sessionState = "END";
                    }
                } else {
                    $this->displayText = "Sorry, an error occured when processing your request.";
                    $this->sessionState = "END";
                }
            }
        }
    }

    function BE_Mobile_ProcessOTP($input) {
        /**
         * hack for double safaricom shortcut invocation - Bug*
         */
        if ($input == "13") {
            $this->startPage();
        } else {
            if ($this->previousPage == "activation_pin_input_process") {

                $pinLength = strlen($input);
                if ($pinLength < $this->MINPINLength or $pinLength > $this->MAXPINLength) {
                    $this->displayText = "Invalid entry\nPIN should be between $this->MINPINLength and $this->MAXPINLength 
                    characters. Please reply with your One Time PIN:";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "activation_pin_input_process";
                } elseif (!is_numeric($input) and $this->enforceNumericPINS) {
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "activation_pin_input_process";
                    $this->displayText = "Invalid entry\nOnly numerical PINs allowed. Please reply with your One Time PIN:";
                    $this->saveSessionVar('extra', $this->getSessionVar('extra'));
                } else {
                    $this->displayText = "Please enter your new PIN:";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "process_new_pin";
                    $this->saveSessionVar("OTP", $input);
                    $this->saveSessionVar('pinencryptionID', $this->generatePinEncryptionID($this->getSessionVar('pinencryptionID')));
                    $encryptedpin = $this->encryptPin($input, 1);
                    $this->saveSessionVar('old_encryptedPin', $encryptedpin);
                }
            } else if ($this->previousPage == "process_new_pin") {
// check for pin length
                $pinLength = strlen($input);
                if ($pinLength < $this->MINPINLength or $pinLength > $this->MAXPINLength) {
                    $this->displayText = "Invalid entry\nPIN should be between $this->MINPINLength and $this->MAXPINLength 
                    characters. Please reply with your new PIN:";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "process_new_pin";
                    $this->sessionState = "CONTINUE";
                } elseif (!is_numeric($input) and $this->enforceNumericPINS) {
                    $this->displayText = "Only numerical PINs allowed.\nPlease reply with your new PIN:";
                    $this->saveSessionVar('extra', $this->getSessionVar('extra'));
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "process_new_pin";
                    $this->sessionState = "CONTINUE";
                } else {
                    $this->displayText = "Please re-enter your new PIN:";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "finalize_otp";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('new_pin', $input);
                }
            } else if ($this->previousPage == "finalize_otp") { // 30
                if (($this->getSessionVar('new_pin')) != $input) {
                    $this->displayText = "Pins do not match. Kindly re- enter your new pin";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "process_new_pin";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                } else {
//                    $value = 0;
//                    // forced decrypt pin @todo... return funtions
//                    if ($value == 0) {

                    $oldpin = $this->getSessionVar('old_encryptedPin');
                    $newpin = $this->getSessionVar('new_pin');
                    $newpin = $this->encryptPin($newpin, 1);

                    $payloadarray = array(
                        "serviceID" => $this->OTPServiceID,
                        "flavour" => "noFlavour",
                        "pin" => $oldpin,
                        "newPin" => $newpin
                    );

                    $statusCode = 1;
                    $this->_externalSystemServiceID = 6;
                    // log request into channelRequests
                    $successLog = $this->logChannelRequest($payloadarray, $statusCode);

                    if ($successLog ['SUCCESS'] == TRUE) {
                        // send payload to system and get response

                        $processOTP = $this->synchronousProcessing($payloadarray, $successLog['DATA']);

                        if ($processOTP['DATA']['STATUS_CODE'] == 1) {
                            $this->displayText = $processOTP['DATA']['MESSAGE'];
                            $this->sessionState = "END";
                        } else if ($processOTP['DATA']['STATUS_CODE'] == 4) {
                            $this->displayText = $processOTP['DATA']['MESSAGE'];
                            $this->sessionState = "END";
                        } else {
                            $this->displayText = "Sorry, an error occured when processing your request.";
                            $this->sessionState = "END";
                        }
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request.";
                        $this->sessionState = "END";
                    }
                }
            }
        }
    }

    function validatePin($input) {
// check pin Length
        $pinLength = strlen($input);
        $pin = $input;
        if ($pinLength < $this->MINPINLength or $pinLength > $this->MAXPINLength) {
// pin not of allowed length
            $this->displayText = "Invalid entry. PIN should be between $this->MINPINLength and $this->MAXPINLength characters. Please enter your PIN:";
            $this->nextFunction = "validatePin";
            $this->sessionState = "CONTINUE";
            $this->saveSessionVar('extra', $this->getSessionVar('extra'));
        } elseif (!is_numeric($input) and $this->enforceNumericPINS) {
// pin not numeric
            $this->displayText = "Invalid entry. Only numerical PINs allowed. Please enter your PIN:";
            $this->nextFunction = "validatePin";
            $this->sessionState = "CONTINUE";
            $this->saveSessionVar('extra', $this->getSessionVar('extra'));
        } else {
// $this->displayText = "Inside the else >> pin";
            if ($this->validateBMobilePinInSession) {
// validate customer pin
                $pinStatus = $this->validateCustomerPin($input);
            } else {
// $this->displayText = "validateBMobilePinInSession is NULL";
                $pinStatus = NULL;
            }

            if ((!$pinStatus or ! isset($pinStatus ['STAT_CODE']) or ! isset($pinStatus ['STAT_TYPE'])) and $this->validateBMobilePinInSession) {
// $this->displayText = "!pinSatus or !isset";

                $this->displayText = "Dear customer, there was a problem when validating your pin. Please try again later.";

                $this->sessionState = "END";
            } elseif ($pinStatus ['STAT_CODE'] == 100 and $pinStatus ['STAT_TYPE'] == 4) {
// $this->displayText ="statCode=100:statType=4";
// customer entered wrong pin.. profile not yet locked

                $retries = $this->getSessionVar('pinRetries');

                if (!is_numeric($retries)) {
                    $retries = 1;
                }

                $retryText = "\nNumber of Wrong Pin Trials: $retries";

                $this->displayText = "You have entered a wrong PIN. Please try again.$retryText ";
                $this->saveSessionVar('extra', $this->getSessionVar('extra'));
                $this->sessionState = "";
                $this->nextFunction = "validatePin";

// increment the number of retries
                $this->saveSessionVar('pinRetries', $retries + 1);
            } elseif ($pinStatus ['STAT_CODE'] == 279 and $pinStatus ['STAT_TYPE'] == 4) {
// $this->displayText ="statCode=279:statType=4";
// profile has been locked after max pin retries
                $this->displayText = "Dear Customer, your Mobile Number has been deactivated after exceeding maximum allowed 
                wrong pin retries. Please call Customer Care on $this->CUSTOMERCARENO to have your pin reset.";
                $this->sessionState = "END";
            } elseif ($pinStatus ['STAT_CODE'] == 286 and $pinStatus ['STAT_TYPE'] == 4) {
// $this->displayText ="statCode=286:statType=4";
// profile is already locked after max pin retries
                $this->displayText = "Dear Customer, your Mobile Number was  locked after too many wrong pin retries. 
                Please call Customer Care on $this->CUSTOMERCARENO to have your pin reset.";
                $this->sessionState = "END";
            } elseif ($pinStatus ['STAT_CODE'] == 1 and $pinStatus ['STAT_TYPE'] == 1 or ! $this->validateBMobilePinInSession) {
// $this->displayText ="statCode=1:statType=1";
// customer pin authenticated or ussd inline validation not enabled
                if ($this->getSessionVar('extra') == "changePIN") {
//  $this->displayText = "trying to change pin";
                    $this->displayText = "Please enter your new DTB mobile PIN:";
                    $this->nextFunction = "newPIN";
                    $this->sessionState = "CONTINUE"; //$encryptedpin = $this->encryptPin ( $pin, 1 );
                    $this->saveSessionVar('encryptedpin', $this->encryptPin($input, 1));
                } else {
// Mobile Banking Services
// $this->displayText = "Please select an option\n$this->CBSservices";
// $this->displayText = "just about to finalize";
                    $origin = $this->getSessionVar('origin');

// $this->displayText = "clientProfileID is $clientprofileID. "; */
                    $clientProfileJson = $this->fetchCustomerData();
                    $clientProfile = json_decode($clientProfileJson, true);
                    $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
                    $clientprofileID = $clientProfiledata [0];
                    $profileactive = $clientProfiledata [1];
                    $customeractive = $clientProfiledata [1];
                    $profile_pin_status = $clientProfiledata ['2'];
                    $customerNames = $clientProfiledata [3];
                    $customerNames .= (($clientProfiledata [4] == "NULL" || $clientProfiledata [4] == "") ? "" : " " . $clientProfiledata [4]);

                    $profileActiveStatus = $customeractive;
                    $customerActiveStatus = $customeractive;

                    $serviceList = "";
                    $aliases = "";
                    $this->saveSessionVar('accountDetails', $clientProfile ['accountDetails']);
                    $this->saveSessionVar('enrolmentDetails', $clientProfile ['enrollmentDetails']);
                    $this->saveSessionVar('nominationDetails', $clientProfile ['nominationDetails']);


                    if ($clientprofileID != 0) {

                        if ($profile_pin_status == 2) {
// customer presented with prompt to change one time pin
                            $this->displayText = "Dear $customerNames, please enter your One Time PIN:";
                            $this->nextFunction = "BE_Mobile_ProcessOTP";
                            $this->previousPage = "activation_pin_input_process";
                        } elseif ($profile_pin_status == 1 and $profileActiveStatus == 1 and $customerActiveStatus == 1) {
                            $this->displayText = "Welcome $customerNames to $this->BANK. Please enter your PIN:";
                            $this->sessionState = "CONTINUE";
                            $this->nextFunction = "validatePin";
                            if ($origin == "receiveMoney") {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalizeReceiveMoney";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } elseif ($origin == "billPayment") {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } elseif ($origin == 'tigoPesaToSelf') {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('serviceID', '82');
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } elseif ($origin == 'airtelMoneyToSelf') {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('serviceID', '84');
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } elseif ($origin == 'vmpesaToSelf') {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('serviceID', '119');
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } elseif ($origin == 'masterpass') {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('serviceID', '126');
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            } else {
                                $encryptedpin = $this->encryptPin($pin, 1);
                                $this->saveSessionVar('encryptedPin', $encryptedpin);
// @todo pass encrypted pin here
                                $this->nextFunction = "finalize";
                                $this->sessionState = "CONTINUE";
                                $this->navigate();
                            }
                        } elseif ($customerActiveStatus != 1) {
// Customer is not active
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your Mobile Banking Service.";
                            $this->sessionState = "END";
                        } elseif ($profileActiveStatus != 1) {
// customer is not active
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your Mobile Number 
                            for Mbanking Service.";
                            $this->sessionState = "END";
                        } else {
// Otp status not known to this menu
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your account";
                            $this->sessionState = "END";
                        }
                    } else {
// not registered for mobile banking
//$this->displayText = "Dear Customer, Please visit your nearest $this->BANK branch to register for mobile banking";
                        $this->displayText = "This service is currently unavailable.";
                        $this->sessionState = "END";
                    }
                }
            } else {
// The response status code returned by wallet is not understood by this application

                $this->displayText = "Error USSD err 102";
                $this->sessionState = "END";
            }
        }
    }

    function rtgsItems() {
        $rtgsCards = array(
            1 => array('BARCLAYS BANK', 'barclays', 'BARCUGKX'),
            2 => array('BANK OF BARODA', 'bank of baroda', 'BARBUGKA'),
            3 => array('STANBIC BANK', 'stanbic', 'SBICUGKX'),
            4 => array('DFCU BANK', 'DFCU bank', 'DFCUUGKA'),
            5 => array('TROPICAL AFRICA BANK', 'Tropical Africa ', 'TROAUGKA'),
            6 => array('STANDARD CHARTERED BANK', 'Standard chartered', ' SCBLUGKA'),
            7 => array('ORIENT BANK', 'orient', 'ORINUGKA'),
            8 => array('BANK OF AFRICA', 'Bank of Africa', 'AFRIUGKA'),
            9 => array('CENTENARY RURAL DEVELOPMENT BANK', 'centenary', 'CERBUGKA'),
            10 => array('CRANE BANK', 'crane bank', 'CRANUGKA'),
            11 => array('CAIRO INTERNATIONAL BANK', 'cairo international', 'CAIEUGKA'),
            12 => array('DIAMOND TRUST BANK', 'DTB', 'DTKEUGKA'),
            13 => array('CITI BANK', 'CITI bank', 'CITIUGKA'),
            14 => array('HOUSING FINANCE BANK LTD', 'Housing Finance', 'HFINUGKA'),
            15 => array('GLOBAL TRUST BANK', 'Global Trust Bank', 'GLTBUGKA'),
            16 => array('KENYA COMMERCIAL BANK', 'KCB', 'KCBLUGKA'),
            17 => array('UNITED BANK FOR AFRICA', 'United Bank For Africa', 'UNAFUGKA'),
            18 => array('GUARANTY TRUST BANK', 'Guaranty Trust Bank', 'GTBIUGKA'),
            19 => array('ECOBANK', 'Ecobank', 'ECOCUGKA'),
            20 => array('EQUITY BANK', 'Equity bank', 'EQBLUGKA'),
            21 => array('ABC BANK LTD', 'ABC bank', 'ABCFUGKA'),
            22 => array('IMPERIAL BANK UGANDA LTD', 'Imperial Bank UG', 'IMPLUGKA'),
            23 => array('BANK OF INDIA', 'Bank Of India', 'BKIDUGKA'),
            24 => array('NC BANK', 'NC bank', 'NINCUGKA'),
            25 => array('COMMERCIAL BANK FOR AFRICA', 'Commerical Bank Of Africa', 'CBAFUGKA'),
            26 => array('FINANCE TRUST BANK', 'Finance Trust bank', 'FTBLUGKA'),
            27 => array('POSTBANK UGANDA LTD', 'Postbank', 'UGPBUGKA'),
            28 => array('BANK OF UGANDA', 'Bank of Uganda', 'UGBAUGKA')
        );
        return $rtgsCards;
    }

    function selectBankAccount($input) {
        $allAccountDetails = $this->getSessionVar("accountDetails");

        $accounts = "";
        $accountAlias = "";
        $accountCBSid = "";
        $countAccounts = 0;
        $accountIDs = "";
        $clientAccounts = "";

        $accountDetails = explode("#", $allAccountDetails);
        $storedAliases = array();
//$storedAccountNumbers = array();
//For Each Account
        foreach ($accountDetails as $profileEnrolment) {
            $this->count++;

            $singleAccount = explode("|", $profileEnrolment);

            $accountCBSid = $singleAccount[0];
            $accountNumbers = $singleAccount[1];
//          $storedAccountNumbers[] = $accountNumbers;
            $accountAlias = $singleAccount[2];
            $storedAliases[] = $accountAlias;

            $countAccounts++;
            $accountIDs .= $accountCBSid . "^";
            $accounts .= $this->num . "@" . $accountAlias . "!";
            $clientAccounts .= $countAccounts . ": " . $accountAlias . "\n";
            $this->num++;
        }

        if ($input == "" or $input == 0 or ! is_numeric($input)) {
            $this->displayText = "Wrong selection. Services Menu:\n$this->CBSservices";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "selectBankAccount";
        } else {
            $this->displayText = "Select Account:\n$clientAccounts";
            $this->saveSessionVar('verifyAccounts', $accountIDs . "*" . $accounts);
            $this->saveSessionVar('selectedService', $input);
            $this->saveSessionVar('extra', $clientAccounts);
//        $this->saveSessionVar('storedAccountNumbers', $storedAccountNumbers);
            $this->saveSessionVar('storedAliases', $storedAliases);
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        }
    }

    function validateAccountDetails($input) {
//$countAccounts = sizeof($this->getSessionVar('storedAccountNumbers'));
        $accounts = $this->getSessionVar('clientAccounts');
        $countAccounts = $this->getSessionVar('clientAccountsCount');
        if ($input < 1 || $input > $countAccounts) {
            $clientAccounts = $this->getSessionVar('clientAccounts');
            $accountIDs = $this->getSessionVar('storedAccountID');

            $this->displayText = "Invalid selection. \n$clientAccounts";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } else {
            $availableAliases = $this->getSessionVar('availableAliases');
            $customerAliases = $this->getSessionVar('storedAliases');
            $bankBranches = $this->getSessionVar('branches');
//$this->saveSessionVar('branchCode', $bankBranches[$input-1]);
            $this->saveSessionVar('alias', $customerAliases[$input - 1]);
            $customerAccounts = $this->getSessionVar('storedAccountNumbers');
            $accountIDs = $this->getSessionVar('storedAccountID');
            $this->saveSessionVar('accountID', $accountIDs[$input - 1]);
            $isNomination = $this->getSessionVar('isNomination');
            $acc = $customerAccounts[$input - 1];
            $sampleBranch = $this->getSessionVar('branchCode');
            $branchcode = $this->getSessionVar('branchid');
            $this->saveSessionVar('branchCode', $branchcode);
            if ($isNomination != 'no') {
//$this->saveSessionVar('selectedAccountNumber', $customerAccounts[$input - 1]);
//  $this->saveSessionVar('selectedAccountNumber', $availableAliases[$input - 1]);
                $this->saveSessionVar('nominationAlias', $customerAliases[$input - 1]);
                $this->saveSessionVar('branchCode', $bankBranches[$input - 1]);
            }

            $this->displayText = "Please enter your PIN:";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validatePin";
        }
    }

    function finalize() {
        /*
         * <Payload><serviceID>14</serviceID><flavour>self</flavour> <pin>8169ef2deb269557335fd9c9bd209c230f3801570564c37495863f7c7cd9be15553f6d1b16ee2569233705ab215025fbe41fc305cefa88721e43dc71c5</pin> <accountAlias>Test Acc</accountAlias><amount>100</amount> <accountID>2225</accountID><columnA>254722665319</columnA></Payload>
         */
        /*      $accountDetails = $this->getSessionVar ( 'accountID+accountAlias' );
          $accountDetails = explode ( "*", $accountDetails );
          $accountID = $accountDetails [0];
          $accountAlias = $accountDetails [1]; */

//$accountDetails = $this->getSessionVar ( '' );
        $SID = $this->getSessionVar('serviceID');
//$this->displayText = "ServiceID is $SID";
//$this->sessionState = 'END';

        $accountDetails = explode("|", $this->getSessionVar('accountDetails'));
        $accountID = $this->getSessionVar('accountID');
        $accountAlias = $this->getSessionVar('alias');
        $this->saveSessionVar('accountID+accountAlias', $accountID . "*" . $accountAlias);

        $serviceID = $this->getSessionVar('serviceID');
        $encryptedpin = $this->getSessionVar('encryptedPin');
        $amount = $this->getSessionVar('amount');
        $nomination = $this->getSessionVar('nomination');

        $payBillAmount = $this->getSessionVar('utilityBillAmount');
        $merchantCode = $this->getSessionVar('merchantCode');
// $accountID =
        $billAccountNo = $this->getSessionVar('utilityBillAccountNo');
        $enrolment = $this->getSessionVar('billEnrolment');
        $enrolBillNo = $this->getSessionVar('billEnrolmentNumber');

        $recipientAccountNumber = $this->getSessionVar('selectedAccountNumber');
// Change serviceID based on where the money is being transfered to
// $this->saveSessionVar ( 'vanillaService', 'checkBalance' );

        $payload = "";

        $sid = $this->getSessionVar('serviceID');
//$this->displayText = "ServiceID = $sid";
//$this->sessionState = "END";

        if ($sid == '114') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => 'open',
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('cardTransferAmt'),
                "columnA" => $this->getSessionVar('cardFTRecipient'),
                "columnD" => $this->getSessionVar('alias'),
                "accountID" => $accountID,
                "nominate" => $nomination
            );
        } elseif ($sid == '115' || $sid == '116') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "open"/* $this->getSessionVar('flavour') */,
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('cardTransferAmt'),
                "columnA" => $recipientAccountNumber, //$this->getSessionVar('cardFTRecipient'),
                "columnD" => $this->getSessionVar('nominationAlias'),
                "nominate" => $nomination,
                "accountID" => $accountID
//  "nominate" => $nomination
            );
        } elseif ($sid == 'BILL_PAY' || $sid == '18') {
#set columnF
            if ($merchantCode == $this->nwscServiceCode) {
                $columnF = $this->getSessionVar('NWSCarea');
            } else if ($merchantCode == "AFRICELL_DATA") {
                $columnF = $this->getSessionVar('dataPeriod');
            } else {
                $columnF = 'NULL';
            }

            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => $this->getSessionVar('flavour'),
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $payBillAmount,
                "merchantCode" => $merchantCode,
                "accountID" => $accountID,
                "enroll" => $enrolment,
                "CBSID" => 1,
                "columnD" => $enrolBillNo,
                "columnA" => $billAccountNo,
                "columnC" => $merchantCode,
                "columnF" => $columnF
            );
        } elseif ($sid == '82') {
            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "merchantCode" => 'AIRTEL_B2C',
                "accountID" => $accountID,
                "enroll" => 'NO',
                "CBSID" => 1,
                "columnD" => 'NULL',
                "columnA" => $this->getSessionvar('tigoPesaRecipient'), //'88888888',
                "columnC" => 'AIRTEL_B2C'
            );
        } elseif ($sid == '83') {

            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "merchantCode" => 'VODAMPESA',
                "accountID" => $accountID,
                "enroll" => 'NO',
                "CBSID" => 1,
                "columnD" => 'NULL',
                "columnA" => $this->getSessionvar('vmpesaRecipient'), //'88888888',
                "columnC" => 'MPESA'
            );
        } elseif ($sid == '84') {
            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "merchantCode" => 'AIRTELMONEY',
                "accountID" => $accountID,
                "enroll" => 'NO',
                "CBSID" => 1,
                "columnD" => 'NULL',
                "columnA" => $this->getSessionvar('airtelMoneyRecipient'), //'88888888',
                "columnC" => 'AIRTELMONEY'
            );
        } elseif ($sid == '10') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "self",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "accountID" => $accountID,
                "columnA" => $this->_msisdn
            );
        } elseif ($sid == '11') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "self",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "accountID" => $accountID,
                "columnA" => $this->_msisdn
            );
        } else if ($sid == '17') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('amount'),
                "columnA" => $this->getSessionVar('forexRates'),
                "accountID" => $accountID,
            );
        } elseif ($sid == '13') {

            $payload = array(
                "serviceID" => $sid,
                "flavour" => $this->getSessionVar('flavour'),
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('amount'),
                "columnA" => $this->getSessionVar('selectedAccountNumber'), //('destAccount'),
                "columnC" => '001',
                //     "columnC"=>$columnC,
                "columnD" => $this->getSessionVar('nominationAlias'),
                "columnB" => $this->getSessionVar('nominationReason'),
                "accountID" => $accountID,
                "nominate" => $nomination
            );
        } elseif ($sid == '15' || $sid == 16 || $sid == '117') {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('amount'),
                "columnA" => $this->getSessionVar('chequeDetails'),
                "accountID" => $accountID,
            );
        } elseif ($sid == '14') {
            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "merchantCode" => 'VODAMPESA',
                "accountID" => $accountID,
                "enroll" => 'NO',
                "CBSID" => 1,
                "columnD" => 'NULL',
                "columnA" => $this->getSessionvar('mpesaRecipient'), //'88888888',
                "columnC" => 'VODAMPESA'
            );
        } else if ($sid == '119') {

            if ($this->getSessionVar('merchantCode') == 'VSLA_B2C') {
                $payload = array(
                    "serviceID" => $this->BillPayServiceID,
                    "flavour" => "open",
                    "pin" => $encryptedpin,
                    "accountAlias" => $accountAlias,
                    "amount" => $amount,
                    "merchantCode" => 'VSLA_B2C',
                    "accountID" => $accountID,
                    "enroll" => 'NO',
                    "CBSID" => 1,
                    "columnD" => 'NULL',
                    "columnA" => $this->getSessionvar('vmpesaRecipient'), //'88888888',
                    "columnC" => 'VSLA_B2C'
                );
            } else {
                $payload = array(
                    "serviceID" => $this->BillPayServiceID,
                    "flavour" => "open",
                    "pin" => $encryptedpin,
                    "accountAlias" => $accountAlias,
                    "amount" => $amount,
                    "merchantCode" => 'MTN_B2C',
                    "accountID" => $accountID,
                    "enroll" => 'NO',
                    "CBSID" => 1,
                    "columnD" => 'NULL',
                    "columnA" => $this->getSessionvar('vmpesaRecipient'), //'88888888',
                    "columnC" => 'MTN_B2C'
                );
            }
        } elseif ($sid == '93') {

            $bankCode = "";
            $bankName = "";
            $alias = "";
            $beneficiaryName = "";
            $beneBankAccount = "";
            if ($this->getSessionVar('IsExistingBene') == 'YES') {
                $bankCode = $this->getSessionVar('selectedBenebankSwiftCode');
                $bankName = $this->getSessionVar('selectedBenebank');
                $beneficiaryName = $this->getSessionVar('selectedBeneName');
                $beneBankAccount = $this->getSessionVar('selectedAccountNumber');
            } else {
                $arr = $this->rtgsItems();
                $bankCode = $arr[$this->getSessionVar('rtgsRecipientBank')][2];
                $bankName = $arr[$this->getSessionVar('rtgsRecipientBank')][0];
                $beneficiaryName = $this->getSessionVar('rtgsRecipientName');
                $beneBankAccount = $this->getSessionVar('rtgsRecipientAccount');
            }

            $alias = $this->getSessionVar('nominationAlias');
            $test = ($beneficiaryName . '*' . $this->getSessionVar('rtgsPurpose') . '*' . $bankName);
            $centralBankAccount = "4600050015";
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionVar('rtgsAmount'),
                "accountID" => $accountID,
                "nominate" => $this->getSessionVar('nominating'),
                "CBSID" => 1,
                "columnA" => $beneBankAccount,
                "columnC" => $centralBankAccount,
                "columnB" => $bankCode,
                "columnD" => $alias,
                "extra" => $test
            );
        } elseif ($sid == '126') {
            $merchantCode = $this->getSessionvar('merchantCode');
            $payload = array(
                "serviceID" => $this->BillPayServiceID,
                "flavour" => "open",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $this->getSessionvar('utilityBillAmount'),
                "merchantCode" => $merchantCode,
                "accountID" => $accountID,
                "enroll" => 'NO',
                "CBSID" => 1,
                "columnD" => 'NULL',
                "columnA" => $this->getSessionvar('merchantID'),
                "columnC" => $merchantCode,
            );
        } elseif ($sid == 19) {
            $accountalias_accountIDSession = $this->getSessionVar('accountID+accountAlias');
            $Account_alias_accountID_array = explode("*", $accountalias_accountIDSession);
            $accountID = isset($Account_alias_accountID_array[0]) ? $Account_alias_accountID_array[0] : "";
            $accountAlias = isset($Account_alias_accountID_array[1]) ? $Account_alias_accountID_array[1] : "";
            $amount = $this->getSessionVar('7-amount');
            $number = $this->getSessionVar('airtimeMSISDN');
            $getFirstDigit = substr($number, 0, 1);
            if ($getFirstDigit == 0) {
                $receipient = '256' . substr($number, 1, 9);
            } else
                $receipient = $this->getSessionVar('airtimeMSISDN');

            $airtimeselfarray = array(
                "serviceID" => $sid,
                "flavour" => "self",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "accountID" => $accountID,
                "columnA" => $receipient
            );

            $statusCode = 2;
            $this->_externalSystemServiceID = 19;
//log request into channelRequests
            $successLog = $this->logChannelRequest($airtimeselfarray, $statusCode);
            $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
            $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
            $network = $this->getSessionVar('8-mnocodes');
            if ($successLog['SUCCESS'] == TRUE) {
//send payload to system and get response
                $this->displayText = "Your $network Top up request has been received. $this->confirmatory $this->BANK";
            } else {
                $this->displayText = "Sorry, an error occured when processing your airtime request. Please  Try again later ";
            }
        } else {
            $payload = array(
                "serviceID" => $sid,
                "flavour" => "self",
                "pin" => $encryptedpin,
                "accountAlias" => $accountAlias,
                //"accountAlias" => "kellen",
                "amount" => $amount,
                //"amount" => 0,
                "accountID" => $accountID,
                //"accountID" => 1,
//"columnA" => $this->_msisdn
                "columnA" => $this->getSessionvar('mpesaRecipient')
            );
        }

        $this->logMessage("payload to wallet: ", $payload, DTBUGconfigs::LOG_LEVEL_INFO);

        if (in_array($sid, $this->synchronousServices)) {

            $statusCode = 1;
            $successLog = $this->logChannelRequest($payload, $statusCode);
            $this->logMessage("Log channel Results: ", $successLog, DTBUGconfigs::LOG_LEVEL_INFO);

            if ($successLog ['SUCCESS'] == TRUE) {
                $processService = $this->synchronousProcessing($payload, $successLog['DATA']);
                $this->logMessage("Response from wallet: ", $processService, DTBUGconfigs::LOG_LEVEL_INFO);
                $getMessage = $processService['DATA']['MESSAGE'];
                $checkMessage = strpos($getMessage, 'statement');
                if (($processService['DATA']['STATUS_CODE'] == 1 || $processService['DATA']['STATUS_CODE'] == 2) && $checkMessage == false) {
                    $this->displayText = $processService['DATA']['MESSAGE'] . "";
                    $this->sessionState = "END";
                    //$this->nextFunction = "reload";
                } elseif (($processService['DATA']['STATUS_CODE'] == 1 || $processService['DATA']['STATUS_CODE'] == 2) && $checkMessage == true) {
                    $this->saveSessionVar('message', $getMessage);
                    $this->displayText = substr($getMessage, 0, 150) . "\n1:Next";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "nextMiniStatPage";
                } elseif ($processService['DATA']['STATUS_CODE'] == 4) {
                    $this->displayText = $processService['DATA']['MESSAGE'] . " later";
                    $this->sessionState = "END";
                    //$this->nextFunction = "reload";
                } elseif ($processService['DATA']['STATUS_CODE'] == 369) {
                    $this->displayText = "Your request has been received.\n" . $processService['DATA']['MESSAGE'];
                    $this->sessionState = "END";
                } else {
                    $this->displayText = "Sorry we cannot complete your transaction. For assistance please call 0800242242 or 0314387387. DTB";
                    $this->sessionState = "END";
                }
            } else {
                $this->displayText = "Sorry, an error occured when processing your request.";
                $this->sessionState = "END";
            }
        } else {
// log request into channelRequests
            $statusCode = 2;
            $successLog = $this->logChannelRequest($payload, $statusCode);

            if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                $this->displayText = "Your request has been received and is being processed.";
//$this->displayText = "Your request has been received. $this->confirmatory";
                $this->sessionState = "END";
                $this->nextFunction = "reload";
// $this->displayText = "iko poa";
                // $this->sessionState = "CONTINUE";
//$this->sessionState = "END";
//$this->nextFunction = "startPage";
            } else {
                $this->displayText = "Sorry, an error occured when processing your request.";
                $this->sessionState = "END";
            }
            /* $this->displayText = "accountID $accountID and accountAlias $accountAlias";
              $this->sessionState = "END"; */
        }
    }

    function nextMiniStatPage($input) {
        $message = $this->getSessionVar('message');
        switch ($input) {
            case 1:
                $this->displayText = substr($message, 150, 150) . "\n2:Back \n3:Home \n4:Exit";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "miniStatBackPage";
                break;
        }
    }

    function miniStatBackPage($input) {
        $message = $this->getSessionVar('message');
        switch ($input) {
            case 2:
                $this->displayText = substr($message, 0, 150) . "\n1:Next";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "nextMiniStatPage";
                break;

            case 4:
                $this->displayText = "Thank you for using DTB mobile";
                $this->sessionState = "END";
                break;

            case 3:
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

    /* ================= new process Bill ============== */

    function processPayBill($input) {

        if ($this->previousPage == "selectBankingService") {
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

    function processRequest($input) {

        $profileID = $this->getSessionVar('profileID');

        if ($input == "984") {
            $this->startPage();
        } /* if (empty($profileID)) {

          $this->displayText = "Dear Customer, Please visit your nearest $this->BANK branch to register for DTB Mobile.";
          $this->sessionState = "END";


          } */ else {
            if ($input == "" or $input < 1 || $input > 8 or ! is_numeric($input)) {
                $this->displayText = "$profileID Wrong selection. Services Menu:\n" . $this->CBSservices;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
            } else {
                $this->saveSessionVar('selectedService', $input);
//$this->saveSessionVar ( 'extra', $clientAccounts );
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processSelectedBankingService";
                $this->navigate();
            }
        }
    }

    function processVanillaServices($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        switch ($input) {

            case 1:
                $this->saveSessionVar('serviceID', '11');
                $this->displayText = "Select account:\n" . $clientAccounts;
                $this->saveSessionVar('amount', '0');
                $this->saveSessionVar('vanillaService', 'ministatement');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "validateAccountDetails";
                break;
            case 2:
                $this->displayText = "Select the number of cheque leaves:\n1. 25\n2. 50\n3. 100";
                $this->saveSessionVar('vanillaService', 'chequeBookRequest');
                $this->saveSessionVar('serviceID', '15');
                $this->saveSessionVar('amount', '0');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processChequeRequest";
                break;
            case 3:
                $this->displayText = "Enter the cheque number:";
                $this->saveSessionVar('vanillaService', 'stopCheque');
                $this->saveSessionVar('serviceID', '16');
                $this->saveSessionVar('amount', '0');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processChequeRequest";
                break;
            case 4:
                $this->displayText = "Enter the cheque number:";
                $this->saveSessionVar('vanillaService', 'stopCheque');
                $this->saveSessionVar('serviceID', '117');
                $this->saveSessionVar('amount', '0');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processChequeRequest";
                break;
            case 5:
                $this->saveSessionVar('serviceID', '17');
                $this->displayText = "Please select currency:\n$this->forexCurrencies";
                $this->saveSessionVar('amount', '0');
                $this->saveSessionVar('vanillaService', 'forexRatesRequest');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processForexAlerts";

                break;

            default:
                $this->displayText = "Invalid selection. Enter \n1. Ministatement\n2. Cheque book ordering\n3. Stop cheque\n4. Cheque status\n5. Forex rates";
                $this->nextFunction = "processVanillaServices";
                $this->sessionState = "CONTINUE";
                break;
        }
    }

    function pinServices($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        switch ($input) {

            case 1:
                $this->displayText = "Please enter your current DTB mobile PIN:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "validatePin";
                $this->saveSessionVar("extra", "changePIN");
                break;
            case 2:
                $origin = $this->getSessionVar('origin');
                $onOtp = false;
// $this->displayText = "clientProfileID is $clientprofileID. "; */
                $clientProfileJson = $this->fetchCustomerData();
                $clientProfile = json_decode($clientProfileJson, true);
                $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
                $clientprofileID = $clientProfiledata [0];
                $profileactive = $clientProfiledata [1];
                $customeractive = $clientProfiledata [1];
                $profile_pin_status = $clientProfiledata ['2'];
                $customerNames = $clientProfiledata [3];
                $customerNames .= (($clientProfiledata [4] == "NULL" || $clientProfiledata [4] == "") ? "" : " " . $clientProfiledata [4]);

                $profileActiveStatus = $customeractive;
                $customerActiveStatus = $customeractive;

                $serviceList = "";
                $aliases = "";
                $this->saveSessionVar('accountDetails', $clientProfile ['accountDetails']);
                $this->saveSessionVar('enrolmentDetails', $clientProfile ['enrollmentDetails']);
                $this->saveSessionVar('nominationDetails', $clientProfile ['nominationDetails']);


                if ($clientprofileID != 0) {
                    $now = date("Y-m-d H:i:s");
                    $diff = ((strtotime($now) - strtotime(date($this->getSessionVar('lastPinChange')))) / 60) / 60;
                    if ($profile_pin_status == 6 or ( $profile_pin_status == 2 && $diff > 24)) {
                        $onOtpE = true;
                    } elseif ($profile_pin_status == 2) {
                        $onOtp = true;
                    }
                }

                if ($onOtpE) {
                    $this->displayText = "Dear $customerNames,your One Time PIN has expired,please enter your ID/passport number to reset your PIN:";
                    $this->nextFunction = "OTP_Expired";
                    $this->previousPage = "activation_pin_input_process";
                    $this->saveSessionVar('otplevel', 'idNumber');
                } elseif ($onOtp) {
                    $this->displayText = "Please enter your One Time PIN:";
                    $this->nextFunction = "BE_Mobile_ProcessOTP";
                    $this->previousPage = "activation_pin_input_process";
                } else {
                    $this->displayText = "Sorry, you are not on One Time Pin";
                }

                break;
            default:
                $this->displayText = "Invalid selection. Enter \nPlease select a service:\n1. Change PIN\n2. Change One Time PIN ";
                $this->saveSessionVar("extra", "changePIN");
                $this->nextFunction = "pinServices";
                $this->sessionState = "CONTINUE";
                break;
        }
    }

    function processMinistatment($input) {
        switch ($input) {
            case 0:
                $this->displayText = "Select:\n$this->CBSservices";
                $this->nextFunction = "processRequest";
                $this->sessionState = "CONTINUE";
                break;

            case 1:
                $this->displayText = "Please enter your PIN:";
                $this->saveSessionVar('amount', '0');
                $this->saveSessionVar('vanillaService', 'ministatement');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "validatePin";
                break;

            default:
                $this->displayText = "Wrong selection: Enter 1 for ministatement or 0 to go back to main menu";
                $this->nextFunction = "processMinistatment";
                $this->sessionState = "CONTINUE";
                break;
        }
    }

    function processChequeRequest($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        $source = $this->getSessionVar('vanillaService');
        $this->displayText = "You selected " . $source;
        if ($source == 'chequeBookRequest') {
            if ($input == 1) {
                $this->saveSessionVar('chequeDetails', '25');
            } elseif ($input == 2) {
                $this->saveSessionVar('chequeDetails', '50');
            } elseif ($input == 3) {
                $this->saveSessionVar('chequeDetails', '100');
            } else {
                $this->displayText = "Invalid entry. Please select number of leaves\n1. 25\n2. 50\n3. 100";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar('vanillaService', 'chequeBookRequest');
                $this->nextFunction = "processChequeBookRequest";
            }

            $this->displayText = "Select account for the cheque book request:\n" . $clientAccounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } if ($input != " ") {
            $this->saveSessionVar('chequeDetails', $input);
            $this->displayText = "Select account:\n" . $clientAccounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } else {
            $this->displayText = "please the cheque book number";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "";
        }
    }

    function validateIfOnOTP() {
        $origin = $this->getSessionVar('origin');
        $onOtp = false;
// $this->displayText = "clientProfileID is $clientprofileID. "; */
        $clientProfileJson = $this->fetchCustomerData();
        $clientProfile = json_decode($clientProfileJson, true);
        $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
        $clientprofileID = $clientProfiledata [0];
        $profileactive = $clientProfiledata [1];
        $customeractive = $clientProfiledata [1];
        $profile_pin_status = $clientProfiledata ['2'];
        $customerNames = $clientProfiledata [3];
        $customerNames .= (($clientProfiledata [4] == "NULL" || $clientProfiledata [4] == "") ? "" : " " . $clientProfiledata [4]);

        $profileActiveStatus = $customeractive;
        $customerActiveStatus = $customeractive;

        $serviceList = "";
        $aliases = "";
        $this->saveSessionVar('accountDetails', $clientProfile ['accountDetails']);
        $this->saveSessionVar('enrolmentDetails', $clientProfile ['enrollmentDetails']);
        $this->saveSessionVar('nominationDetails', $clientProfile ['nominationDetails']);


        if ($clientprofileID != 0) {

            if ($profile_pin_status == 2) {
                $onOtp = true;
            }
        }
    }

    function processSendMoney($input) {

        $clientAccounts = $this->getSessionVar('clientAccounts');
        if ($this->previousPage == "processConfirmedSendMoney") {
            if ($this->getSessionVar("confirmSendMoney") == "mpesa") {
                
            } elseif ($this->getSessionVar("confirmSendMoney") == "card") {
                $serviceID = "";
                if ($this->getSessionVar("cardType") == "nationHela") {
                    $serviceID = $this->NATIONHELAServiceID;
                } elseif ($this->getSessionVar("cardType") == "nakumattGlobal") {
                    $serviceID = $this->NAKUMATTGLOBALServiceID;
                } elseif ($this->getSessionVar("cardType") == "miCard") {
                    $serviceID = $this->MICARDServiceID;
                } elseif ($this->getSessionVar("cardType") == "internalFT") {
                    $serviceID = $this->INTERNALFTServiceID;

                    if ($input < $this->MINFTTRANSFER || $input > $this->MAXFTTRANSFER) {
                        $this->displayText = "Incorrect amount. Please enter an amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER:";
                        $this->nextFunction = "processSendMoney";
                        $this->previousPage = "processConfirmedSendMoney";
                        $this->sessionState = "CONTINUE";
                    }
                }
            }
            switch ($input) {
                case 1 :
                    if ($clientprofileID != 0) {

                        if ($this->agentServiceID == 5) {
                            $this->displayText = "Dear $customerNames,Please call customer care to activate your Mobile Number for DTB Mobile.";
                            $this->sessionState = "END";
                        } elseif ($profile_pin_status == 2) {
// customer presented with prompt to change one time pin
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your Mobile Banking Service.";
                            $this->sessionState = "END";
                        } elseif ($profile_pin_status == 1 and $profileActiveStatus == 1 and $customerActiveStatus == 1) {
                            $this->displayText = "Welcome $customerNames to $this->BANK. Please enter your PIN:";
                            $this->sessionState = "CONTINUE";
                            $this->nextFunction = "validatePin";
                        } elseif ($customerActiveStatus != 1) {
// Customer is not active
                            $this->displayText = "Dear $customerNames,Please call customer care to activate your Mobile Number for DTB Mobile.";
                            $this->sessionState = "END";
                        } elseif ($profileActiveStatus != 1) {
// customer is not active
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your Mobile Number for DTB Mobile.";
                            $this->sessionState = "END";
                        } else {
// Otp status not known to this menu
                            $this->displayText = "Dear $customerNames, Please call customer care to activate your Mobile Number for DTB Mobile.";
                            $this->sessionState = "END";
                        }
                    } else {
                        $this->displayText = "Select account:\n" . $clientAccounts;
                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "validateAccountDetails";
                    }
                    break;

                case 2 :
                    $this->displayText = "You cancelled the send money request. Select\n$this->CBSservices";
                    $this->nextFunction = "processRequest";
// $this->previousPage = "selectBankingService";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "");
                    break;

                default :
                    $this->displayText = "Incorrect selection. Please select\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "selectBankingService") {
            switch ($input) {
//disable for phase 1
                case 1 :
                case 4 :

                    $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
                    $this->saveSessionVar('serviceID', 'BILL_PAY');
                    $vmpesaNoms = $this->getSessionVar("vmpesaEnrolments");

                    $this->saveSessionVar('extra', 'branchCode-enrol');
                    $this->saveSessionVar('transferType', 'accTovmpesa');

                    if ($input == 4) {
                        $this->saveSessionVar('merchantCode', 'VSLA_B2C');
                    } else {
                        $this->saveSessionVar('merchantCode', 'MTN_B2C');
                    }

                    if ($vmpesaNoms == 0) {
//$this->displayText = "Enter mobile number in the format 07XX:";
                        $this->saveSessionVar('flavour', 'open');
                        $this->displayText = "Select option:\n1: My number";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "processvmpesaNoEnrolments";
                        $this->nextFunction = "processSendMoney";
                    } else {
                        $enroledAccounts = "";
                        $enroledAccountNumbers = array();
                        $displayedAliases = array();
                        $counter = 0;
                        $num = 1;
                        for ($i = 0; $i < sizeof($enrolments); $i++) {
                            $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                            if ($enrolmentData[1] == "MTN_B2C") {
                                $enroledAccountNumbers[$counter] = $enrolmentData['1'];

                                $num++;
                                $enroledAccounts .= $num . ": " . $enrolmentData ['0'] . "\n";
                                $count++;

                                $aliases .= $enrolmentData ['0'] . "^";
                                $displayedAliases[] = $enrolmentData ['0'];
                                $counter++;
                            }
                        }
                        $num++;
                        $count++;

                        $enroledAccounts .= $num . ": Other";

//  $menu = "Select Account to transfer to:\n1. My number\n $enroledAccounts";
                        $menu = "Select MPesa beneficiary:\n1. My number\n $enroledAccounts";
                        $this->displayText = $menu;
                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "processSendMoney";
                        $this->previousPage = "enrolmentPromptMpesa";
                        $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                        $this->saveSessionVar("availableAliases", $displayedAliases);
                        $this->saveSessionVar("mpesaTo", "nomination");
                        $this->saveSessionVar("storedAccountNumbers", $enroledAccountNumbers);
                    }

                    break;

//disable for phase 1 airtel money add when we go live with the service
                /* case 2 :

                  $this->displayText = "Dear customer, this service is currently unavailable";
                  $this->sessionState = "END";
                  /* $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
                  $this->saveSessionVar('serviceID', 'BILL_PAY');
                  $mpesaNoms = $this->getSessionVar("mpesaEnrolments");

                  $this->saveSessionVar('extra','branchCode-enrol');
                  $this->saveSessionVar('transferType','accToMpesa');
                  $this->saveSessionVar('merchantCode','AIRTEL_B2C');

                  if ($mpesaNoms == 0) {
                  //$this->displayText = "Enter mobile number in the format 07XX:";
                  $this->saveSessionVar('flavour','open');
                  $this->displayText = "Select option:\n1: My number\n2: Other number ";
                  $this->sessionState = "CONTINUE";
                  $this->previousPage = "processTigoPesaNoEnrolments";
                  $this->nextFunction = "processSendMoney";
                  } else {
                  $enroledAccounts = "";
                  $enroledAccountNumbers = array();
                  $displayedAliases = array();
                  $counter = 0 ;
                  $num = 1 ;
                  for ($i = 0; $i < sizeof($enrolments); $i++) {
                  $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                  if($enrolmentData[1] == "AIRTEL_B2C"){
                  $enroledAccountNumbers[$counter] = $enrolmentData['1'];

                  $num++;
                  $enroledAccounts .= $num . ": " . $enrolmentData ['0'] . "\n";
                  $count++;

                  $aliases .= $enrolmentData ['0'] . "^";
                  $displayedAliases[] = $enrolmentData ['0'];
                  $counter++ ;
                  }
                  }
                  $num++;
                  $count++;

                  $enroledAccounts .= $num . ": Other";

                  //  $menu = "Select Account to transfer to:\n1. My number\n $enroledAccounts";
                  $menu = "Select MPesa beneficiary:\n1. My number\n $enroledAccounts";
                  $this->displayText = $menu;
                  $this->sessionState = "CONTINUE";
                  $this->nextFunction = "processSendMoney";
                  $this->previousPage = "enrolmentPromptMpesa";
                  $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                  $this->saveSessionVar("availableAliases", $displayedAliases);
                  $this->saveSessionVar("mpesaTo", "nomination");
                  $this->saveSessionVar("storedAccountNumbers", $enroledAccountNumbers);
                  }

                  break;
                  /*
                  case 3 :


                  $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
                  $this->saveSessionVar('serviceID', 'BILL_PAY');
                  $airtelMoneyNoms = $this->getSessionVar("airtelMoneyEnrolments");

                  $this->saveSessionVar('extra','branchCode-enrol');
                  $this->saveSessionVar('transferType','accToAirtelMoney');
                  $this->saveSessionVar('merchantCode','AIRTELMONEY');

                  if ($airtelMoneyNoms== 0) {
                  //$this->displayText = "Enter mobile number in the format 07XX:";
                  $this->saveSessionVar('flavour','open');
                  $this->displayText = "Select option:\n1: My number\n2: Other number ";
                  $this->sessionState = "CONTINUE";
                  $this->previousPage = "processAirtelMoneyNoEnrolments";
                  $this->nextFunction = "processSendMoney";
                  } else {
                  $enroledAccounts = "";
                  $enroledAccountNumbers = array();
                  $displayedAliases = array();
                  $counter = 0 ;
                  $num = 1 ;
                  for ($i = 0; $i < sizeof($enrolments); $i++) {
                  $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                  if($enrolmentData[1] == "MPESA"){
                  $enroledAccountNumbers[$counter] = $enrolmentData['1'];

                  $num++;
                  $enroledAccounts .= $num . ": " . $enrolmentData ['0'] . "\n";
                  $count++;

                  $aliases .= $enrolmentData ['0'] . "^";
                  $displayedAliases[] = $enrolmentData ['0'];
                  $counter++ ;
                  }
                  }
                  $num++;
                  $count++;

                  $enroledAccounts .= $num . ": Other";

                  //  $menu = "Select Account to transfer to:\n1. My number\n $enroledAccounts";
                  $menu = "Select MPesa beneficiary:\n1. My number\n $enroledAccounts";
                  $this->displayText = $menu;
                  $this->sessionState = "CONTINUE";
                  $this->nextFunction = "processSendMoney";
                  $this->previousPage = "enrolmentPromptMpesa";
                  $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                  $this->saveSessionVar("availableAliases", $displayedAliases);
                  $this->saveSessionVar("mpesaTo", "nomination");
                  $this->saveSessionVar("storedAccountNumbers", $enroledAccountNumbers);
                  }

                  break;

                 */

//                case 2 :
//                    // done
//                    /*$this->displayText = "Enter mobile number in the format 07XX:";
//                    $this->saveSessionVar("cardType", "nakumattGlobal");
//                    $this->saveSessionVar('serviceID', '115');
//                    $this->sessionState = "CONTINUE";
//                    $this->previousPage = "processSendMoneyCard"; //"processOtherCardMobileNumber";
//                    $this->nextFunction = "processSendMoney";
//                    break;*/
//
                //// fetch nominations, display them
//                    $nominations = array_filter(explode('#', $this->getSessionVar('nominationDetails')));
//                    $this->saveSessionVar('serviceID', '115');
//                    $nominationCount = count($nominations);
//                    $cardNoms = $this->getSessionVar("cardNominations");
//
                //                    $this->saveSessionVar('extra','branchCode-enrol');
//                    $this->saveSessionVar('transferType','accToCard');
//
                //                    if ($cardNoms == 0) {
//                        $this->displayText = "Enter mobile number in the format 07XX:";
//                        $this->sessionState = "CONTINUE";
//                        $this->previousPage = "processSendMoneyCard";
//                        $this->nextFunction = "processSendMoney";
//                    } else {
//                        $nominatedAccounts = "";
//                        $nominatedAccountNumbers = array();
//                        $displayedAliases = array();
//          $counter = 0;
//                        for ($i = 0; $i < sizeof($nominations); $i++) {
//                            $nominationData = array_filter(explode("|", $nominations [$i]));
//                           if($nominationData[6] == "CARD"){
//                                        $nominatedAccountNumbers[$counter] = $nominationData['1'];
//
                //                                        $num++;
//                                        $nominatedAccounts .= $num . ": " . $nominationData ['0'] . "\n";
//                                        $count++;
//
                //                                        $aliases .= $nominationData ['0'] . "^";
//                                        $displayedAliases[] = $nominationData ['0'];
//                  $counter++;
//                                }
//                        }
//                        $num++;
//                        $count++;
//
                //                        $nominatedAccounts .= $num . ": Other";
//
                //                        $menu = "Select beneficiary to transfer to:\n $nominatedAccounts";
//                        $this->displayText = $menu;
//                        $this->sessionState = "CONTINUE";
//                        $this->nextFunction = "processSendMoney";
//                        $this->previousPage = "nominationPromptCards";
// $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
//                        $this->saveSessionVar("availableAliases", $displayedAliases);
//                        $this->saveSessionVar("mpesaTo", "nomination");
//          $this->saveSessionVar("storedAccountNumbers", $nominatedAccountNumbers);
//                    }
//
                //                    break;
//                case 3 :
//                    // done
//                    //$this->displayText = "Select card to send money to:\n1. Nakumatt Global\n2: Mi Card";
//                    //$this->displayText = "Select card to send money to:\n1. Nakumatt Global";
//                    /*$this->displayText = "Enter mobile number in the format 07XX:";
//                    $this->saveSessionVar("cardType", "nationHela");
//                    $this->saveSessionVar('serviceID', '116');
//                    $this->sessionState = "CONTINUE";
//                    $this->previousPage = "processSendMoneyCard";
//                    $this->nextFunction = "processSendMoney";
//                    break;*/
//
                //// fetch nominations, display them
//                    $nominations = array_filter(explode('#', $this->getSessionVar('nominationDetails')));
//                    $this->saveSessionVar('serviceID', '116');
//                    $nominationCount = count($nominations);
//                    $cardNoms = $this->getSessionVar("cardNominations");
//
                //                    $this->saveSessionVar('extra','branchCode-enrol');
//                    $this->saveSessionVar('transferType','accToCard');
//
                //                    if ($cardNoms == 0) {
//                        $this->displayText = "Enter mobile number in the format 07XX:";
//                        $this->sessionState = "CONTINUE";
//                        $this->previousPage = "processSendMoneyCard";
//                        $this->nextFunction = "processSendMoney";
//                    } else {
//                        $nominatedAccounts = "";
//                        $nominatedAccountNumbers = array();
//                        $displayedAliases = array();
//          $counter = 0 ;
//                        for ($i = 0; $i < sizeof($nominations); $i++) {
//                            $nominationData = array_filter(explode("|", $nominations [$i]));
//                           if($nominationData[6] == "CARD"){
//                                        $nominatedAccountNumbers[$counter] = $nominationData['1'];
//
                //                                        $num++;
//                                        $nominatedAccounts .= $num . ": " . $nominationData ['0'] . "\n";
//                                        $count++;
//
                //                                        $aliases .= $nominationData ['0'] . "^";
//                                        $displayedAliases[] = $nominationData ['0'];
//                  $counter++ ;
//                                }
//                        }
//                        $num++;
//                        $count++;
//
                //                        $nominatedAccounts .= $num . ": Other";
//
                //                        $menu = "Select beneficiary to transfer to:\n $nominatedAccounts";
//                        $this->displayText = $menu;
//                        $this->sessionState = "CONTINUE";
//                        $this->nextFunction = "processSendMoney";
//  $this->previousPage = "nominationPromptCards";
// $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
//                        $this->saveSessionVar("availableAliases", $displayedAliases);
//                        $this->saveSessionVar("mpesaTo", "nomination");
//          $this->saveSessionVar("storedAccountNumbers", $nominatedAccountNumbers);
//                    }
//
                //                    break;*/

                case 2 :

// fetch nominations, display them
                    $nominations = array_filter(explode('#', $this->getSessionVar('nominationDetails')));
                    $this->saveSessionVar('serviceID', '13');
                    $nominationCount = count($nominations);
                    if ($nominationCount == 0) {
                        $this->saveSessionVar('flavour', 'open');
                        $this->displayText = "Please enter the account number";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "processSendToDTBAccount";
                        $this->nextFunction = "processSendMoney";
                    } else {
                        $nominatedAccounts = "";
                        $nominatedAccountNumbers = array();
                        $displayedAliases = array();
                        $bankBranches = array();
                        $counter = 0;
                        for ($i = 0; $i < sizeof($nominations); $i++) {
                            $nominationData = array_filter(explode("|", $nominations [$i]));
                            if ($nominationData[6] == "IFT") {
                                $nominatedAccountNumbers[$counter] = $nominationData['1'];
                                $bankBranches[$counter] = $nominationData['5'];
                                $num++;
                                $nominatedAccounts .= $num . ": " . $nominationData ['0'] . "\n";
//$nominatedAccountNumbers[i] = $nominationData['1'];
                                $count++;

                                $aliases .= $nominationData ['0'] . "^";
                                $displayedAliases[] = $nominationData ['0'];
                                $counter++;
                            }
                        }
                        $num++;
                        $count++;

                        $nominatedAccounts .= $num . ": Other";
                        $sampleBranch = $bankBranches[0];
                        $branchTotal = sizeof($bankBranches);
                        $menu = "Select Account to transfer to:\n $nominatedAccounts";
                        $this->displayText = $menu;
                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "processSendMoney";
                        $this->previousPage = "nominationPrompt";
                        $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                        $this->saveSessionVar("availableAliases", $displayedAliases);
                        $this->saveSessionVar('branches', $bankBranches);
                        $this->saveSessionVar('storedAccountNumbers', $nominatedAccountNumbers);
                        $this->saveSessionVar("mpesaTo", "nomination");
                    }

                    break;
                case 3:
                    $hour = date('H');
                    $dayofweek = date("N");

                    $hour = date('H');
                    $dayofweek = date("N");
                    /* if(($hour >8 and $hour <16) and  $dayofweek <6 ) */ if (0 == 0) {
//get array items
                        $arr = $this->rtgsItems();
                        $i = 1;
                        $rtgsMenu = "";
                        while ($i < 8) {
                            $rtgsMenu .= "\n$i." . $arr[$i][1];
                            $i++;
                        }

                        $nominations = array_filter(explode('#', $this->getSessionVar('nominationDetails')));
                        $this->saveSessionVar('serviceID', '93');
                        $nominationCount = count($nominations);

                        if ($nominationCount == 0) {

                            $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks";

                            $this->saveSessionVar('serviceID', '93');
                            $this->saveSessionVar('pagenumber', '1');
                            $this->sessionState = "CONTINUE";
                            $this->previousPage = "rtgsBeneSelection";
                            $this->nextFunction = "processRTGS";
                        } else {
                            $nominatedAccounts = "";
                            $nominatedAccountNumbers = array();
                            $displayedAliases = array();
                            $bankBranches = array();
                            $rtgsbeneficiaryName = array();
                            $rtgsbank = array();
                            $rtgsbankSwiftcode = array();
                            $counter = 0;
                            for ($i = 0; $i < sizeof($nominations); $i++) {
                                $nominationData = array_filter(explode("|", $nominations [$i]));
                                if ($nominationData[6] == "RTGS") {
//  $nominationAcc= array();
                                    $nominationAcc = array_filter(explode("*", $nominationData['1']));
                                    $nominatedAccountNumbers[$counter] = $nominationAcc['0'];
                                    $rtgsbeneficiaryName[$counter] = $nominationAcc['1'];
                                    $rtgsbank[$counter] = $nominationAcc['3'];
                                    $rtgsbankSwiftcode[$counter] = $nominationAcc['4'];

//$nominatedAccountNumbers[$counter] = $nominationData['1'];
                                    $bankBranches[$counter] = $nominationData['5'];
                                    $num++;
                                    $nominatedAccounts .= $num . ": " . $nominationData ['0'] . "\n";
//$nominatedAccountNumbers[i] = $nominationData['1'];
                                    $count++;

                                    $aliases .= $nominationData ['0'] . "^";
                                    $displayedAliases[] = $nominationData ['0'];
                                    $counter++;
                                }
                            }
                            $num++;
                            $count++;

                            $nominatedAccounts .= $num . ": Other";
                            $sampleBranch = $bankBranches[0];
                            $branchTotal = sizeof($bankBranches);
                            $menu = "Select Account to transfer to:\n $nominatedAccounts";
                            $this->saveSessionVar("invalidRTGS", $nominatedAccounts);
                            $this->displayText = $menu;
                            $this->sessionState = "CONTINUE";


                            $this->saveSessionVar('extra', $count . "*" . $menu . "*" . $aliases);
                            $this->saveSessionVar("availableAliases", $displayedAliases);
                            $this->saveSessionVar('branches', $bankBranches);
                            $this->saveSessionVar('storedAccountNumbers', $nominatedAccountNumbers);
                            $this->saveSessionVar("mpesaTo", "nomination");
                            $this->saveSessionVar('rtgsbeneficiaryNames', $rtgsbeneficiaryName);
                            $this->saveSessionVar('rtgsbenebanks', $rtgsbank);
                            $this->saveSessionVar('rtgsbenebankSwiftcodes', $rtgsbankSwiftcode);
                            $this->previousPage = "nominationexist";
                            $this->nextFunction = "processRTGS";
                        }
                    } else {

                        $this->displayText = "Dear Customer, this service is only available from Monday to Friday 9am to 2pm";
                        $this->sessionState = "END";
                        $this->nextFunction = "reload";
                    }
                    break;
                default:
                    $sid = $this->getSessionVar('serviceID');
//$this->displayText = "Invalid input, please select:\n1: Mpesa\n2: Tigo Pesa\n3: Airtel Money\n4: DTB Account";
                    $this->displayText = "Invalid input, please select:\n1: MPESA Transfer Money \n2: Airtel Money\n3: DTB Account\n4: RTGS";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "selectBankingService";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processPaymentMpesa") {
            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'vmpesaToSelf');
                    $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("vmpesaTo", "self");
                    break;

                case 2 :
                    $this->displayText = "Enter mobile number in the format 07XXXXXXXX:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterMpesaNumber";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("vmpesaTo", "other");
                    break;

                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number\n2: Other number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentMpesa";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processPaymentTigoPesa") {



            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'tigoPesaToSelf');
                    $this->displayText = "Enter amount bebuda tween UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("tigoPesaTo", "self");
                    break;

                case 2 :
                    $this->displayText = "Enter mobile buda number in the format 07XXXXXXXX:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterMpesaNumber";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("tigoPesaTo", "other");
                    break;

                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentTigoPesa";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processPaymentAirtelMoney") {
            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'airtelMoneyToSelf');
                    $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("airtelMoneyTo", "self");
                    break;

                case 2 :
                    $this->displayText = "Enter mobile number in the format 07XXXXXXXX:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterMpesaNumber";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("airtelMoneyTo", "other");
                    break;

                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentAirtelMoney";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processvmpesaNoEnrolments") {

            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'vmpesaToSelf');
                    $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("vmpesaTo", "self");
                    break;


                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentMpesa";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processTigoPesaNoEnrolments") {
            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'tigoPesaToSelf');
                    $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("tigoPesaTo", "self");
                    break;

                case 2 :
                    $this->displayText = "Enter mobile number in the format 07XXXXXXXX:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterMpesaNumber";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("tigoPesaTo", "other");
                    break;

                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number\n2: Other number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentTigoPesa";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processAirtelMoneyNoEnrolments") {

            switch ($input) {
                case 1 :
                    $this->saveSessionVar('origin', 'airtelMoneyToSelf');
                    $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processSendMoneyAmount";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("airtelMoneyTo", "self");
                    break;

                case 2 :
                    $this->displayText = "Enter mobile number in the format 07XXXXXXXX:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterMpesaNumber";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar("airtelMoneyTo", "other");
                    break;

                default :
                    $this->displayText = "Invalid selection. Please enter\n1: My number";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processPaymentAirtelMoney";
                    $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "enterMpesaNumber") {
            $customerMSISDNLength = strlen($input);
//validate msisdn
            if ($customerMSISDNLength == 10) {
                $customerMSISDN = '256' . substr($input, 1, 9);
                $this->saveSessionVar('recMSISDN', $customerMSISDN);
                $this->saveSessionVar('mpesaRecipient', $customerMSISDN);
                $this->saveSessionVar('utilityBillAccountNo', $customerMSISDN);
                $this->saveSessionVar('billEnrolmentNumber', 'null');
                $this->saveSessionVar('billEnrolment', 'no');
                $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "other");
            } else {
                $this->displayText = "Invalid mobile number. Enter the 10 digit phone number the format 07XX:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "enterMpesaNumber";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "other");
            }
        } elseif ($this->previousPage == "nominationPrompt") {
            $selection = $this->getSessionVar('availableAliases');
            $size = sizeof($selection);
            $selectedVal = $size + 1;
            if ($input == $selectedVal) {
                $this->saveSessionVar('transferType', 'accToAcc');
//$this->saveSessionVar('extra','branchCode-enrol');
                $this->saveSessionVar('isNomination', 'no');
                $this->saveSessionVar('flavour', 'open');
                $this->sessionState = "CONTINUE";
                $this->displayText = "Please enter the account number";
                $this->previousPage = "processSendToDTBAccount";
                $this->nextFunction = "processSendMoney";
            } elseif ($input < 1 || $input > $size) {
                $this->displayText = "Invalid entry. Select service: \n$this->CBSservices";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
            } else {
//truth
                $this->displayText = " Enter amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER";
//$this->saveSessionvar('transferType', 'accToAcc');
                $this->saveSessionVar('flavour', 'open'); // 'NOMINATED');
                $this->saveSessionVar('cardRecMSISDN', $selection[$input - 1]);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyDTBAmount"; //"processSendMoneyCardAmount";
                $this->saveSessionVar('selectedAccountNumber', $selection[$input - 1]);
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "nomination");
                $currentAlias = $this->getSessionVar('alias');
                $this->saveSessionVar('nominationAlias', 'null'); // $selection[$input-1]);
                $this->saveSessionVar('nominate', 'NO');
            }
        } elseif ($this->previousPage == "nominationPromptCards") {

            $selection = $this->getSessionVar('availableAliases');
            $size = sizeof($selection);
            $selectedVal = $size + 1;
            if ($input == $selectedVal) {
                $this->saveSessionVar('transferType', 'accToCard');
                $this->saveSessionVar('isNomination', 'no');
                $this->saveSessionVar('extra', 'cardEnrol');
                $this->saveSessionVar('flavour', 'open');
                $this->sessionState = "CONTINUE";
                $this->displayText = "Enter mobile number in the format 07XX:";
                $this->previousPage = "processSendMoneyCard";
                $this->nextFunction = "processSendMoney";
            } elseif ($input < 1 || $input > $size) {
                $this->displayText = "Invalid entry. Select service: \n$this->CBSservices";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
            } else {
                $accounts = $this->getSessionVar('storedAccountNumbers');
                $this->displayText = "Enter amount between UGX $this->MINCARDTRANSFER and UGX $this->MAXCARDTRANSFER";
                $this->saveSessionVar('flavour', 'NOMINATED');
                $this->saveSessionVar('transferType', 'accToCardNominated');
                $this->saveSessionVar('cardRecMSISDN', $selection[$input - 1]);
                $this->saveSessionVar('selectedAccountNumber', $selection[$input - 1]);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyCardAmount";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "nomination");
                $this->saveSessionVar('nominationAlias', $selection[$input - 1]);
            }
        } elseif ($this->previousPage == "enrolmentPromptMpesa") {
            $selection = $this->getSessionVar('availableAliases');
            $size = sizeof($selection);
            $selectedVal = $size + 2;
            if ($input == 1) {
                $this->saveSessionVar('flavour', 'open');
                $this->saveSessionVar('origin', 'tigoPesaToSelf');
                $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "self");
            } elseif ($input == $selectedVal) {
                $this->saveSessionVar('flavour', 'open');
                $this->displayText = "Enter mobile number in the format 07XXXXXXXX:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "enterMpesaNumber";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "other");
            } elseif ($input < 1 || $input > $size + 1) {
                $this->displayText = "Invalid entry. Select service: \n$this->CBSservices";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
            } else {
                $accounts = $this->getSessionVar('storedAccountNumbers');
                $this->displayText = "Enter amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER";
                $this->saveSessionVar('flavour', 'enrolled');
                $this->saveSessionVar('transferType', 'accToMpesaNominated');
                $this->saveSessionVar('recMSISDN', $selection[$input - 2]);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
                $this->saveSessionVar("mpesaTo", "nomination");
                $this->saveSessionVar('billEnrolmentNumber', 'null');
                $this->saveSessionVar('utilityBillAccountNo', $selection[$input - 2]);
                $this->saveSessionVar('billEnrolment', 'NO');
                $this->saveSessionVar('nominationAlias', $selection[$input - 2]);
            }
        } elseif ($this->previousPage == "enrolmentPromptAirtime") {
            $selection = $this->getSessionVar('availableAliases');
            $size = sizeof($selection);
            $selectedVal = $size + 2;

            $networkID = $this->getProvider($this->_networkID);
            if ($networkID == "MTN") {
                $this->saveSessionVar("merchantCode", "MTN_AIRTIME");
            } elseif ($networkID == "Airtel") {
                $this->saveSessionVar("merchantCode", "AIRTELTOPUP");
            } elseif ($networkID == "Africell") {
                $this->saveSessionVar("merchantCode", "AFRICELL_AIRTIME");
            } elseif ($networkID == "Vodacom") {
                $this->saveSessionVar("merchantCode", "VODATOPUP");
            } elseif ($networkID == "Zantel") {
                $this->saveSessionVar("merchantCode", "ZANTELTOPUP");
            }
            if ($input != 1) {
                $test = $this->getSessionVar("storedAccountNumbers");
                $this->saveSessionVar("merchantCode", $test[$input - 2]);
                $storedAlias = $this->getSessionVar("availableAliases");
                $this->saveSessionVar("storedAirtimeAlias", $storedAlias[$input - 2]);
            }

            if ($input == 1) {
                $this->saveSessionVar('airtimeRecipient', 'self');

                $arrLen = count($this->topupAmounts);
                $topUpAmountsMenu = "Select " . $this->MNOcodes[$this->customerNetOperator] . " top up amount:\n";

                $counter = 1;
                foreach ($this->topupAmounts as $k => $v) {
                    $topUpAmountsMenu .= $counter . ': ' . $this->topupAmounts[$k] . "\n";
                    $counter++;
                }//foreach
//$me ssage = "10|$topUpAmountsMenu|null|null|null|$topUpAmountsMenu";
                $this->displayText = $topUpAmountsMenu;
                $this->saveSessionVar('extra', $topUpAmountsMenu);
                $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
                $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
                $this->saveSessionVar("utilityBillAccountNo", $this->_msisdn);
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-main";
                $this->sessionState = "CONTINUE";
            } elseif ($input == $selectedVal) {
                $arrLen = count($this->mnoMenuList);
                $menuList = "";
                $counter = 1;
                foreach ($this->mnoMenuList as $k => $v) {
                    $menuList .= $counter . ': ' . $this->mnoMenuList[$k] . "\n";
                    $counter++;
                }//foreach

                $this->displayText = "Select the network of the recipient's phone number\n$menuList";
                $this->saveSessionVar('extra', $menuList);
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "topup-other-main";
                $this->sessionState = "CONTINUE";
            } elseif ($input < 1 || $input > $size + 1) {
                $this->displayText = "Invalid entry. Select service: \n$this->CBSservices";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRequest";
            } else {
                $accounts = $this->getSessionVar('storedAccountNumbers');
                $arrLen = count($this->topupAmounts);
                $topUpAmountsMenu = "Select " . $this->MNOcodes[$this->customerNetOperator] . " top up amount:\n";

                $counter = 1;
                foreach ($this->topupAmounts as $k => $v) {
                    $topUpAmountsMenu .= $counter . ': ' . $this->topupAmounts[$k] . "\n";
                    $counter++;
                }//foreach
//$me ssage = "10|$topUpAmountsMenu|null|null|null|$topUpAmountsMenu";
                $this->displayText = $topUpAmountsMenu;
                $this->saveSessionVar('extra', $topUpAmountsMenu);
                $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
                $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-main";
                $this->sessionState = "CONTINUE";

                $this->saveSessionVar('flavour', 'enrolled');
                $this->saveSessionVar('recMSISDN', $selection[$input - 2]);
                $this->saveSessionVar('airtimeMSISDN', $selection[$input - 2]);
                $this->saveSessionVar('utilityBillAccountNo', $selection[$input - 2]);
                $this->sessionState = "CONTINUE";
//$this->previousPage = "processAirtime";
//$this->nextFunction = "processAirtimeSelf";
                $this->saveSessionVar("mpesaTo", "nomination");
                $this->saveSessionVar('billEnrolmentNumber', $selection[$input - 2]);
                $this->saveSessionVar("utilityBillAccountNo", $this->getSessionVar('storedAirtimeAlias'));

                $this->saveSessionVar('billEnrolment', 'NO');
                $this->saveSessionVar('nominationAlias', $selection[$input - 2]);


                /*
                  $arrLen = count($this->topupAmounts);
                  $topUpAmountsMenu = "Select " . $this->MNOcodes[$this->customerNetOperator] . " top up amount:\n";

                  $counter = 1;
                  foreach ($this->topupAmounts as $k => $v) {
                  $topUpAmountsMenu .= $counter . ': ' . $this->topupAmounts[$k] . "\n";
                  $counter++;
                  }//foreach
                  //$me ssage = "10|$topUpAmountsMenu|null|null|null|$topUpAmountsMenu";
                  $this->displayText = $topUpAmountsMenu;
                  $this->saveSessionVar('extra', $topUpAmountsMenu);
                  $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
                  $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
                  $this->nextFunction = "processAirtimeSelf";
                  $this->previousPage = "self-top-up-main";
                  $this->sessionState = "CONTINUE";

                 */
            }
        } elseif ($this->previousPage == "processSendMoneyCard") {
            $customerMSISDNLength = strlen($input);
//validate msisdn
            if ($customerMSISDNLength == 10) {
                $this->saveSessionVar('cardRecMSISDN', $input);
                $this->saveSessionVar('cardFTRecipient', $input);
                $this->saveSessionvar('selectedAccountNumber', $input);
                $this->saveSessionVar('isNomination', 'no');
                $this->displayText = "Enter an amount between UGX $this->MINCARDTRANSFER and UGX $this->MAXCARDTRANSFER:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyCardAmount";
                $this->nextFunction = "processSendMoney";
            } else {
                $this->displayText = "Invalid mobile number. Enter 10 digit mobile number in the format 07XX:";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyCard";
                $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "processOtherCard") {
            switch ($input) {
                case 1 :
                    $this->saveSessionVar("cardType", "nakumattGlobal");
                    break;
                default :
//$this->displayText = "Invalid selection. Select card to send money to:\n1. Nakumatt Global\n2: Mi Card ";
                    $this->displayText = "Invalid selection. Select card to send money to:\n1. Nakumatt Global";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processOtherCard";
                    $this->nextFunction = "processSendMoney";
            }

            $this->displayText = "Enter mobile number:";
            $this->_msisdn = $this->$input;
            $this->sessionState = "CONTINUE";
            $this->previousPage = "processOtherCardMobileNumber";
            $this->nextFunction = "processSendMoney";
            $this->sessionState = "CONTINUE";
        } elseif ($this->previousPage == "processOtherCardMobileNumber") {
            $this->saveSessionVar('cardFTRecipient', $input);
            $this->saveSessionvar('selectedAccountNumber', $input);
            $this->displayText = "Enter an amount between UGX $this->MINCARDTRANSFER and UGX $this->MAXCARDTRANSFER:";
            $this->saveSessionVar('cardRecMSISDN', $input);
            $this->sessionState = "CONTINUE";
            $this->previousPage = "processSendMoneyCardAmount";
            $this->nextFunction = "processSendMoney";
        } elseif ($this->previousPage == "processSendMoneyAmount") {

            if (!is_numeric($input) || $input < $this->MINMPESATRANSFER || $input > $this->MAXMPESATRANSFER) {
                $this->displayText = "Incorrect amount. Please enter an amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                $this->nextFunction = "processSendMoney";
                $this->previousPage = "processSendMoneyAmount";
                $this->sessionState = "CONTINUE";
            } else {
                /*
                 * $this->saveSessionVar('mpesaAmt', $input) ; if ($this->getSessionVar ( "mpesaTo" ) == 'other') { $this->displayText = "Would you like to save this account?\n1: Yes\n2: No"; $this->previousPage = "enrollMpesa"; $this->nextFunction = "processSendMoney"; $this->sessionState = "CONTINUE"; } elseif ($this->getSessioVar ( "mpesaTo" ) == 'nomination') { $amt = $this->getSessionVar('mpesaAmt'); $this->displayText = "Please confirm that you would like to transfer UGX $amt to MPESA account for [selected nomination].\n1: Yes\n2: No"; $this->previousPage = "processConfirmedSendMoney"; $this->nextFunction = "processSendMoney"; $this->sessionState = "CONTINUE"; $this->saveSessionVar ( "confirmSendMoney", "mpesa" ); $this->saveSessionVar ( "mpesaAmount", $input ); } else { $amt = $this->getSessionVar('mpesaAmt'); $this->displayText = "Please confirm that you would like to transfer UGX $amt to MPESA account for mobile number $this->_msisdn.\n1: Yes\n2: No"; $this->previousPage = "processConfirmedSendMoney"; $this->nextFunction = "processSendMoney"; $this->sessionState = "CONTINUE"; $this->saveSessionVar ( "confirmSendMoney", "mpesa" ); $this->saveSessionVar ( "mpesaAmount", $input ); }
                 */
                $this->saveSessionVar("vmpesaAmt", $input);
                $this->saveSessionVar('tigoPesaAmt', $input);
                $this->saveSessionVar("airtelMoneyAmt", $input);
                $this->saveSessionVar('utilityBillAmount', $input);
                $this->saveSessionVar('amount', $input);
                $vmpesaTo = $this->getSessionVar("vmpesaTo");
                $tigoPesaTo = $this->getSessionVar("tigoPesaTo");
                $airtelMoneyTo = $this->getSessionVar("airtelMoneyTo");
                $mpesaRecipient = $this->getSessionVar('recMSISDN');

                if ($vmpesaTo == 'other') {

//                    $amt = $this->getSessionVar('vmpesaAmt');
//                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the M-PESA account for mobile number $this->_msisdn.\n1: Yes\n2: No";
//                    $this->saveSessionVar('vmpesaRecipient', $this->_msisdn);
//                    $this->previousPage = "processConfirmedSendMoney";
//                    $this->nextFunction = "processSendMoney";
//                    $this->sessionState = "CONTINUE";
//                    $this->saveSessionVar("confirmSendMoney", "mpesa");
//                    $this->saveSessionVar("mpesaAmount", $input);
                    $amt = $this->getSessionVar('vmpesaAmt');
                    $this->displayText = "Do you wish to save this number for future use? \n1: Yes\n2: No";
                    $this->previousPage = 'enrollMpesa';
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
//$this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("confirmSendMoney", "vmpesa");
                } elseif ($tigoPesaTo == 'other') {
//$mpesaRecipient = $this->getSessionVar('recMSISDN');
                    $amt = $this->getSessionVar('tigoPesaAmt');
//$this->displayText = "Please confirm that you would like to transfer UGX $amt to the MPESA account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                    $this->displayText = "Do you wish to save this number for future use? \n1: Yes\n2: No";
//$this->previousPage = "processConfirmedSendMoney";
//$this->previousPage = 'enrollMpesa';
                    $this->previousPage = 'enrollTigoPesa';
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
//$this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("confirmSendMoney", "tigoPesa");
                } elseif ($airtelMoneyTo == "other") {
                    $amt = $this->getSessionVar('airtelMoneyAmt');
                    $this->displayText = "Do you wish to save this number for future use? \n1: Yes\n2: No";
                    $this->previousPage = 'enrollAirtelMoney';
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
//$this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("confirmSendMoney", "airtelMoneyAmt");
                } elseif ($mpesaTo == "nomination") {
                    $amt = $this->getSessionVar('tigoPesaAmt');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the MTN Mobile Money account for $mpesaRecipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                } elseif ($vmpesaTo == "self") {
                    $amt = $this->getSessionVar('vmpesaAmt');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the MTN Mobile Money account for mobile number $this->_msisdn.\n1: Yes\n2: No";
                    $this->saveSessionVar('vmpesaRecipient', $this->_msisdn);
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                } elseif ($tigoPesaTo == "self") {

                    $amt = $this->getSessionVar('tigoPesaAmt');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the Airtel Money account for mobile number $this->_msisdn.\n1: Yes\n2: No";
                    $this->saveSessionVar('tigoPesaRecipient', $this->_msisdn);
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                } else if ($airtelMoneyTo == "self") {
                    $amt = $this->getSessionVar('airtelMoneyAmt');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the Airtel Money account for mobile number $this->_msisdn.\n1: Yes\n2: No";
                    $this->saveSessionVar('airtelMoneyRecipient', $this->_msisdn);
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("airtelMoneyAmount", $input);
                }
            }
        } elseif ($this->previousPage == "enrollMpesa") {
            switch ($input) {

                case 1 :
                    $this->displayText = "Please enter a nickname for this account, eg John";
                    $this->previousPage = "saveMpesaEnrollment";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar('billEnrolment', 'yes');
                    $this->saveSessionVar('nominatedAlias', $input);
                    $this->sessionState = "CONTINUE";
                    break;
                case 2 :
                    $alias = $this->getSessionVar('nominatedAlias');
                    $amt = $this->getSessionVar('vmpesaAmt');
                    $mpesaRecipient = $this->getSessionVar('recMSISDN');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the MTN account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar("alias", "null");
                    break;
                default :
                    $this->displayText = "Invalid selection mpesa. Please enter \n1: Yes\n2: No";
                    $this->previousPage = "enrollMpesa";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "enrollTigoPesa") {
            switch ($input) {
                case 1 :
                    $this->displayText = "Please enter a nickname for this account, eg John";
                    $this->previousPage = "saveTigoPesaEnrollment";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar('billEnrolment', 'yes');
                    $this->saveSessionVar('nominatedAlias', $input);
                    $this->sessionState = "CONTINUE";
                    break;
                case 2 :
                    $alias = $this->getSessionVar('nominatedAlias');
                    $amt = $this->getSessionVar('mpesaAmt');
                    $mpesaRecipient = $this->getSessionVar('recMSISDN');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the Airtel Money account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar("alias", "null");
                    break;
                default :
                    $this->displayText = "Invalid selection biss. Please enter \n1: Yes\n2: No";
                    $this->previousPage = "enrollTigoPesa";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "enrollAirtelMoney") {

            switch ($input) {
                case 1 :
                    $this->displayText = "Please enter a nickname  for this account, eg John";
                    $this->previousPage = "saveAirtelMoneyEnrollment";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar('billEnrolment', 'yes');
                    $this->saveSessionVar('nominatedAlias', $input);
                    $this->sessionState = "CONTINUE";
                    break;
                case 2 :
                    $alias = $this->getSessionVar('nominatedAlias');
                    $amt = $this->getSessionVar('airtelMoneyAmt');
                    $mpesaRecipient = $this->getSessionVar('recMSISDN');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to the Airtel Money account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "mpesa");
                    $this->saveSessionVar("mpesaAmount", $input);
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar("alias", "null");
                    break;
                default :
                    $this->displayText = "Invalid selection bissst. Please enter \n1: Yes\n2: No";
                    $this->previousPage = "enrollAirtelMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "enrollCard") {
            switch ($input) {
                case 1 :
                    $this->displayText = "Please enter a nickname for this account, eg Polly";
                    $this->previousPage = "enterNarration";
                    $this->nextFunction = "processSendMoney";
                    $this->saveSessionVar('nomination', "YES");
                    $this->saveSessionVar("amount", $this->getSessionVar('cardTransferAmt'));
                    $this->sessionState = "CONTINUE";
                    break;
                case 2 :
                    $this->displayText = "Please enter a payment reason";
                    $this->previousPage = "enterNarrationNoEnrollment"; //"processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";

                    break;
                default :
                    $this->displayText = "Invalid selection no. Please enter \n1: Yes\2:No";
                    $this->previousPage = "enroll";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "saveMpesaEnrollment") {

            $nominationdata = $this->clientProfile ['profileNominations'];
            $nominationCount = false;

            foreach ($nominationdata as $value) {
                if ($value ['alias'] == $input) {
                    $nominationCount == true;
                } else {
                    $nominationCount == false;
                }
            }
            if (!$nominationCount) {
                $mpesaRecipient = $this->getSessionVar('recMSISDN');
                $amt = $this->getSessionVar('vmpesaAmt');
                $this->saveSessionVar('billEnrolmentNumber', $input);
                $this->displayText = "Please confirm that you would like to transfer UGX $amt to the M-PESA account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                $this->previousPage = "processConfirmedSendMoney";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar("confirmSendMoney", "mpesa");
                $mpesaAmt = $this->getSessionVar("mpesaTransferAmount");
                $this->saveSessionVar('alias', $input);
                $this->saveSessionVar("mpesaAmount", $mpesaAmt);
            } else {
                $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for mobile number '$_msisdn'";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "saveTigoPesaEnrollment") {

            $nominationdata = $this->clientProfile ['profileNominations'];
            $nominationCount = false;

            foreach ($nominationdata as $value) {
                if ($value ['alias'] == $input) {
                    $nominationCount == true;
                } else {
                    $nominationCount == false;
                }
            }
            if (!$nominationCount) {
                $mpesaRecipient = $this->getSessionVar('recMSISDN');
                $amt = $this->getSessionVar('tigoPesaAmt');
                $this->saveSessionVar('billEnrolmentNumber', $input);
                $this->displayText = "Please confirm that you would like to transfer UGX $amt to the TIGO PESA account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                $this->previousPage = "processConfirmedSendMoney";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar("confirmSendMoney", "mpesa");
                $mpesaAmt = $this->getSessionVar("mpesaTransferAmount");
                $this->saveSessionVar('alias', $input);
                $this->saveSessionVar("mpesaAmount", $mpesaAmt);
            } else {
                $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for mobile number '$_msisdn'";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "saveAirtelMoneyEnrollment") {


            $nominationdata = $this->clientProfile ['profileNominations'];
            $nominationCount = false;

            foreach ($nominationdata as $value) {
                if ($value ['alias'] == $input) {
                    $nominationCount == true;
                } else {
                    $nominationCount == false;
                }
            }
            if (!$nominationCount) {
                $mpesaRecipient = $this->getSessionVar('recMSISDN');
                $amt = $this->getSessionVar('airtelMoneyAmt');
                $this->saveSessionVar('billEnrolmentNumber', $input);
                $this->displayText = "Please confirm that you would like to transfer UGX $amt to the Airtel Money account for mobile number $mpesaRecipient.\n1: Yes\n2: No";
                $this->previousPage = "processConfirmedSendMoney";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar("confirmSendMoney", "mpesa");
                $mpesaAmt = $this->getSessionVar("mpesaTransferAmount");
                $this->saveSessionVar('alias', $input);
                $this->saveSessionVar("mpesaAmount", $mpesaAmt);
            } else {
                $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for mobile number '$_msisdn'";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "processSendMoneyAmount";
                $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "saveCardEnrollment") {
            $nominationdata = $this->clientProfile ['profileNominations'];
            $nominationCount = false;

            foreach ($nominationdata as $value) {
                if ($value ['alias'] == $input) {
                    $nominationCount == true;
                } else {
                    $nominationCount == false;
                }
            }
            if (!$nominationCount) {
                if (!isset($input) || $input == NULL || strlen($input) > DTBUGconfigs::MAX_NARRATION_LENGTH) {
                    $this->displayText = "Reason cannot exceed 50 letters \nPlease re-enter a payment reason";
                    $this->previousPage = "saveCardEnrollment"; //"processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                } else {
                    $cardRec = $this->getSessionVar('cardRecMSISDN');
                    $amt = $this->getSessionVar('cardTransferAmt');
                    $this->displayText = "Please confirm that you would like to transfer UGX $amt to $cardRec. Reason: $input \n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmSendMoney", "card");
                    $this->saveSessionVar('nominationReason', $input);
//$this->saveSessionVar("amount", $input);
                }
            } else {
                $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for mobile number '$_msisdn'";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "enrollCard";
                $this->nextFunction = "processSendMoney";
            }
        } elseif ($this->previousPage == "enterNarrationNoEnrollment") {
            if (!isset($input) || $input == NULL || strlen($input) > DTBUGconfigs::MAX_NARRATION_LENGTH) {
                $this->displayText = "Reason cannot exceed 50 letters \nPlease re-enter a payment reason";
                $this->previousPage = "enterNarrationNoEnrollment"; //"processConfirmedSendMoney";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
            } else {
                $this->saveSessionVar('nominationReason', $input);
                $amt = $this->getSessionVar('cardTransferAmt');
                $cardRec = $this->getSessionVar('cardRecMSISDN');
                $this->displayText = "Please confirm that you would like to transfer UGX $amt to $cardRec. Reason: $input \n1: Yes\n2: No";
                $this->previousPage = "processConfirmedSendMoney";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar("confirmSendMoney", "card");
                $this->saveSessionVar("amount", $amt);
                $this->saveSessionVar('nomination', "NO");
                $this->saveSessionVar("alias", "null");
            }
        } elseif ($this->previousPage == "enterNarration") {
            $this->displayText = "Enter the transfer reason";
            $this->nextFunction = "processSendMoney";
            $this->previousPage = "saveCardEnrollment"; //"processSendMoneyCardAmount";
            $this->saveSessionVar('nominationAlias', $input);
            $this->sessionState = "CONTINUE";
        } elseif ($this->previousPage == "enterBranchCode") {
            $this->displayText = "Please enter an amount: between $this->MINMPESATRANSFER and $this->MAXMPESATRANSFER";
            $this->nextFunction = "processSendMoney";
            $this->previousPage = "processSendMoneyDTBAmount"; //"processSendMoneyCardAmount";
            $this->saveSessionVar('branchid', $input);
            $this->saveSessionVar('isNomination', 'no');
            $this->saveSessionVar('extra', 'branchCode-enrol');
            $this->sessionState = "CONTINUE";
        } elseif ($this->previousPage == "processSendMoneyCardAmount") {
            if ((!is_numeric($input) || $input < $this->MINCARDTRANSFER || $input > $this->MAXCARDTRANSFER) && $this->getSessionVar('extra') != 'branchCode-enrol') {
                $this->displayText = "Incorrect amount. Please enter an amount between UGX $this->MINCARDTRANSFER and UGX $this->MAXCARDTRANSFER";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
            } else {
                $transferType = $this->getSessionVar('transferType');

                if ($transferType == 'accToCard' || $transferType == 'accToMpesa') {
                    if ($this->getSessionVar('extra') == 'branchCode-enrol' || $this->getSessionVar('extra') == 'cardEnrol') {
                        $this->saveSessionVar('nomination', "NO");
                        $this->saveSessionVar('amount', $input);
                        $this->saveSessionVar('otherCardAmt', $input);
                        $this->saveSessionVar('cardTransferAmt', $input);
                        $this->saveSessionVar('alias', 'NULL');
                        $this->saveSessionVar('nominationAlias', 'NULL');
                        if ($transferType == 'accToCard') {
                            $this->saveSessionVar('cardTransferAmt', $input);
                        } elseif ($transferType == 'accToAcc') {
                            $this->saveSessionVar('branchCode', $input);
                        }
//$this->saveSessionVar('cardTransferAmt', $input);
                        $this->saveSessionVar('amount', $input);
                        $this->displayText = "Would you like to save this account for future use?\n1: Yes\n2: No";
                        $this->previousPage = "enrollCard";
//$recipient = $this->getSessionVar('cardRecMSISDN');
//$this->displayText = "Please confirm that you would like to transfer UGX $input to the card for mobile number $recipient.\n1: Yes\n2: No";
//$this->previousPage = "processConfirmedSendMoney";
                        $this->nextFunction = "processSendMoney";
                        $this->sessionState = "CONTINUE";
                    } else {
//$this->displayText = "Please enter branch code:";
                        $this->displayText = "Please enter an amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER:";
                        $this->nextFunction = "processSendMoney";
//$this->saveSessionVar('branchCode', $input);
                        /* $this->saveSessionVar('amount', $input);
                          $this->saveSessionVar('otherCardAmt', $input);
                          $this->saveSessionVar('cardTransferAmt', $input); */
                        $this->saveSessionVar('extra', 'branchCode-enrol');
                        $this->sessionState = "CONTINUE";
                    }
                } else {
// $this->displayText = "Please confirm that you would like to transfer UGX $input to card account for mobile number $this->_msisdn.\n1: Yes\n2: No";
//$this->saveSessionVar('otherCardAmt', $input);
//$this->saveSessionVar('amount', $input);
//$this->saveSessionVar('cardTransferAmt', $input);
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar("alias", "NULL");
//$this->displayText = "Would you like to save this account for future use?\n1: Yes\n2: No";
//$this->previousPage = "enrollCard";
                    $this->saveSessionVar('otherCardAmt', $input);
                    $this->saveSessionVar('amount', $input);
                    $this->saveSessionVar('cardTransferAmt', $input);
                    $recipient = $this->getSessionVar('cardRecMSISDN');
                    $this->saveSessionVar('selectedAccountNumber', $recipient);
                    $this->displayText = "Please confirm that you would like to transfer UGX $input to $recipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                }
                /*
                 * $this->previousPage = "processConfirmedSendMoney"; $this->nextFunction = "processSendMoney"; $this->sessionState = "CONTINUE"; $this->saveSessionVar ( "confirmSendMoney", "card" ); $this->saveSessionVar ( "amount", $input );
                 */
            }
        } elseif ($this->previousPage == "processSendMoneyDTBAmount") {

            /* if ((!is_numeric($input) || $input < $this->MINFTTRANSFER || $input > $this->MAXFTTRANSFER) && $this->getSessionVar('extra') != 'branchCode-enrol') { */
            if ($input < $this->MINFTTRANSFER || $input > $this->MAXFTTRANSFER || !is_numeric($input)) {
                $this->displayText = "Incorrect amount. Please enter an amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
            } else {
                $transferType = $this->getSessionVar('transferType');

                if ($transferType == 'accToAcc' || $transferType == 'accToCard' || $transferType == 'accToMpesa') {
                    if ($this->getSessionVar('extra') == 'branchCode-enrol' || $this->getSessionVar('extra') == 'cardEnrol') {
                        $this->saveSessionVar('nomination', "NO");
                        $this->saveSessionVar('amount', $input);
                        $this->saveSessionVar('otherCardAmt', $input);
                        $this->saveSessionVar('cardTransferAmt', $input);
                        $this->saveSessionVar('alias', 'NULL');
                        $this->saveSessionVar('nominationAlias', 'NULL');
                        /*   if($transferType == 'accToCard'){
                          $this->saveSessionVar('cardTransferAmt', $input);
                          }
                          elseif ($transferType == 'accToAcc'){
                          $this->saveSessionVar('branchCode', $input);
                          } */
//$this->saveSessionVar('cardTransferAmt', $input);
                        $this->saveSessionVar('amount', $input);
                        $this->displayText = "Would you like to save this account for future use?\n1: Yes\n2: No";
                        $this->previousPage = "enrollCard";
//$recipient = $this->getSessionVar('cardRecMSISDN');
//$this->displayText = "Please confirm that you would like to transfer UGX $input to the card for mobile number $recipient.\n1: Yes\n2: No";
//$this->previousPage = "processConfirmedSendMoney";
                        $this->nextFunction = "processSendMoney";
                        $this->sessionState = "CONTINUE";
                    } else {
//$this->displayText = "Please enter branch code:";
                        $this->displayText = "Please enter an amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER:";
                        $this->nextFunction = "processSendMoney";
//$this->saveSessionVar('branchCode', $input);
                        /* $this->saveSessionVar('amount', $input);
                          $this->saveSessionVar('otherCardAmt', $input);
                          $this->saveSessionVar('cardTransferAmt', $input); */
                        $this->saveSessionVar('extra', 'branchCode-enrol');
                        $this->sessionState = "CONTINUE";
                    }
                } else {
// $this->displayText = "Please confirm that you would like to transfer UGX $input to card account for mobile number $this->_msisdn.\n1: Yes\n2: No";
//$this->saveSessionVar('otherCardAmt', $input);
//$this->saveSessionVar('amount', $input);
//$this->saveSessionVar('cardTransferAmt', $input);
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar("alias", "NULL");
//$this->displayText = "Would you like to save this account for future use?\n1: Yes\n2: No";
//$this->previousPage = "enrollCard";
                    $this->saveSessionVar('otherCardAmt', $input);
                    $this->saveSessionVar('amount', $input);
                    $this->saveSessionVar('cardTransferAmt', $input);
                    $recipient = $this->getSessionVar('cardRecMSISDN');
                    $this->saveSessionVar('selectedAccountNumber', $recipient);
                    $this->displayText = "Please confirm that you would like to transfer UGX $input to $recipient.\n1: Yes\n2: No";
                    $this->previousPage = "processConfirmedSendMoney";
                    $this->nextFunction = "processSendMoney";
                    $this->sessionState = "CONTINUE";
                }
                /*
                 * $this->previousPage = "processConfirmedSendMoney"; $this->nextFunction = "processSendMoney"; $this->sessionState = "CONTINUE"; $this->saveSessionVar ( "confirmSendMoney", "card" ); $this->saveSessionVar ( "amount", $input );
                 */
            }
        } elseif ($this->previousPage == "enterDTBAccount") {
            $this->saveSessionVar('flavour', 'open');
            $this->displayText = "Please enter the account number";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "processSendToDTBAccount";
            $this->nextFunction = "processSendMoney";
        } elseif ($this->previousPage == "processSendToDTBAccount") {
            if (strlen($input) != 10) {
                $this->displayText = "Incorrect account number. Please enter the correct 10 digit account number:";
                $this->nextFunction = "processSendMoney";
                $this->sessionState = "CONTINUE";
            } else {
                $this->saveSessionVar('cardFTRecipient', $input);
                $this->saveSessionVar('selectedAccountNumber', $input);
                $this->saveSessionVar('cardRecMSISDN', $input);
                $this->saveSessionvar('transferType', 'accToAcc');
                $this->displayText = "Please enter an amount between $this->MINFTTRANSFER and $this->MAXFTTRANSFER";
                $this->nextFunction = "processSendMoney";
                $this->previousPage = "processSendMoneyDTBAmount"; //"processSendMoneyCardAmount";
                $this->saveSessionVar('branchid', $input);
                $this->saveSessionVar('isNomination', 'no');
                $this->saveSessionVar('extra', 'branchCode-enrol');
                $this->sessionState = "CONTINUE";

//$this->displayText = "Enter an amount between UGX $this->MINFTTRANSFER and UGX $this->MAXFTTRANSFER:";
                /*  $this->displayText = "Enter the branch code";
                  $this->sessionState = "CONTINUE";
                  $this->previousPage = "enterBranchCode";//"processSendMoneyCardAmount";
                  $this->nextFunction = "processSendMoney";
                  $this->saveSessionVar("confirmSendMoney", "internalFT"); */
            }
        }
    }

    function processRTGS($input) {
        if ($this->previousPage == 'rtgsBeneSelection') {
            if ($input == 99) {
                $pagenumber = $this->getSessionVar('pagenumber');

                if ($pagenumber == 1) {
                    $arr = $this->rtgsItems();
                    $i = 8;
                    $rtgsMenu = "";
                    while ($i < 15) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 2);
                }
                if ($pagenumber == 2) {
                    $arr = $this->rtgsItems();
                    $i = 15;
                    $rtgsMenu = "";
                    while ($i < 22) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 3);
                }

                if ($pagenumber == 3) {
                    $arr = $this->rtgsItems();
                    $i = 22;
                    $rtgsMenu = "";
                    while ($i < 29) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 4);
                }

                if ($pagenumber == 4) {
                    $arr = $this->rtgsItems();
                    $i = 29;
                    $rtgsMenu = "";
                    while ($i < 36) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 5);
                }

                if ($pagenumber == 5) {
                    $arr = $this->rtgsItems();
                    $i = 36;
                    $rtgsMenu = "";
                    while ($i < 43) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 6);
                }
//$this->saveSessionVar('serviceID', '93');
                $this->sessionState = "CONTINUE";
                $this->previousPage = "rtgsBeneSelection";
                $this->nextFunction = "processRTGS";
            } else if ($input == 97) {
                $pagenumber = $this->getSessionVar('pagenumber');
                if ($pagenumber == 2) {
                    $arr = $this->rtgsItems();
                    $i = 1;
                    $rtgsMenu = "";
                    while ($i < 8) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks";
                    $this->saveSessionVar('pagenumber', 1);
                }
                if ($pagenumber == 3) {
                    $arr = $this->rtgsItems();
                    $i = 8;
                    $rtgsMenu = "";
                    while ($i < 15) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 2);
                }
                if ($pagenumber == 4) {
                    $arr = $this->rtgsItems();
                    $i = 15;
                    $rtgsMenu = "";
                    while ($i < 22) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 3);
                }
                if ($pagenumber == 5) {
                    $arr = $this->rtgsItems();
                    $i = 22;
                    $rtgsMenu = "";
                    while ($i < 29) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 4);
                }
                if ($pagenumber == 6) {
                    $arr = $this->rtgsItems();
                    $i = 29;
                    $rtgsMenu = "";
                    while ($i < 36) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 5);
                }
                if ($pagenumber == 7) {
                    $arr = $this->rtgsItems();
                    $i = 36;
                    $rtgsMenu = "";
                    while ($i < 43) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n97.Go Back";
                    $this->saveSessionVar('pagenumber', 3);
                }
//$this->saveSessionVar('serviceID', '93');
                $this->sessionState = "CONTINUE";
                $this->previousPage = "rtgsBeneSelection";
                $this->nextFunction = "processRTGS";
            } else {
                if ($input > 43) {
                    $arr = $this->rtgsItems();
                    $i = 1;
                    $rtgsMenu = "";
                    while ($i < 16) {
                        $rtgsMenu .= "\n$i." . $arr[$i][1];
                        $i++;
                    }
                    $this->saveSessionVar('pagenumber', 1);
                    $this->displayText = "Invalid Entry. Enter Beneficiary's Bank $rtgsMenu \n99. more";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "rtgsBeneSelection";
                    $this->nextFunction = "processRTGS";
                } else {
                    $this->saveSessionVar('rtgsRecipientBank', $input);
                    $this->displayText = "Enter beneficiary account number";
                    $this->previousPage = "rtgsBeneAccount";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processRTGS";
                }
            }
        } elseif ($this->previousPage == "rtgsBeneAccount") {
            $this->saveSessionVar('rtgsRecipientAccount', $input);
            $this->displayText = "Enter recipient's full Name";
            $this->previousPage = "rtgsSenderName";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processRTGS";
        } elseif ($this->previousPage == "rtgsSenderName") {
            $this->saveSessionVar('rtgsRecipientName', $input);
            $this->displayText = "Enter the purpose";
            $this->previousPage = "rtgsPurpose";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processRTGS";
        } elseif ($this->previousPage == "beneficiaryPurpose") {

            $this->displayText = "Enter the purpose";
            $this->previousPage = "rtgsPurpose";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processRTGS";
        } elseif ($this->previousPage == "rtgsPurpose") {
            $this->saveSessionVar('rtgsPurpose', $input);
            $this->displayText = "Enter the amount to transfer between 1 and 500,000 ";
            $this->previousPage = "rtgsAmount";
            $this->sessionState = "CONTINUE";
//check one
            $this->nextFunction = "processRTGS";
        } else if ($this->previousPage == "rtgsAmount") {
            if ($input < 1 or $input > 500000) {
                $this->displayText = "Invalid Entry. Enter the amount to transfer between 1 and 500,000 ";
                $this->previousPage = "rtgsAmount";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRTGS";
            } else {
                if ($this->getSessionVar('nominating') == 'NO') {
                    $clientAccounts = $this->getSessionVar('clientAccounts');
                    $accountIDs = $this->getSessionVar('storedAccountID');

                    $this->saveSessionVar('rtgsAmount', $input);
                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->previousPage = "selectAccount";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                } else {
                    $this->saveSessionVar('rtgsAmount', $input);
                    $this->displayText = "Would you like to save this account for future use?\n1: Yes\n2: No";
                    $this->previousPage = "rtgsBene";
                    $this->nextFunction = "processRTGS";
                    $this->sessionState = "CONTINUE";
                }
            }
        } elseif ($this->previousPage == "rtgsBene") {
            if ($input == 1 || $input == 2) {
                if ($input == 1) {
                    $this->saveSessionVar('nominating', 'YES');
// $this->saveSessionVar('rtgsAmount', $input);
                    $this->displayText = "Please Enter the Account Alias";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "rtgsNominate";
                    $this->nextFunction = "processRTGS";
                }if ($input == 2) {
                    $this->saveSessionVar('nominating', 'NO');
                    $clientAccounts = $this->getSessionVar('clientAccounts');
                    $accountIDs = $this->getSessionVar('storedAccountID');

// $this->saveSessionVar('rtgsAmount', $input);
                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->previousPage = "selectAccount";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                }
            } else {
                $this->displayText = "You entered incorrectly";
            }
        } elseif ($this->previousPage == "rtgsNominate") {
            $clientAccounts = $this->getSessionVar('clientAccounts');
            $accountIDs = $this->getSessionVar('storedAccountID');

            $this->saveSessionVar('nominationAlias', $input);
            $this->displayText = "Select account:\n" . $clientAccounts;
            $this->previousPage = "selectAccount";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } elseif ($this->previousPage == "nominationexist") {
            $displayedAliases = $this->getSessionVar("availableAliases");
            $storedAccountNumbers = $this->getSessionVar("storedAccountNumbers");
            $rtgsbeneficiaryNames = $this->getSessionVar("rtgsbeneficiaryNames");
            $rtgsbenebanks = $this->getSessionVar("rtgsbenebanks");
            $rtgsbenebankSwiftcodes = $this->getSessionVar("rtgsbenebankSwiftcodes");


            $size = sizeof($displayedAliases);
            $selectedVal = $size + 1;



            if ($input == $selectedVal) {
                $arr = $this->rtgsItems();
                $i = 1;
                $rtgsMenu = "";
                while ($i < 8) {
                    $rtgsMenu .= "\n$i." . $arr[$i][1];
                    $i++;
                }
                $this->displayText = "Enter Beneficiary's Bank $rtgsMenu \n99.More Banks";

                $this->saveSessionVar('serviceID', '93');
                $this->saveSessionVar('pagenumber', '1');
                $this->sessionState = "CONTINUE";
                $this->previousPage = "rtgsBeneSelection";
                $this->nextFunction = "processRTGS";
            } elseif ($input < 1 || $input > $size) {
                $invalidRTGS = $this->getSessionVar('invalidRTGS');
                $this->displayText = "invalid selection, please select account:\n $invalidRTGS";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRTGS";
            } else {

//truther
                $this->saveSessionVar('flavour', 'open');
//$this->saveSessionVar('cardRecMSISDN', $selection[$input - 1]);
                $this->sessionState = "CONTINUE";
// $this->previousPage = "beneficiaryPurpose";
                $this->saveSessionVar('selectedAccountNumber', $storedAccountNumbers[$input - 1]);
                $this->saveSessionVar('selectedBeneName', $rtgsbeneficiaryNames[$input - 1]);
                $this->saveSessionVar('selectedBenebank', $rtgsbenebanks[$input - 1]);
                $this->saveSessionVar('selectedBenebankSwiftCode', $rtgsbenebankSwiftcodes[$input - 1]);
// $this->displayText = "Invalid entry. Select services";

                $this->saveSessionVar('IsExistingBene', 'YES');
// $this->nextFunction = "processRTGS";
                $this->saveSessionVar("mpesaTo", "nomination");
                $currentAlias = $this->getSessionVar('alias');
                $this->saveSessionVar('nominationAlias', 'null');
                $this->saveSessionVar('nominating', 'NO');
                $this->displayText = "Enter the purpose";
                $this->previousPage = "rtgsPurpose";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processRTGS";
            }
        }
    }

    function processReceiveMoney($input) {


        if ($this->previousPage == "receiveMoneyProcess") {

            switch ($input) {
                case 1 :
                    $this->displayText = "Enter your MTCN";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "receiveMoneyMTCN";
                    $this->saveSessionVar("receiveMTCN", $input);
                    $this->nextFunction = "processReceiveMoney";
                    break;
                case 2 :
                    $this->displayText = "Enter your MTCN";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "receiveMoneyMTCN";
                    $this->saveSessionVar("receiveMTCN", $input);
                    $this->nextFunction = "processReceiveMoney";
                    break;
                case 3 :

                    $this->displayText = "Enter your MTCN";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "receiveMoneyMTCN";
                    $this->saveSessionVar("receiveMTCN", $input);
                    $this->nextFunction = "processReceiveMoney";
                    break;

                default :
                    $this->displayText = "Invalid selection. Please select\n1: Western Union\n2: Money Gram\n3: Express Money";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "receiveMoneyProcess";
                    $this->nextFunction = "receiveMoney";
                    break;
            }
        } elseif ($this->previousPage == "receiveMoneyMTCN") {
            $this->displayText = "Enter the amount";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "receiveMoneyAmount";
            $this->saveSessionVar("receiveeAmount", $input);
            $this->nextFunction = "processReceiveMoney";
        } elseif ($this->previousPage == "receiveMoneyAmount") {
            $this->displayText = "Enter your ID number";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "receiveMoneyID";
            $this->saveSessionVar("receiveMoneyID", $input);
            $this->nextFunction = "processReceiveMoney";
        } elseif ($this->previousPage == "receiveMoneyID") {
            $this->displayText = "Please enter your PIN:";
            $this->sessionState = "CONTINUE";
            $this->saveSessionVar("origin", "receiveMoney");
            $this->nextFunction = "validatePin";
        }
    }

    function finalizeReceiveMoney() {
        $this->displayText = "finalizeReceiveMoney";
        $receivedMTCN = $this->getSessionVar("receiveMTCN");
        $receivedAddress = $this->getSessionVar("receiveAddress");
        $receivedAmount = $this->getSessionVar("receiveAmount");

        $accountDetails = $this->getSessionVar('accountID+accountAlias');

        $accountDetails = explode("*", $accountDetails);
        $accountID = $accountDetails [0];
        $accountAlias = $accountDetails [1];
        $alias = $this->getSessionVar('alias');

        $encryptedpin = $this->getSessionVar('encryptedPin');

        $receiveMoneyPayload = array(
            "serviceID" => $this->RECEIVEMONEYServiceID,
            "flavour" => "open",
            "pin" => $encryptedpin,
            "accountAlias" => $accountAlias,
            "amount" => $receivedAmount,
            // "columnA" => $accountID,
            "columnD" => $alias,
            "accountID" => $accountID,
            "nominate" => $nomination
        );

        $statusCode = 2;

// log request into channelRequests
        $successLog = $this->logChannelRequest($receiveMoneyPayload, $statusCode);

        if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
            $this->displayText = "Your receive money request has been received. $this->confirmatory $this->FULLBANKNAME";
            $this->sessionState = "END";
        } else {
            $this->displayText = "Sorry, an error occured when processing your receive money request. ";
            $this->sessionState = "END";
        }
    }

    /*
     * Process Secondary menu - More services
     */

    function processMoreBankingServices($input) {
        
    }

    /*
     * Vanilla Services - Option 5
     */

    function processVanilaServices() {
//$this->displayText = "processingVaniallaService";
        /* $vanillaService = getSessionVar ( 'vanillaService' );

          if ($vanillaService == "checkBalance") {
          $this->displayText = "vanillaService = checkBalance";
          $vanillaServiceID = $this->CBSBEServiceID;
          } elseif ($vanillaService == "getMinistatement") {
          $vanillaServiceID = $this->CBSMiniStatServiceID;
          } */

// Get account details
        $accountDetails = $this->getSessionVar('accountID+accountAlias');

        $accountDetails = explode("*", $accountDetails);
        $accountID = $accountDetails [0];
        $accountAlias = $accountDetails [1];

        $encryptedpin = $this->getSessionVar('encryptedPin');
        $vanillaServiceID = $this->getSessionVar('vanillaServiceID');

        if ($vanillaServiceID == $this->CBSBEServiceID) {
            $service = "balance enquiry";
        } elseif ($vanillaServiceID == $this->CBSMiniStatServiceID) {
            $service = "mini statement";
        }

        /**
         * Expected Payload
         *
         * <Payload><serviceID>10</serviceID><flavour>self</flavour>
         * <pin>313233343536373831323334353637388b2455518b3fc38c3231b24d
         * 12a4bfe5304e38e6bc44be069b60cc90ebdcad4b62963e2a53c230ca67feb
         * 79b7d</pin><accountAlias>main</accountAlias>
         * <accountID>1</accountID>
         * </Payload>
         */
// formulate specific payload for this service as key value array
        $vanillaServicePayloadArray = array(
            "serviceID" => $vanillaServiceID,
            "flavour" => "self",
            "pin" => $encryptedpin,
            "accountAlias" => $accountAlias,
            "accountID" => $accountID
        );

        $statusCode = 2;

// log request into channelRequests
        $successLog = $this->logChannelRequest($vanillaServicePayloadArray, $statusCode);

        if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
            $this->displayText = "Your $service request is being processed. $this->confirmatory";
            $this->sessionState = "END";
// $this->nextFunction = "selectBankingServices";
        } else {
            $this->displayText = "Sorry, an error occured when processing your request. ";
            $this->sessionState = "END";
        }
    }

    function confirmRequest($payloadArray) {
        $clientProfile = $this->fetchCustomerData();

        $clientProfiledata = explode('|', $clientProfile ['customerDetails']);
        $clientprofileID = $clientProfiledata [0];
        $profileactive = $clientProfiledata [1];
        $customeractive = $clientProfiledata [1];
        $profile_pin_status = $clientProfiledata ['2'];
        $customerNames = $clientProfiledata [3];
        $customerNames .= (($clientProfiledata [4] == "NULL" || $clientProfiledata [4] == "") ? "" : " " . $clientProfiledata [4]);

        $profileActiveStatus = $customeractive;
        $customerActiveStatus = $customeractive;

        $serviceList = "";
        $aliases = "";
        $this->saveSessionVar('accountDetails', $clientProfile ['accountDetails']);
        $this->saveSessionVar('enrolmentDetails', $clientProfile ['enrollmentDetails']);
        $this->saveSessionVar('nominationDetails', $clientProfile ['nominationDetails']);

        if ($clientprofileID != 0) {

            if ($profile_pin_status == 2) {
// customer presented with prompt to change one time pin
                $this->displayText = "Please change your One Time PIN and try again.";
                $this->sessionState = "END";
            } elseif ($profile_pin_status == 1 and $profileActiveStatus == 1 and $customerActiveStatus == 1) {
                $this->displayText = "Please enter your PIN:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "BE_Mobile_ValidatePin";
            } elseif ($customerActiveStatus != 1) {
// Customer is not active
                $this->displayText = "Dear $customerNames, Please call customer care to activate your DTB mobile service.";
                $this->sessionState = "END";
            } elseif ($profileActiveStatus != 1) {
// customer is not active
                $this->displayText = "Dear $customerNames, Please call customer care to activate your DTB mobile service.";
                $this->sessionState = "END";
            } else {
// Otp status not known to this menu
                $this->displayText = "Dear $customerNames, Please call customer care to activate your DTB mobile account";
                $this->sessionState = "END";
            }
        } else {
// not registered for mobile banking
// Show the menu, give an option for self-reg
            $this->displayText = "Dear Customer, Please visit your nearest $this->BANK branch to register for DTB Mobile.";
            $this->sessionState = "END";
        }
    }

    /*
     * Airtime Top up - Option 2
     */

    function processAirtime($input) {
        switch ($input) {
            case "1" :
                $this->saveSessionVar('airtimeRecipient', 'self');
                $networkID = $this->getProvider($this->_networkID);

                if ($networkID == "MTN") {
                    $this->saveSessionVar("merchantCode", "MTN_AIRTIME");
                } elseif ($networkID == "Airtel") {
                    $this->saveSessionVar("merchantCode", "AIRTELTOPUP");
                } elseif ($networkID == "Africell") {
                    $this->saveSessionVar("merchantCode", "AFRICELL_AIRTIME");
                } elseif ($networkID == "Vodacom") {
                    $this->saveSessionVar("merchantCode", "VODATOPUP");
                }

//my phone
                $arrLen = count($this->topupAmounts);
//  $topUpAmountsMenu = "NetworkID is $this->_networkID Select " . $this->MNOcodes[$this->customerNetOperator] . " top up amount:\n";
                $topUpAmountsMenu = "Select " . $this->MNOcodes[$this->customerNetOperator] . " top up amount:\n";

                $counter = 1;
                foreach ($this->topupAmounts as $k => $v) {
                    $topUpAmountsMenu .= $counter . ': ' . $this->topupAmounts[$k] . "\n";
                    $counter++;
                }//foreach
//$me ssage = "10|$topUpAmountsMenu|null|null|null|$topUpAmountsMenu";
                $this->displayText = $topUpAmountsMenu;
                $this->saveSessionVar('extra', $topUpAmountsMenu);
                $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
                $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-main";
                $this->sessionState = "CONTINUE";
                break;

            case "2" :
//other phone
                $arrLen = count($this->mnoMenuList);
                $menuList = "";
                $counter = 1;
                foreach ($this->mnoMenuList as $k => $v) {
                    $menuList .= $counter . ': ' . $this->mnoMenuList[$k] . "\n";
                    $counter++;
                }//foreach

                $this->displayText = "Select the network of the recipient's phone number\n$menuList";
                $this->saveSessionVar('extra', $menuList);
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "topup-other-main";
                $this->sessionState = "CONTINUE";
                break;
            default :
                $this->displayText = "Invalid entry, please reply with\n1: My Phone\n2: Other Phone";
                $this->nextFunction = "processAirtime";
                $this->sessionState = "CONTINUE";
        }
    }

    function selectDataNetwork($input) {
        switch ($input) {
            case "1":
                $this->saveSessionVar("merchantCode", "AFRICELL_DATA");
                $networkID = $this->getProvider($this->_networkID);
                if ($networkID == "Africell") {
                    $this->displayText = "Data Top Up:\n1: My Phone\n2: Other Phone";
                } else {
                    return $this->selectDataPhoneNumber(1);
#$this->displayText = "Data Top Up:\n1: Other Phone";
                }
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "selectDataPhoneNumber";
                break;
            default:
                $this->displayText = "Invalid entry, please reply with\n1: AFRICELL";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "selectDataNetwork";
        }
    }

    /*
     * Data Top Up - Option 2
     */

    function selectDataPhoneNumber($input) {
        $networkID = $this->getProvider($this->_networkID);
        if ($networkID == "Africell" && $input == 1) {
            $this->enterDataRecipientNumber($this->_msisdn);
        } else if (($networkID == "Africell" && $input == 2) || ($networkID != "Africell" && $input == 1)) {
            $this->displayText = "Enter the recipient's phone number:";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "enterDataRecipientNumber";
        } else {
            $this->selectDataNetwork(1);
        }
    }

    function enterDataRecipientNumber($input) {
// validate number
        if (is_numeric($input)) {
            $this->saveSessionVar("utilityBillAccountNo", $input);
            $this->saveSessionVar("billEnrolment", 'NO');
            $this->saveSessionVar("billEnrolmentNumber", 'NULL');
            $this->selectAfricellDataPackage(null);
        } else {
            $this->displayText = "Invalid number\nEnter the recipient's phone number:";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "enterDataRecipientNumber";
        }
    }

    function selectAfricellDataPackage($input) {
        $this->sessionState = "CONTINUE";
        if (is_null($input)) {
            $this->displayText = "Please choose your package\n1: 1 day\n2: 1 week\n3: 1 month\n4: 3 months\n5: 6 months\n6: 12 months\n7: Unlimited";
            $this->nextFunction = "selectAfricellDataPackage";
        } else {
            switch ($input) {
                case 1:
                    $this->displayText = "1: 10MB for 290/-\n2: 20MB for 450/-\n3: 25MB for 500/-\n4: 50MB for 1000/-\n5: 100MB for 1,750/-";
                    $this->nextFunction = "africellDailyData";
                    break;
                case 2:
                    $this->displayText = "1: 50MB for 1,750/-\n2: 80MB for 2,500/-\n3: 200MB for 5,500/-\n4: 800MB for 21,900/-";
                    $this->nextFunction = "africellWeeklyData";
                    break;
                case 3:
                    $this->displayText = "1: 25MB to 500MB\n2: 1GB to 5GB\n3: 10GB to 30GB";
                    break;
                case 4:
                    $this->displayText = "1: 1GB to 5GB\n2: 6.5GB to 45GB";
                    break;
                case 5:
                    $this->displayText = "1: 30GB for 500,000/-";
                    $this->nextFunction = "africell6MonthlyData";
                    break;
                case 6:
                    $this->displayText = "1: 100GB for 900,000/-";
                    $this->nextFunction = "africellYearlyData";
                    break;
                case 7:
                    $this->displayText = "1: 1 month for 299,000/-\n2: 3 months for 859,000/-\n3: 6 months for 1,619,000/-\n4: 12 months for 3,049,000/-";
                    $this->nextFunction = "africellUnlimitedData";
                    break;
                default:
                    $this->selectAfricellDataPackage(null);
                    break;
            }
        }
    }

    function africellDailyData($input) {
        $preText = "1 day, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "1-day");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 290);
                $this->displayText = $preText . "10MB, 290/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 2:
                $this->saveSessionVar("utilityBillAmount", 450);
                $this->displayText = $preText . "20MB, 450/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 3:
                $this->saveSessionVar("utilityBillAmount", 500);
                $this->displayText = $preText . "25MB, 500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 4:
                $this->saveSessionVar("utilityBillAmount", 1000);
                $this->displayText = $preText . "50MB, 1000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 5:
                $this->saveSessionVar("utilityBillAmount", 1750);
                $this->displayText = $preText . "100MB, 1,750/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(1);
                break;
        }
    }

    function africellWeeklyData($input) {
        $preText = "1 week, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "1-week");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 1750);
                $this->displayText = $preText . "50MB, 1,750/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 2:
                $this->saveSessionVar("utilityBillAmount", 2500);
                $this->displayText = $preText . "80MB, 2,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 3:
                $this->saveSessionVar("utilityBillAmount", 5500);
                $this->displayText = $preText . "200MB, 5,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 4:
                $this->saveSessionVar("utilityBillAmount", 21900);
                $this->displayText = $preText . "800MB, 21,900/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
            default:
                $this->selectAfricellDataPackage(2);
                break;
        }
    }

    function africell1MonthlyStage($input) {
        switch ($input) {
            case 1:
                $this->displayText = "1: 25MB for 1,450/-\n2: 100MB for 4,400/-\n3: 125MB for 4,900/-\n4: 250MB for 9,750/-\n5: 350MB for 13,500/-\n6: 500MB for 19,500/-";
                $this->nextFunction = "africell1MonthlyData";
                break;
            case 2:
                $this->displayText = "7: 1GB for 34,500/-\n8: 1.5GB for 44,500\n9: 2GB for 49,850/-\n10: 3GB for 59,500/-\n11: 3.5GB for 75,000/-\n12: 5GB for 89,000/-";
                $this->nextFunction = "africell1MonthlyData";
                break;
            case 3:
                $this->displayText = "13: 10GB for 124,850/-\n14: 30GB for 284,900/-";
                $this->nextFunction = "africell1MonthlyData";
                break;
            default:
                $this->selectAfricellDataPackage(null);
                break;
        }
    }

    function africell1MonthlyData($input) {
        $preText = "1 month, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "1-month");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 1450);
                $this->displayText = $preText . "25MB, 1,450/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 2:
                $this->saveSessionVar("utilityBillAmount", 4400);
                $this->displayText = $preText . "100MB, 4,400/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 3:
                $this->saveSessionVar("utilityBillAmount", 4900);
                $this->displayText = $preText . "125MB, 4,900/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 4:
                $this->saveSessionVar("utilityBillAmount", 9750);
                $this->displayText = $preText . "250MB, 9,750/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 5:
                $this->saveSessionVar("utilityBillAmount", 13500);
                $this->displayText = $preText . "350MB, 13,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 6:
                $this->saveSessionVar("utilityBillAmount", 19500);
                $this->displayText = $preText . "500MB, 19,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 7:
                $this->saveSessionVar("utilityBillAmount", 34500);
                $this->displayText = $preText . "1GB, 34,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 8:
                $this->saveSessionVar("utilityBillAmount", 44500);
                $this->displayText = $preText . "1.5GB, 44,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 9:
                $this->saveSessionVar("utilityBillAmount", 49850);
                $this->displayText = $preText . "2GB, 49,850/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 10:
                $this->saveSessionVar("utilityBillAmount", 59500);
                $this->displayText = $preText . "3GB, 59,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 11:
                $this->saveSessionVar("utilityBillAmount", 75000);
                $this->displayText = $preText . "3.5GB, 75,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 12:
                $this->saveSessionVar("utilityBillAmount", 89000);
                $this->displayText = $preText . "5GB, 89,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 13:
                $this->saveSessionVar("utilityBillAmount", 124850);
                $this->displayText = $preText . "10GB, 124,850/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 14:
                $this->saveSessionVar("utilityBillAmount", 284900);
                $this->displayText = $preText . "30GB, 284,900/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(3);
                break;
        }
    }

    function africell3MonthlyStage($input) {
        switch ($input) {
            case 1:
                $this->displayText = "1: 1GB for 45,000/-\n2: 1.5GB for 50,000/-\n3: 2GB for 64,900/-4: 3GB for 77,500/-\n5: 5GB for 116,500/-";
                $this->nextFunction = "africell3MonthlyData";
                break;
            case 2:
                $this->displayText = "6: 6.5GB for 129,000/-\n7: 10GB for 160,000/-\n8: 20GB for 300,000/-\n9: 30GB for 370,000/-\n10: 45GB for 600,000/-";
                $this->nextFunction = "africell3MonthlyData";
                break;
            default:
                $this->selectAfricellDataPackage(null);
                break;
        }
    }

    function africell3MonthlyData($input) {
        $preText = "3 months, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "3-months");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 45000);
                $this->displayText = $preText . "1GB, 45,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 2:
                $this->saveSessionVar("utilityBillAmount", 50000);
                $this->displayText = $preText . "1.5GB, 50,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 3:
                $this->saveSessionVar("utilityBillAmount", 64900);
                $this->displayText = $preText . "2GB, 64,900/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 4:
                $this->saveSessionVar("utilityBillAmount", 77500);
                $this->displayText = $preText . "3GB, 77,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 5:
                $this->saveSessionVar("utilityBillAmount", 116500);
                $this->displayText = $preText . "5GB, 116,500/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 6:
                $this->saveSessionVar("utilityBillAmount", 129000);
                $this->displayText = $preText . "6.5GB, 129,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 7:
                $this->saveSessionVar("utilityBillAmount", 160000);
                $this->displayText = $preText . "10GB, 160,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 8:
                $this->saveSessionVar("utilityBillAmount", 300000);
                $this->displayText = $preText . "20GB, 300,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 9:
                $this->saveSessionVar("utilityBillAmount", 370000);
                $this->displayText = $preText . "30GB, 370,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 10:
                $this->saveSessionVar("utilityBillAmount", 600000);
                $this->displayText = $preText . "45GB, 600,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(4);
                break;
        }
    }

    function africell6MonthlyData($input) {
        $preText = "6 months, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "6-months");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 500000);
                $this->displayText = $preText . "30GB, 500,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(5);
                break;
        }
    }

    function africellYearlyData($input) {
        $preText = "12 months, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "12-months");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 900000);
                $this->displayText = $preText . "100GB, 900,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(6);
                break;
        }
    }

    function africellUnlimitedData($input) {
        $preText = "Unlimited, ";
        $postText = "\n1: Confirm\n2: Cancel";
        $this->sessionState = "CONTINUE";
        $this->saveSessionVar("dataPeriod", "unlimited");
        $this->nextFunction = "confirmAfricellData";
        switch ($input) {
            case 1:
                $this->saveSessionVar("utilityBillAmount", 299000);
                $this->displayText = $preText . "1 month, 299,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 2:
                $this->saveSessionVar("utilityBillAmount", 859000);
                $this->displayText = $preText . "3 months, 859,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 3:
                $this->saveSessionVar("utilityBillAmount", 1619000);
                $this->displayText = $preText . "6 months, 1,619,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            case 4:
                $this->saveSessionVar("utilityBillAmount", 3049000);
                $this->displayText = $preText . "12 months, 3,049,000/-, " . $this->getSessionVar("utilityBillAccountNo") . $postText;
                break;
            default:
                $this->selectAfricellDataPackage(7);
                break;
        }
    }

    function confirmAfricellData($input) {
        if ($input == 1) {
            $this->displayText = "Select account:\n" . $this->getSessionVar('clientAccounts');
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } else if ($input == 2) {
//Go back to the main menu
            $this->startPage();
        } else {
            $this->displayText = "Invalid entry. Please reply with:\n1: Confirm\n2: Cancel";
            $this->nextFunction = "confirmAfricellData";
            $this->sessionState = "CONTINUE";
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

    function processAirtimeSelf($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');
        $merchantCode = $this->getSessionVar('merchantCode');
        if ($this->previousPage == "self-top-up-main") {//10
            $num = $input;
            $this->saveSessionVar('airtimeMSISDN', $this->_msisdn);
//$this->saveSessionVar("utilityBillAccountNo", $this->_msisdn);
            $this->saveSessionVar("merchantCode", $merchantCode);
//$die($this->_msisdn);
            $topUpAmountsMenu = $this->getSessionVar('extra');
            $arrLen = count($this->topupAmounts);

            if ($input == $arrLen) {
                $this->displayText = "Airtime top up\nReply with  amount between UGX." . $this->MINTOPUPVALUE . " and " . $this->MAXTOPUPVALUE;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-amount-selfinput";
            } else if ($input >= 1 and $input < $arrLen) {
                if ($this->getSessionVar("airtimeRecipient") == "self") {
                    $this->saveSessionVar("utilityBillAccountNo", $this->_msisdn);
                }
                $network = $this->getSessionVar('8-mnocodes');
                $amount = $this->topupAmounts[$num - 1];
                $this->saveSessionVar('amount', $amount);
                $this->displayText = "You would like to purchase " . $this->format_cash($amount, $this->Currency) . " worth of $network airtime?\n1: Yes\n2: No";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "self-top-up-amount-confirm";
                $this->nextFunction = "processAirtimeSelf";

                $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");
                $this->saveSessionVar('7-amount', $amount);
                $acounttype = $this->getSessionVar('accounttype');
                if ($acounttype == "VBAccount") {

                    $this->saveSessionVar('accounttype', $this->VBTopupServiceID);
                } elseif ($acounttype == "CBSAccount") {
                    $this->saveSessionVar('accounttype', $this->CBSTopupServiceID);
                }
            } else {
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-main";
                $this->sessionState = "CONTINUE";

                $this->displayPage = "Invalid entry, $topUpAmountsMenu";
                $this->saveSessionVar('extra', $topUpAmountsMenu);
            }
        } else if ($this->previousPage == "self-top-up-amount-selfinput") {

            $merchantCode = $this->getSessionVar('merchantCode');
            $this->saveSessionVar("utilityBillAccountNo", $this->getSessionVar('storedAirtimeAlias'));

//                  die($this->_msisdn);
            if ($input < $this->MINTOPUPVALUE or $input > $this->MAXTOPUPVALUE) {

                $this->displayText = "Invalid entry.\nPlease enter a value between $this->MINTOPUPVALUE and $this->MAXTOPUPVALUE.\nReply with the amount(UGX)";
                $this->sessionState = "CONTINUE";
                $this->netFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-amount-selfinput";
            } else {

                $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");

                $amount = $input;
                $network = $this->getSessionVar('8-mnocodes');
                $this->displayText = "You would like to purchase " . $this->format_cash($amount, $this->Currency) . " worth of $network airtime?\n1: Yes\n2: No";
                $acounttype = $this->getSessionVar('accounttype');
                if ($acounttype == "VBAccount") {

                    $this->saveSessionVar('accounttype', $this->VBTopupServiceID);
                } elseif ($acounttype == "CBSAccount") {
                    $this->saveSessionVar('accounttype', $this->CBSTopupServiceID);
                }
                $this->saveSessionVar('7-amount', $amount);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "self-top-up-amount-confirm";
                $this->nextFunction = "processAirtimeSelf";
            }
        } else if ($this->previousPage == "self-top-up-amount-choose") {//25
            if ($input == null) {
                $this->displayText = "Invalid entry. Please reply with:\n1: Yes\n2: No";
                $this->nextFunction = "processAirtimeSelf";
                $this->sessionState = "CONTINUE";

                $this->previousPage = "self-top-up-amount-choose";
            } else {
                if ($input == 1) {
                    $this->saveSessionVar('8-mnocodes', $this->MNOcodes[$this->customerNetOperator]);
                    $this->saveSessionVar('6-topup+clientID', "topup*$this->clientID");

                    $network = $this->getSessionVar('8-mnocodes');
                    $this->displayText = "Your $network Top up request has been received. $this->confirmatory $this->FULLBANKNAME";
                    $this->sessionState = "END";
                } else if ($input == 2) {
                    $this->startPage();
                } else {
                    $this->displayText = "Invalid entry. Please reply with:\n1: Yes\n2: No";
                    $this->nextFunction = "processAirtimeSelf";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "self-top-up-amount-choose";
                }
            }
        } else if ($this->previousPage == "self-top-up-amount-confirm") {//19
            if ($input == null) {
                $this->displayText = "Invalid entry. Please reply with:\n1: Yes\n2: No";
                $this->previousPage = "self-top-up-amount-confirm";
                $this->nextFunction = "processAirtimeSelf";
                $this->sessionState = "CONTINUE";
            } else {
                if ($input == 1) {
// $this->saveSessionVar("merchantCode", "SAFTOPUP");
                    $this->saveSessionVar("utilityBillAmount", $this->getSessionVar('7-amount'));
//$this->saveSessionVar("billEnrolment", "NO");
//$this->saveSessionVar("billEnrolmentNumber", "NULL");
// $this->saveSessionVar("utilityBillAccountNo", $this->_msisdn);
                    $this->displayText = "Select account:\n" . $clientAccounts;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "validateAccountDetails";
                } else if ($input == 2) {
//Go back to the main menu
                    $this->startPage();
                } else {
//$message = "19|Invalid entry.Please reply with\n0.Go Back\n1.Submit|null|null|null|null";
                    $this->displayText = "Invalid entry. Please reply with:\n1: Yes\n2: No";
                    $this->nextFunction = "processAirtimeSelf";
                    $this->previousPage = "self-top-up-amount-confirm";
                    $this->sessionState = "CONTINUE";
                }
            }
        }
    }

    function processAirtimeOtherNumber($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        if ($this->previousPage == "topup-other-main") {//11
            $menuList = $this->getSessionVar('extra');
            $arrLen = count($this->mnoMenuList);

            if ($input >= 1 and $input <= $arrLen) {
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-inputmsisdn";
                $this->sessionState = "CONTINUE";
                if ($input == 1) {
                    $this->saveSessionVar("merchantCode", "MTN_AIRTIME");
                } else if ($input == 2) {
                    $this->saveSessionVar("merchantCode", "AIRTELTOPUP");
                } else if ($input == 3) {
                    $this->saveSessionVar("merchantCode", "AFRICELL_AIRTIME");
                }

                $this->displayText = "Please enter recipient's phone number";
                $num = $input;
                $this->saveSessionVar('8-mnocodes', $this->mnoMenuList[$num - 1]);
            } else {
                $this->previousPage = "topup-other-main";
                $this->displayText = "Invalid entry. Please reply with:\n $menuList";
                $this->saveSessionVar('extra', $menuList);
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->sessionState = "CONTINUE";
            }
        } else if ($this->previousPage == "top-up-other-inputmsisdn") {//17
            $customerMSISDNLength = strlen($input);
//$this->saveSessionVar('utilityBillAccountNo', $input);
//validate msisdn
            if ($customerMSISDNLength == 10) {

                $customerMSISDN = '256' . substr($input, 1, 9);
                $arrLen = count($this->topupAmounts);
                $topUpAmountsMenu = "Select amount\n";
                $counter = 1;
                foreach ($this->topupAmounts as $k => $v) {
                    $topUpAmountsMenu .= $counter . ': ' . $this->topupAmounts[$k] . "\n";
                    $counter++;
                }//foreach
//$message = "9|$topUpAmountsMenu|null| null|n ull|$topUpAmountsMenu";
                $this->displayText = $topUpAmountsMenu;
                $this->saveSessionVar('extra', $topUpAmountsMenu);
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-amountchoose";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar('6-topupother+clientID', "topupOther*$this->clientID");
                $this->saveSessionVar('9-sendto-customermsisdn', $customerMSISDN);
            } else {

                $this->displayText = "Invalid mobile number, Please enter the phone number (Format - 07XXXXXXXX):";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-inputmsisdn";
            }
        } else if ($this->previousPage == "top-up-other-amountchoose") {//9
            $num = $input;
            $this->saveSessionVar('amountSelected', $input);

            $topUpAmountsMenu = $this->getSessionVar('extra');
            $arrLen = count($this->topupAmounts);

            if ($input == $arrLen) {
                $number = $this->getSessionVar('9-sendto-customermsisdn');
                $this->saveSessionVar('airtimeMSISDN', $number);
                $this->displayText = "$number Airtime top up\nPlease enter a value between $this->MINTOPUPVALUE and $this->MAXTOPUPVALUE:";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-airtimeamountcustom";
            } else if ($input >= 1 and $input < $arrLen) {
                $network = $this->getSessionVar('8-mnocodes');
                $amount = $this->topupAmounts[$num - 1];
                $phone = $this->getSessionVar('9-sendto-customermsisdn');
                $this->saveSessionVar('utilityBillAmount', $amount);
                $this->saveSessionVar('utilityBillAccountNo', $phone);
// Ask whether they want to enroll this number
                /* $this->displayText = "You would like to purchase airtime worth " . $this->format_cash($amount, $this->Currency) . " for Mobile Number $phone\n1: Yes\n2: No";
                  $this->sessionState = "CONTINUE";
                  $this->nextFunction = "processAirtimeOtherNumber";
                  $this->previousPage = "top-up-other-confirmamountchoose"; */


                $this->displayText = "Would you like to save this number for future use?\n1: Yes\n2: No";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "enrollAirtime";



                $this->saveSessionVar('6-topupother+clientID', "topupOther*$this->clientID");
                $this->saveSessionVar('7-amount', $amount);

                $acounttype = $this->getSessionVar('accounttype');
                if ($acounttype == "VBAccount") {

                    $this->saveSessionVar('accounttype', $this->VBTopupServiceID);
                } elseif ($acounttype == "CBSAccount") {
                    $this->saveSessionVar('accounttype', $this->CBSTopupServiceID);
                }
            } else {
                $this->nextFunction = "processAirtimeSelf";
                $this->previousPage = "self-top-up-main";
                $this->displayText = "Invalid entry, $topUpAmountsMenu";
                $this->sessionState = "CONTINUE";

                $this->saveSessionVar('extra', $topUpAmountsMenu);
            }
        } elseif ($this->previousPage == "enrollAirtime") {
            $num = $this->getSessionVar('amountSelected');
            $network = $this->getSessionVar('8-mnocodes');

            if ($this->previousPage == "top-up-other-amountchoose") {
                $amount = $this->topupAmounts[$num - 1];
                $this->saveSessionVar('utilityBillAmount', $amount);
                $this->saveSessionVar('airtimeMSISDN', $phone);
            }

            $amount = $this->getSessionVar('utilityBillAmount');
            $phone = $this->getSessionVar('9-sendto-customermsisdn');
//$this->saveSessionVar('utilityBillAmount', $amount);
            $this->saveSessionVar('airtimeMSISDN', $phone);

            switch ($input) {
                case 1:
                    $this->saveSessionVar('billEnrolment', 'yes');
//$this->saveSessionVar('flavour','enrol');
                    $this->displayText = "Please enter a nickname for this number";
                    $this->previousPage = "processEnrollAirtime";
                    $this->nextFunction = "processAirtimeOtherNumber";
                    break;
                case 2:
                    $this->saveSessionVar('utilityBillAccountNo', $phone);
                    $this->displayText = "You would like to purchase airtime worth " . $this->format_cash($amount, $this->Currency) . " for Mobile Number a$phone\n1: Yes\n2: No";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAirtimeOtherNumber";
                    $this->previousPage = "top-up-other-confirmamountchoose";
                    $phone = $this->getSessionVar('9-sendto-customermsisdn');
                    $this->saveSessionVar('utilityBillAccountNo', $phone);

                    break;
                default:
                    $this->displayText = "Invalid entry. Please enter\n1: Yes\n2: No";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAirtimeOtherNumber";
                    $this->previousPage = "enrollAirtime";
                    break;
            }
        } elseif ($this->previousPage == "processEnrollAirtime") {
            $amount = $this->getSessionVar('utilityBillAmount');
            $phone = $this->getSessionVar('9-sendto-customermsisdn');
            $this->saveSessionVar('airtimeMSISDN', $phone);
            $this->saveSessionVar("billEnrolmentNumber", $input);
            $enroledAliases = array();

            $enrolments = array_filter(explode('#', $this->getSessionVar('enrolmentDetails')));
            $count = 0;

            for ($i = 0; $i < sizeof($enrolments); $i++) {
                $enrolmentData = array_filter(explode("|", $enrolments [$i]));
                if ($enrolmentData[1] == "MTN_AIRTIME" || $enrolmentData[1] == "AIRTELTOPUP") {
                    $enroledAliases[$counter] = $enrolmentData['0'];
                    $count++;
                }
            }
            $counter = 0;
            if ($count > 0) {

                for ($j = 0; $j < $count; $j++) {
                    $sample = $enroledAliases[0];
//                $this->displayText = "Counter got to $sample";
//              $this->sessionState = "CONTINUE";
                    if ($input == $enroledAliases[$j]) {
                        $counter++;
                    }
                }
                if ($counter == 0) {
                    $sample = $enroledAliases[0];
                    $this->displayText = "You would like to purchase airtime worth " . $this->format_cash($amount, $this->Currency) . " for Mobile Number b$phone\n1: Yes\n2: No";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processAirtimeOtherNumber";
                    $this->previousPage = "top-up-other-confirmamountchoose";
                } else {
                    $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for mobile number '$_msisdn'";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "processEnrollAirtime";
                    $this->nextFunction = "processSendMoney";
                }
            } else {
                $this->displayText = "You would like to purchase airtime worth " . $this->format_cash($amount, $this->Currency) . " for Mobile Number c$phone\n1: Yes\n2: No";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-confirmamountchoose";
            }
        } else if ($this->previousPage == "top-up-other-confirmamountchoose") {//23
            if ($input == 1) {

                $mobileNumber = $this->getSessionVar('9-sendto-customermsisdn');
                $this->saveSessionVar('airtimeMSISDN', $mobileNumber);
                $this->displayText = "Select account:\n" . $clientAccounts;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "validateAccountDetails";
            } else if ($input == 2) {
//Go back to the main menu
                $this->startPage();
            } else {
                $this->previousPage = "top-up-other-confirmamountchoose";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->displayText = "Invalid entry, please reply with:\n\n0.Go Back\n1.Submit";
                $this->sessionState = "CONTINUE";
            }
        } else if ($this->previousPage == "top-up-other-airtimeamountcustom") {
            if ($input > $this->MAXTOPUPVALUE or $input < $this->MINTOPUPVALUE) {//112
                $this->displayText = "Please enter a value between $this->MINTOPUPVALUE and $this->MAXTOPUPVALUE:";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "top-up-other-airtimeamountcustom";
                $this->sessionState = "CONTINUE";
            } else {
                $this->saveSessionVar('utilityBillAmount', $input);

                $acounttype = $this->getSessionVar('accounttype');
                if ($acounttype == "VBAccount") {

                    $this->saveSessionVar('accounttype', $this->VBTopupServiceID);
                } elseif ($acounttype == "CBSAccount") {
                    $this->saveSessionVar('accounttype', $this->CBSTopupServiceID);
                }

                $network = $this->getSessionVar('8-mnocodes');
                $phone = $this->getSessionVar('9-sendto-customermsisdn');
                $amount = $this->getSessionVar('utilityBillAmount'); //'7-amount');
//$this->previousPage = "top-up-other-confirmamountchoose";
                $this->displayText = "Would you like to save this number for future use?\n1: Yes\n2: No";
                $this->nextFunction = "processAirtimeOtherNumber";
                $this->previousPage = "enrollAirtime";
//$this->displayText = "You would like to purchase airtime worth " . $this->format_cash($amount, $this->Currency) . " for Mobile Number $phone\n1: Yes\n2: No";
                $this->sessionState = "CONTINUE";
            }
        }
    }

    /*
     * Mpesa Transfers - Option 3
     */

    function mpesaTransfers($input) {
        if ($this->getSessionVar("confirmMpesa") == "confirm") {
            switch ($input) {
                case 1 :
                    /*
                     * <Payload><serviceID>14</serviceID><flavour>self</flavour>
                     * <pin>8169ef2deb269557335fd9c9bd209c230f3801570564c37495863f7c7cd9be15553f6d1b16ee2569233705ab215025fbe41fc305cefa88721e43dc71c5</pin>
                     * <accountAlias>Test Acc</accountAlias><amount>100</amount>
                     * <accountID>2225</accountID><columnA>254722665319</columnA></Payload>
                     */
                    $accountDetails = $this->getSessionVar('accountID+accountAlias');
                    $accountDetails = explode("*", $accountDetails);
                    $accountID = $accountDetails [0];
                    $accountAlias = $accountDetails [1];

                    $encryptedpin = $this->getSessionVar('encryptedPin');
                    $mpesaAmount = $this->getSessionVar("mpesaAmount");

                    $mpesaPayloadArray = array(
                        "serviceID" => $this->B2CMPESAServiceID,
                        "flavour" => "self",
                        "pin" => $encryptedpin,
                        "accountAlias" => $accountAlias,
                        "amount" => $mpesaAmount,
                        "accountID" => $accountID,
                        "columnA" => $this->_msisdn
                    );

                    $statusCode = 2;

// log request into channelRequests
                    $successLog = $this->logChannelRequest($mpesaPayloadArray, $statusCode);

                    if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                        $this->displayText = "Your M-PESA request has been received. $this->confirmatory $this->BANK_SIGNATURE";
                        $this->sessionState = "END";
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request.";
                        $this->sessionState = "END";
                    }
                    break;

                case 2 :
                    $this->displayText = "You cancelled the M-PESA transfer. Select\n$this->CBSservices";
                    $this->nextFunction = "selectBankAccount";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar("confirmMpesa", "");
                    break;

                default :
                    $this->displayText = "Incorrect selection. Please select\n1: Yes\n2: No";
                    $this->nextFunction = "mpesaTransfers";
                    $this->sessionState = "CONTINUE";
            }
        } else {
            if (!is_numeric($input) || $input < $this->MINMPESATRANSFER || $input > $this->MAXMPESATRANSFER) {
                $this->displayText = "Incorrect amount. Please enter an amount between UGX $this->MINMPESATRANSFER and UGX $this->MAXMPESATRANSFER:";
                $this->nextFunction = "mpesaTransfers";
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Please confirm that you would like to transfer UGX $input to your M-PESA account, mobile number $this->_msisdn.\n1: Yes\n2: No";
                $this->nextFunction = "mpesaTransfers";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar("confirmMpesa", "confirm");
                $this->saveSessionVar("mpesaAmount", $input);
            }
        }
    }

    function processMerchants($input) {
        switch ($input) {
            case 3 :

                $this->saveSessionVar("selectedMerchant", DTBUGconfigs::GOTV_MERCHANT);
                $this->saveSessionVar('merchantCode', 'DSTV_UGANDA');
                $this->saveSessionVar('merchantName', 'DStv');


            case 4 :
                $this->saveSessionVar('selectedMerchant', 'DStv');
                $this->saveSessionVar('merchantCode', 'DSTV_UGANDA');
                $this->saveSessionVar('merchantName', 'DStv');
                $queryBill = $this->getMultichoiceBill('getDetailsByMSISDN', $this->_msisdn);

                if ($queryBill == 110) {

                    $this->displayText = "Please enter your DStv account number:";
                    $this->nextFunction = "processMultichoicePresentment";
                    $this->previousPage = "getBillByAccountNumber";
                    $this->sessionState = "CONTINUE";
                } elseif ($queryBill['StatusCode'] == 120) {//No DStv Bill fetched
                    $customerNumber = $queryBill['CustomerNumber'];
                    $customerName = $queryBill['SurnameField'];

                    $this->displayText = "Dear $customerName, you would like to pay for your DStv A/C $customerNumber.\n1: Yes\n2: No\n3: Pay for Other\n0: Go to Home";
                    $this->nextFunction = "processMultichoicePresentment";
                    $this->saveSessionVar('utilityBillAccountNo', $customerNumber);
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "enterBillAmount";
                } elseif ($queryBill['StatusCode'] == 125) {
                    $customerNumber = $queryBill['CustomerNumber'];
                    $customerName = $queryBill['SurnameField'];
                    $dueAmount = $queryBill['DueAmount'];
                    $dueDate = $queryBill['DueDate'];

                    if ($dueAmount < $this->MINBILLPAY) {
                        $this->displayText = "Dear $customerName, your current balance for A/C $customerNumber is UGX $dueAmount. Thank You.\n1: Enter other Amount\n2: Pay for other\n0: Go to Home";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "overPaid";
                        $this->saveSessionVar('utilityBillAccountNo', $customerNumber);
                    } else {
                        $this->displayText = "Dear $customerName, your bill of $dueAmount for A/C $customerNumber is due on $dueDate.\n1: Settle Bill\n2: Pay for other account\n3: Enter other amount\n0: Go to Home";
                        $this->nextFunction = "processMultichoicePresentment";
                        $this->saveSessionVar('utilityBillAccountNo', $customerNumber);
                        $this->previousPage = "confirmPayment";
                        $this->saveSessionVar('utilityBillAmount', $dueAmount);
                        $this->sessionState = "CONTINUE";
                    }
                } elseif ($queryBill['StatusCode'] == 140) {//Multiple Bills Fetched
                    $customerDetails = $queryBill['CustomerNumbers'];

                    $customerAccounts = explode("~", $customerDetails);
                    $accCount = 1;
                    $accNos = "";
                    $accNums = "";

                    foreach ($customerAccounts as $key => $value) {
                        $accounts = explode("^", $value);

                        if ($accounts[2] == 'SUD') {
                            $accNo = $accCount . ": " . $accounts[0] . "\n";
                            $accNums .= $accounts[0] . ">";
                            $accNos .= $accNo;
                            $accCount++;
                        }
                    }
                    $this->displayText = "Please Select Account:\n$accNos$accCount: Enter other A/C no\n0: Go to Home";
                    $this->nextFunction = "processMultichoicePresentment";
                    $this->saveSessionVar("multipleAccounts", $accNums);
                    $this->previousPage = "multipleAccounts";
                    $this->sessionState = "CONTINUE";
                } else {

                    $this->displayText = "sorry this service is currently unavailable";
                    $this->sessionState = "end";
                    /* $this->displayText = "Please enter your DStv account number:";
                      $this->nextFunction = "processMultichoicePresentment";
                      $this->previousPage = "getBillByAccountNumber";
                      $this->sessionState = "CONTINUE"; */
                }
                $this->saveSessionVar('merchantCode', 'DSTV_UGANDA');
                $this->saveSessionVar('merchantName', 'DStv');
                break;

            case 3 :
//    zuku tv

                $this->displayText = "sorry this service is currently unavailable";
                $this->sessionState = "end";
// $this->displayText = "Please enter your account number:";
// $this->nextFunction = "processMerchantAccount";
// $this->saveSessionVar('selectedMerchant', 'ZUKU');
// $this->saveSessionVar('merchantCode', 'ZUKUUG');
// $this->saveSessionVar('merchantName', 'ZUKU');
// $this->sessionState = "CONTINUE";
                break;

            case 4:
                $this->displayText = "Please enter meter number";
                $this->previousPage = "enterNWSCMeterNumber";
                $this->nextFunction = "processMerchantAccount";
                $this->saveSessionVar('merchantCode', 'NWSC');
                $this->saveSessionVar('merhcantName', 'NWSC');
                $this->sessionState = "CONTINUE";

                break;

            case 5:
                $this->displayText = "Please enter meter number";
                $this->previousPage = "enterUMEMEMeterNumber";
                $this->nextFunction = "processMerchantAccount";
                $this->saveSessionVar('merchantCode', 'UMEME');
                $this->saveSessionVar('merhcantName', 'UMEME');
                $this->sessionState = "CONTINUE";
                break;

            case 6:


                $this->displayText = "Please enter account number";
                $this->previousPage = "enterKCCAAccountNumber";
                $this->nextFunction = "processMerchantAccount";
                $this->saveSessionVar('merchantCode', 'KCCA');
                $this->saveSessionVar('merhcantName', 'KCCA');
                $this->sessionState = "CONTINUE";
                break;
            default :
                $this->displayText = "Wrong option selected. Please Select the Merchant to Pay\n" . $this->getSessionVar("extra");
                $this->nextFunction = "processMerchants";
                $this->sessionState = "CONTINUE";
        }
    }

    function processMerchantCode($merchants, $merchantCode) {
        for ($i = 0; $i < sizeof($merchants); $i++) {
            $mechant = array_filter(explode("|", $merchants [$i]));
            $singleMerchant = $mechant [1];

            if ($singleMerchant == $merchantCode) {
                $merchantName = $singleMerchant;
                break;
            }
        }
        return $merchantName;
    }

    function processMerchantAccounts($merchants, $merchantCode) {
        $count = 1;
        $accounts = "";

        for ($i = 0; $i < sizeof($merchants); $i++) {
            $singleMerchant = array_filter(explode("|", $merchants [$i]));

            if ($singleMerchant [1] == $merchantCode) {
                $merchantAccount = $singleMerchant [2];
                $accounts .= $count . ": " . $merchantAccount;
                $merchantAccounts .= $merchantAccount . '^';
                $count++;
            }
        }
        $this->saveSessionVar('merchantAccountNumbers', $merchantAccounts);
        return $accounts . "\n" . $count . ": Enter";
    }

    function processMerchantAccount($input) {
        $merchantCode = $this->getSessionVar('merchantCode');
        $merchantName = $this->getSessionVar('merchantName');

        if ($merchantCode == 'DSTV_UGANDA') {
            if (is_numeric($input) && (strlen($input) == 8 || strlen($input) == 10 || strlen($input) == 11)) {
// save the business number
                $this->displayText = "Please enter the amount to pay for $merchantName account number $input";
                $this->nextFunction = "enrolMerchantAccount";
                $this->saveSessionVar('utilityBillAccountNo', $input);
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Wrong account number. Please enter the correct $merchantName account number:";
                $this->nextFunction = "processMerchantAccount";
                $this->sessionState = "CONTINUE";
            }
        } elseif ($merchantCode == 'GotvUG') {
            if (is_numeric($input) && strlen($input) == 10 || is_numeric($input) && strlen($input) == 11) {
                $this->displayText = "Please enter the amount to pay for startimes account number $input";
                $this->displayText = "Enter amount between UGX $this->MIN and UGX $this->MAXBILLPAY";
                $this->nextFunction = "enrolMerchantAccount";
                $this->saveSessionVar('utilityBillAccountNo', $input);
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Wrong account number. Please enter the correct 10 or 11 digit account number:";
                $this->nextFunction = "processMerchantAccount";
                $this->sessionState = "CONTINUE";
            }
        } elseif ($merchantCode == 'ZUKUUG') {
            if (is_numeric($input) && strlen($input) == 11) {
//$this->displayText = "Please enter the amount to pay for LUKU meter number $input";
                $this->displayText = "Enter amount between UGX $this->MINBILLPAY and UGX $this->MAXBILLPAY";
                $this->nextFunction = "enrolMerchantAccount";
                $this->saveSessionVar('utilityBillAccountNo', $input);
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Wrong meter number. Please enter the correct 11 digit meter number:";
                $this->nextFunction = "processMerchantAccount";
                $this->sessionState = "CONTINUE";
            }
        } elseif ($merchantCode == 'NWSC') {

            if ($this->previousPage == "enterNWSCMeterNumber") {

                $this->saveSessionVar("nwscMeterNumber", $input);
                $text = "Select area \n";
                $areasArray = explode(",", $this->nwscAreas);

                for ($i = 0; $i < sizeof($areasArray); $i++) {
                    $text .= $i + 1 . ". " . $areasArray[$i] . "\n";
                }

                $this->displayText = $text;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processMerchantAccount";
                $this->previousPage = "selectArea";
            } elseif ($this->previousPage == "selectArea") {

                $areasArray = explode(",", $this->nwscAreas);
                $input = (int) $input;

#check for array index out of bounds
                if ($input > sizeof($areasArray) || $input < 1) {
#prompt user to enter select area again
                    $this->previousPage = "enterNWSCMeterNumber";
                    $this->processMerchantAccount($this->getSessionVar("nwscMeterNumber"));
                } else {

#valid index has been selected
                    $selectedIndex = $input - 1;
                    $selectedArea = trim($areasArray[$selectedIndex]);
                    $this->saveSessionVar("selectedArea", $selectedArea);
                    $meterNumber = $this->getSessionVar("nwscMeterNumber");
                    $serviceID = $this->nwscServiceID;
                    $serviceCode = $this->nwscServiceCode;


                    $validateNWSCAccount = $this->validateCustomerAccount($merchantCode, $serviceID, $serviceCode, $meterNumber, $selectedArea);
                    $statusCode = $validateNWSCAccount['statusCode'];
                    if (empty($validateNWSCAccount) || $statusCode == "174") {

                        $this->displayText = "Invalid account Meter number. Please enter meter number again";
                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "processMerchantAccount";
                        $this->previousPage = "enterNWSCMeterNumber";
                    } else {


                        $customerName = $validateNWSCAccount['customerName'];
                        $balance = $validateNWSCAccount['balance'];
                        $customerType = $validateNWSCAccount['customerType'];

                        $this->saveSessionVar("nwscCustomerName", $customerName);

                        if ($balance == 0) {
                            $this->displayText = "Enter Amount to pay";
                        } else {
                            $this->displayText = "Your balance is UGX " . $balance . ". Enter Amount to pay";
                        }

                        $this->sessionState = "CONTINUE";
                        $this->saveSessionVar('utilityBillAccountNo', $meterNumber);
                        $this->saveSessionVar('merchantName', $merchantCode);
                        $this->nextFunction = "enrolMerchantAccount";
                    }
                }
            }
        } else if ($merchantCode == "UMEME") {

            if ($this->previousPage == "enterUMEMEMeterNumber") {

                $this->displayText = "Enter Meter Number";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processMerchantAccount";
                $meterNumber = $input;
                $serviceID = $this->umemeServiceID;
                $serviceCode = $this->umemeServiceCode;
                $validateUMEMEAccount = $this->validateCustomerAccount($merchantCode, $serviceID, $serviceCode, $meterNumber, "");
                $statusCode = $validateUMEMEAccount ['statusCode'];
                if (empty($validateUMEMEAccount) || $statusCode == "174") {

                    $this->displayText = "Invalid account Meter number. Please enter meter number again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processMerchantAccount";
                    $this->previousPage = "enterUMEMEMeterNumber";
                } else {

                    $customerName = $validateUMEMEAccount['customerName'];
                    $balance = $validateUMEMEAccount['balance'];
                    $customerType = $validateUMEMEAccount['customerType'];

                    if ($customerType == "POSTPAID" && $balance != 0) {
                        $this->displayText = "Your balance is UGX " . $balance . ". Enter Amount to pay";
                    } else {
                        $this->displayText = "Enter Amount to pay";
                    }
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('utilityBillAccountNo', $meterNumber);
                    $this->saveSessionVar('merchantName', $merchantCode);
                    $this->saveSessionVar('umemeCustName', $customerName);
                    $this->nextFunction = "enrolMerchantAccount";
                }
            }
        } else if ($merchantCode == "KCCA") {

            if ($this->previousPage == "enterKCCAAccountNumber") {

                $this->displayText = "Enter account Number";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processMerchantAccount";
                $meterNumber = $input;
                $serviceID = $this->kccaServiceID;
                $serviceCode = $this->kccaServiceCode;
                $validateKCCAAccount = $this->validateCustomerAccount($merchantCode, $serviceID, $serviceCode, $meterNumber, "");
                $statusCode = $validateKCCAAccount ['statusCode'];

                if (empty($validateKCCAAccount) || $statusCode == "174") {

                    $this->displayText = "Invalid account Meter number. Please enter account number again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processMerchantAccount";
                    $this->previousPage = "enterKCCAAccountNumber";
                } else {

                    $customerName = $validateKCCAAccount['customerName'];
                    $balance = $validateKCCAAccount['balance'];
                    $customerType = $validateKCCAAccount['customerType'];

                    if ($balance != 0) {
                        $this->displayText = "Your balance is UGX " . $balance . ". Enter Amount to pay";
                        $this->previousPage = "enterBalance";
                        $this->sessionState = "CONTINUE";
                    } else {
                        $this->displayText = "Enter Amount to pay";
                    }
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('utilityBillAccountNo', $meterNumber);
                    $this->saveSessionVar('merchantName', $merchantCode);
                    $this->saveSessionVar('kccaCustomerName', $customerName);
                    $this->saveSessionVar('balance', $balance);
                    $this->nextFunction = "enrolMerchantAccount";
                }
            }
        }
    }

    function processEnrolledMerchant($input) {
        $merchantCode = $this->getSessionVar('merchantCode');
        $merchantName = $this->getSessionVar('merchantName');
        $merchantAccounts = $this->getSessionVar('merchantAccounts');
        $merchantAccountNumbers = explode('^', $this->getSessionVar('merchantAccountNumbers'));

        if ($input == "" or $input == 0 or ! is_numeric($input) or $input > sizeOf($merchantAccountNumbers)) {
            $this->displayText = "Wrong option selected. Select:\n$merchantAccounts";
            $this->nextFunction = "processEnrolledMerchant";
            $this->sessionState = "CONTINUE";
        } elseif ($input == sizeOf($merchantAccountNumbers)) {
            $this->displayText = "Please enter your $merchantName account number";
            $this->nextFunction = "processMerchantAccount";
            $this->sessionState = "CONTINUE";
        } else {
            $merchantAccountNumber = $merchantAccountNumbers [$input - 1];
            $this->displayText = "Please enter the amount to pay for $merchantName account number $merchantAccountNumber";
            $this->nextFunction = "processEnrolledAmount";
            $this->saveSessionVar('utilityBillAccountNo', $merchantAccountNumber);
            $this->sessionState = "CONTINUE";
        }
    }

    function processEnrolledAmount($input) {
        $accountNumber = $this->getSessionVar('utilityBillAccountNo');
        $merchantCode = $this->getSessionVar('merchantCode');
        $merchantName = $this->getSessionVar('merchantName');

        if ($input >= $this->MINBILLPAY && $input <= $this->MAXBILLPAY) {
            $this->displayText = "Would you like to pay UGX $input to $merchantName for account number $accountNumber?\n1: Yes\n2: No";
            $this->nextFunction = "confirmBillPayment";
            $this->saveSessionVar('billEnrolment', "NO");
            $this->saveSessionVar('billEnrolmentNumber', 'NULL');
            $this->saveSessionVar('utilityBillAmount', $input);
        } else {
            $this->displayText = "Amount not in the allowed range. Please enter amount between UGX $this->MINBILLPAY and UGX $this->MAXBILLPAY:";
            $this->nextFunction = "processEnrolledAmount";
            $this->sessionState = "CONTINUE";
        }
    }

    function enrolMerchantAccount($input) {
        $accountNumber = $this->getSessionVar('utilityBillAccountNo');
        $merchantCode = $this->getSessionVar('merchantCode');
        $merchantName = $this->getSessionVar('merchantName');

        if ($merchantCode == "LUKU") {
            if ($input >= $this->MINBILLPAY && $input <= $this->MAXBILLPAY) {
                $this->displayText = "Would you like to enrol $merchantName account number $accountNumber?\n1: Yes\n2: No";
                $this->nextFunction = "processMerchantAmount";
                $this->saveSessionVar('utilityBillAmount', $input);
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Amount not in the allowed range. Please enter amount between UGX $this->MINBILLPAY and UGX $this->MAXBILLPAY";
                $this->nextFunction = "enrolMerchantAccount";
                $this->sessionState = "CONTINUE";
            }
        } else {

            $balance = $this->getSessionVar('balance');
            if ($input != $balance) {

                $this->displayText = "Invalid amount entered, please enter UGX $balance";
                $this->previousPage = "enterBalance";
                $this->sessionState = "CONTINUE";
            } else if ($input >= $this->MIN && $input <= $this->MAXBILLPAY) {
                $this->displayText = "Would you like to enrol $merchantName account number $accountNumber?\n1: Yes\n2: No";
                $this->nextFunction = "processMerchantAmount";
                $this->saveSessionVar('utilityBillAmount', $input);
                $this->sessionState = "CONTINUE";
            } else {
                $this->displayText = "Amount not in the allowed range. Please enter amount between UGX $this->MIN and UGX $this->MAXBILLPAY";
                $this->nextFunction = "enrolMerchantAccount";
                $this->sessionState = "CONTINUE";
            }
        }
    }

    function processMerchantAmount($input) {
        $accountNumber = $this->getSessionVar('utilityBillAccountNo');
        $amount = $this->getSessionVar('utilityBillAmount');
        $merchantCode = $this->getSessionVar('merchantCode');
        $merchantName = $this->getSessionVar('merchantName');
        $customerName = "";

        if ($merchantName == "NWSC") {

            $customerName = $this->getSessionVar('nwscCustomerName');
        } else if ($merchantName == "UMEME") {

            $customerName = $this->getSessionVar('umemeCustName');
        } else if ($merchantName == "KCCA") {

            $customerName = $this->getSessionVar('kccaCustomerName');
        }
        switch ($input) {
            case 1 :
                $this->displayText = "$customerName Would you like to pay UGX $amount to $merchantName for account number $accountNumber?\n1: Yes\n2: No";
                $this->nextFunction = "confirmBillPayment";
                $this->saveSessionVar('billEnrolment', "YES");
                $this->saveSessionVar('billEnrolmentNumber', $merchantName . " - " . $accountNumber);
                break;

            case 2 :
                $this->displayText = "$customerName Would you like to pay UGX $amount to $merchantName for account number $accountNumber?\n1: Yes\n2: No";
                $this->nextFunction = "confirmBillPayment";
                $this->saveSessionVar('billEnrolment', "NO");
                $this->saveSessionVar('billEnrolmentNumber', 'NULL');
                break;

            default :
                $this->displayText = "Wrong option selected. Please select\n1: Yes\n2: No:";
                $this->nextFunction = "processMerchantAmount";
                $this->sessionState = "CONTINUE";
        }
    }

    function confirmBillPayment($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        switch ($input) {
            case 1 :
                $this->displayText = "Select account:\n" . $clientAccounts;
                $this->saveSessionVar("origin", "billPayment");
                $this->nextFunction = "validateAccountDetails";
                $this->sessionState = "CONTINUE";

                break;
            case 2 :
                $this->displayText = "You have terminated a Bill payment transaction. Select\n$this->CBSservices";
                $this->nextFunction = "processRequest";
                $this->sessionState = "CONTINUE";

                break;
            default :
                $this->displayText = "Wrong option selected. Please Select: \n1: Yes\n2: No";
                $this->nextFunction = "confirmBillPayment";
                $this->sessionState = "CONTINUE";
        }
    }

    function finalizeBillPayment() {
        /*
         * <Payload><serviceID>bill_pay</serviceID><flavour>open</flavour>
         * <pin>9b9e6206d2cd683cb235cc7efe173ddbbc768d73964589d7a848d7c93ca7e4e6e7bb8df959953e4940f6ed54a4d30a1523ca21cb06d353fd5e2de67b00</pin>
         * <accountAlias>Test Acc</accountAlias><amount>123</amount>
         * <merchantCode>DSTV</merchantCode><accountID>2225</accountID>
         * <enroll>NO</enroll><CBSID>1</CBSID><columnD>null</columnD>
         * <columnA>12345678</columnA><columnC>DSTV</columnC></Payload>
         *
         * {"serviceID":"bill_pay","flavour":"open",
         * "pin":"31323334353637383132333435363738dcc623b6f9d403194ff0cd302ae13e34852a81a88ecc90b71cbb390cdb4cb4eb8c5ef218506ab2a2c0e423c03e",
         * "accountAlias":"Johny2","amount":"121","merchantCode":"DSTV","accountID":"34",
         * "enroll":"NO","columnA":"12121212","columnC":"DSTV"}
         */

        $accountDetails = $this->getSessionVar('accountID+accountAlias');

        $accountDetails = explode("*", $accountDetails);
        $accountID = $accountDetails[0];
        $accountAlias = $accountDetails[1];
        $encryptedPin = $this->getSessionVar('encryptedPin');
        $amount = $this->getSessionVar('utilityBillAmount');
        $merchantCode = $this->getSessionVar('merchantCode');
//$accountID =
        $billAccountNo = $this->getSessionVar('utilityBillAccountNo');
        $enrolment = $this->getSessionVar('billEnrolment');
        $enrolBillNo = $this->getSessionVar('billEnrolmentNumber');

        $uppayloadarray = array("serviceID" => $this->BillPayServiceID, "flavour" => "open", "pin" => $encryptedPin, "accountAlias" => $accountAlias, "amount" => $amount, "merchantCode" => $merchantCode, "accountID" => $accountID, "enroll" => $enrolment, "CBSID" => 1, "columnD" => $enrolBillNo, "columnA" => $billAccountNo, "columnC" => $merchantCode);

        $statusCode = 2;

//log request into channelRequests
        $successLog = $this->logChannelRequest($uppayloadarray, $statusCode);

        if ($successLog['SUCCESS'] == TRUE) {
//send payload to system and get response
            $this->displayText = "Your bill payment has been received. $this->confirmatory $this->BANK";
            $this->sessionState = "END";
        } else {
            $this->displayText = "Sorry, an error occured when processing your request.";
            $this->sessionState = "END";
        }
    }

    function merchantCode($merchantCode) {
        $merchantCode = $merchantCode;

        if ($merchantCode == 'DSTV') {
            $merchantName = 'DStv';
        } elseif ($merchantCode == 'GOTVKE') {
            $merchantName = 'GOtv';
        } elseif ($merchantCode == 'KPLCPRE') {
            $merchantName = 'KPLC Prepaid';
        }

        return $merchantName;
    }

    function fetchHub3Bills($functionToCall, $billPacket) {
        $client = new IXR_Client($this->beepPresentment);
        $client->debug = false;

        $credentials = array(
            "username" => $this->walletusername,
            "password" => $this->walletpassword,
            "hubClientID" => 1,
        );

        $dataToSend = array(
            "credentials" => $credentials,
            "billPacket" => $billPacket
        );

//select server process/function to call
        $client->query($functionToCall, $dataToSend);

        $response = $client->getResponse();

        if (!$response) {
            $error_message = $client->getErrorMessage();
            print $error_message;
        }
        return $response;
    }

    function fetchHub4Bills($functionToCall, $billPacket) {
        $client = new IXR_Client($this->hub4Presentment);
        $client->debug = false;

        /* $credentials = array(
          "username" => "dtb_mb_api_user",
          "password" => "dtbC3llulant!"
          ); */
        $credentials = array(
            "username" => "boaAPIAccess",
            "password" => "BOA20!3"
        );


        $dataToSend = array(
            "credentials" => $credentials,
            "packet" => $billPacket
        );

//select server process/function to call
        $client->query($functionToCall, $dataToSend);

        $response = $client->getResponse();

        if (!$response) {
            $error_message = $client->getErrorMessage();
            print $error_message;
        }
        return $response;
    }

    function getMultichoiceBill($method, $detail) {
        $requestParams['countryCode'] = 'Kenya';
        $requestParams['requestParam'] = $detail;

        $params = $requestParams;

//jSON URL which should be requested
        $json_url = $this->presentment . '?method=' . $method;

//jSON String for request
        $json_string = json_encode($params);

//Initializing curl
        $ch = curl_init($json_url);

//Configuring curl options
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => $json_string
        );

//Setting curl options
        curl_setopt_array($ch, $options);

//Getting results
        $response = curl_exec($ch);

//Getting jSON result string
        $result = json_decode($response, true);
        $statusCode = $result['StatusCode'];
        $obj = "";

        if ($statusCode == 110 or $statusCode == 160) {
            $obj = $statusCode;
        } elseif ($statusCode == 120 or $statusCode == 125 or $statusCode == 130 or $statusCode == 135 or $statusCode == 140 or $statusCode == 165) {
            $obj = $result;
        }

        return $obj;
    }

    /*
     * Funds Transfer
     */

    function processFundsTransfer($input) {
        if ($this->previousPage == "account-prompt") {
            $extra = $this->getSessionVar('extra');
            if ($extra == "null") {
                $this->displayText = "Funds Transfer\nEnter amount you wish to transfer (UGX):";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "process-amount-input";
                $this->saveSessionVar('bankTransferAccount', $input);
                $this->nextFunction = "processFundsTransfer";
            } else {
// the customer had nominations
                $contents = explode("*", $extra);
                $numOfAliases = $contents [0];
                $menu = $contents [1];
                $aliasArray = explode("^", $contents [2]);
                $selectedAlias = $aliasArray [$input - 1];

                if ($input == $numOfAliases) {
                    $this->displayText = "Enter the Account Number:";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "process-amount-input-one-alias";
                    $this->nextFunction = "processFundsTransfer";
                } else if ($selectedAlias == '') {
                    $this->displayText = "Invalid input\n$menu";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "account-prompt";
                    $this->saveSessionVar('extra', $numOfAliases . "*" . $menu . "*" . $contents [2]);
                    $this->nextFunction = "processFundsTransfer";
                } else {
                    $this->saveSessionVar('selectedAccountAlias', $selectedAlias);
                    $this->displayText = "Funds Transfer\nEnter amount you wish to transfer (UGX):";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "process-amount-input";
                    $this->nextFunction = "processFundsTransfer";
                }
            }
        } else if ($this->previousPage == "process-amount-input-one-alias") {
            $this->displayText = "Enter Amount (UGX) to transfer to Account number '$input'";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "process-amount-input";
            $this->saveSessionVar('bankTransferAccount', $input);
            $this->saveSessionVar('selectedAccountAlias', 'null');
            $this->nextFunction = "processFundsTransfer";
        } else if ($this->previousPage == "process-amount-input") {
            if ($input > $this->MAXFTTRANSFER or $input < $this->MINFTTRANSFER) {
                $this->displayText = "Invalid input\nPlease reply with a value between UGX $this->MINFTTRANSFER and $this->MAXFTTRANSFER";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "process-amount-input";
                $this->nextFunction = "processFundsTransfer";
            } else {
                $accountAliasProvided = $this->getSessionVar('selectedAccountAlias');

// check whether an account number was provided
                if ($accountAliasProvided == 'null') {
                    $this->displayText = "Do you wish to nominate account No. " . $this->getSessionVar('bankTransferAccount') . "?\n1: Yes\n 2: No";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "bank-bank-transfer-confirm";
                    $this->nextFunction = "processFundsTransfer";
                } else {
                    $alias = explode("*", $this->getSessionVar('accountID+accountAlias'));
                    $alias = $alias [1];

                    $this->displayText = "Confirm that you wish to transfer " . $this->format_cash($input, $this->Currency) . " from Acc: $alias to Acc: $accountAliasProvided\n1: Confirm\n2: Reject";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "end-prompt-process-trx";
                    $this->saveSessionVar('nomination', "NO");
                    $this->saveSessionVar('bankTransferAccount', $accountAliasProvided);
                    $this->saveSessionVar('alias', $accountAliasProvided);
                    $this->nextFunction = "processFundsTransfer";
                }
                $this->saveSessionVar('fundsTransferAmount', $input);
            }
        } else if ($this->previousPage == "bank-bank-transfer-confirm") {
            if ($input == null) {
                $input = $extra;
            } else {
                switch ($input) {
                    case "1" :
                        $this->displayText = "Please give the account number a nickName e.g my main.";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "save-account-nomination";
                        $this->saveSessionVar('nomination', "YES");
                        $this->nextFunction = "processFundsTransfer";
                        break;
                    case "2" :
                        $amount = $this->getSessionVar('fundsTransferAmount');
                        $account = $this->getSessionVar('bankTransferAccount');
                        $alias = explode("*", $this->getSessionVar('accountID+accountAlias'));
                        $alias = $alias [1];

                        $this->displayText = "Confirm that you wish to transfer " . $this->format_cash($amount, $this->Currency) . " from Acc: $alias to Acc: $account\n1: Confirm\n2: Reject";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "end-prompt-process-trx";
                        $this->saveSessionVar('nomination', "NO");
                        $this->saveSessionVar('alias', "NULL");
                        $this->nextFunction = "processFundsTransfer";
                        break;
                    default :
                        $this->displayText = "Invalid entry. Please reply with\n1: Yes \n2: No";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "bank-bank-transfer-confirm";
                        $this->nextFunction = "processFundsTransfer";
                }
            }
        } else if ($this->previousPage == "save-account-nomination") {
            $nominationLength = strlen($input);
            $account = $this->getSessionVar('bankTransferAccount');

            if ($nominationLength < $this->MINNominationAliasLength or $nominationLength > $this->MAXNominationAliasLength) {
                $this->displayText = "Invalid entry\nNick name should be between $this->MINNominationAliasLength and $this->MAXNominationAliasLength characters. Please enter a unique nick name for '$account'";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "save-account-nomination";
                $this->nextFunction = "processFundsTransfer";
            } else {
// second check if alias exists in profile nominations
                $nominationdata = $this->clientProfile ['profileNominations'];
                $nominationCount = false;

                foreach ($nominationdata as $value) {
                    if ($value ['alias'] == $input) {
                        $nominationCount == true;
                    } else {
                        $nominationCount == false;
                    }
                }
                if (!$nominationCount) {
// capture the amount
                    $amount = $this->getSessionVar('fundsTransferAmount');
                    $account = $this->getSessionVar('bankTransferAccount');
                    $alias = explode("*", $this->getSessionVar('accountID+accountAlias'));
                    $alias = $alias [1];

                    $this->displayText = "Confirm that you wish to transfer " . $this->format_cash($amount, $this->Currency) . " from Acc: $alias to Acc: $account\n1: Confirm\n2: Reject";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "end-prompt-process-trx";
                    $this->saveSessionVar('alias', $input);
                    $this->nextFunction = "processFundsTransfer";
                } else {
                    $this->displayText = "Alias '$input' already exists. Please reply with a unique nick name for account '$account'";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "save-account-nomination";
                    $this->nextFunction = "processFundsTransfer";
                }
            }
        } else if ($this->previousPage == "end-prompt-process-trx") {
            switch ($input) {
                case 1 :


                    $accountDetails = $this->getSessionVar('accountID+accountAlias');

                    $accountDetails = explode("*", $accountDetails);
                    $accountID = $accountDetails [0];
                    $accountAlias = $accountDetails [1];
                    $bankTransferAccount = $this->getSessionVar('bankTransferAccount');
                    $amount = $this->getSessionVar('fundsTransferAmount');
                    $bankCode = $this->getSessionVar('fundsTransferBranchCode');
                    $nomination = $this->getSessionVar('nomination');
                    $alias = $this->getSessionVar('alias');

                    $encryptedpin = $this->getSessionVar('encryptedPin');

                    $fundsTransferPayloadArray = array(
                        "serviceID" => $this->CBSTOCBSFtServiceID,
                        "flavour" => "open",
                        "pin" => $encryptedpin,
                        "accountAlias" => $accountAlias,
                        "amount" => $amount,
                        "columnA" => $bankTransferAccount,
                        "columnB" => $bankCode,
                        "columnD" => $alias,
                        "accountID" => $accountID,
                        "nominate" => $nomination
                    );

                    $statusCode = 2;

// log request into channelRequests
                    $successLog = $this->logChannelRequest($fundsTransferPayloadArray, $statusCode);

                    if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                        $this->displayText = "Your Funds Transfer request has been received. $this->confirmatory $this->FULLBANKNAME";
                        $this->sessionState = "END";
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request. ";
                        $this->sessionState = "END";
                    }

                    break;
                case 2 :
                    $this->startPage();
                    break;
                default :
                    $this->displayText = "Invalid entry.Please reply with\n1: Confirm\n2: Reject";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "end-prompt-process-trx";
                    $this->nextFunction = "processFundsTransfer";
                    break;
            }
        }
    }

    /*
     * Change PIN
     */

    function newPIN($input) {
        $pinLength = strlen($input);

        if ($pinLength < $this->MINPINLength or $pinLength > $this->MAXPINLength) {
// pin not of allowed length
            $this->displayText = "Invalid entry. PIN should be between $this->MINPINLength and $this->MAXPINLength characters. Please enter your new mobile banking PIN:";
            $this->nextFunction = "newPIN";
            $this->sessionState = "CONTINUE";
        } elseif (!is_numeric($input) and $this->enforceNumericPINS) {
// pin not numeric
            $this->displayText = "Invalid entry. Only numerical PINs allowed. Please enter your new mobile banking PIN:";
            $this->nextFunction = "newPIN";
            $this->sessionState = "CONTINUE";
        } else {
            if ($this->getSessionVar('extra') == "validatePIN") {
                $oldPin = $this->getSessionVar('oldPinNumber');
                $newPin = $this->getSessionVar('newPinNumber');

                if ($oldPin == $newPin) {
                    $this->displayText = "Old PIN and New PIN are the same. Please enter your new mobile banking PIN:";
                    $this->nextFunction = "newPIN";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('newPinNumber', "");
                    $this->saveSessionVar('extra', "");
                } elseif ($newPin != $input) {
                    $this->displayText = "New PINs entered do not match. Please enter your new mobile banking PIN:";
                    $this->nextFunction = "newPIN";
                    $this->sessionState = "CONTINUE";
                    $this->saveSessionVar('newPinNumber', "");
                    $this->saveSessionVar('extra', "");
                } else {
                    /*
                     * <Payload><serviceID>7</serviceID><flavour>noFlavour</flavour> <pin>27d7427d34846bad0e7da7e7a6251557f336b6a0ca8fb00444baeb4901a1894c7166eb9ab1117b191b1f410b0ab4ccccd973520c21d88ae10b1a664071</pin> <newPin>4c7c30f6d27a8272ce2668649087ce1024c32846a8d4764f3b6ad942c6e51f6603e3c7274efadc2a8a3ee17f3f4c845b544d21d49175cdcad809f09149</newPin></Payload>
                     */
                    $encryptedPin = $this->getSessionVar('encryptedpin');
                    $encryptedNewPin = $this->encryptPin($newPin, 1);

                    $pinPayloadArray = array(
                        "serviceID" => $this->customerPinChangeServiceID,
                        "flavour" => "noFlavour",
                        "pin" => $encryptedPin,
                        "newPin" => $encryptedNewPin
                    );

                    $statusCode = 2;

// log request into channelRequests
                    $successLog = $this->logChannelRequest($pinPayloadArray, $statusCode);

                    if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                        $this->displayText = "Your PIN change request has been received. $this->confirmatory $this->BANK_SIGNATURE";
                        $this->sessionState = "END";
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request.";
                        $this->sessionState = "END";
                    }
                }
            } else {
                $this->displayText = "Please re-enter your new DTB PIN:";
                $this->nextFunction = "newPIN";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar('newPinNumber', $input);
                $this->saveSessionVar('extra', "validatePIN");
            }
        }
    }

    function JamboPay($input) {
//$daily=new DailyPacking();


        if ($this->previousPage == "Jambo") {
            $intValue = (int) $input;
            switch ($intValue) {
                case 1:
                    $daily = new DailyPacking();
                    $result = $daily->initPayment("init");
                    $zoneCodes = $result->zoneCodes;
                    $vehicleTypes = $result->vehicleTypes;
                    $zoneCode = $this->formJamboMessage($zoneCodes);
                    $this->saveSessionVar("zones", $zoneCodes);
                    $this->saveSessionVar("vehicle", $vehicleTypes);
                    $this->logMessage("Message---> ", $zoneCode, DTBUGconfigs::LOG_LEVEL_INFO);

                    $this->saveSessionVar("parkingZones", sizeof($zoneCodes));
                    $message = "Please  choose the zone you are in\n";
                    $message .= $zoneCode;
                    $this->displayText = $message;
                    $this->previousPage = "zone";
                    $this->nextFunction = "JamboPay";
                    $this->sessionState = "CONTINUE";

                    break;
                default:
                    $this->displayText = "Invalid selection. Choose\n1: Daily Parking";
                    $this->previousPage = "Jambo";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "JamboPay";

                    break;
            }
        } elseif ($this->previousPage == "zone") {
            $numberOfZones = $this->getSessionVar("parkingZones");
            $intValue = (int) $input;
            if ($intValue >= 1 && $intValue <= $numberOfZones) {

                $zoneCodes = $this->getSessionVar("zones");
                $vehicleTypes = $this->getSessionVar("vehicle");
                $myzoneCode = $zoneCodes[$input - 1];
                $this->saveSessionVar("zoneCode", $myzoneCode->ZoneCode);
                $vehicles = $this->formJamboMessage($vehicleTypes);
// $this->saveSessionVar("zoneCode", $input);
                $vehicleTypesSize = sizeof($this->getSessionVar('vehicle'));
                $this->saveSessionVar("vehicleTypesSize", $vehicleTypesSize);
                $message = "Choose your vehicle type\n";
                $message .= $vehicles;
                $this->displayText = $message;
                $this->previousPage = "vehicletype";
                $this->nextFunction = "JamboPay";
                $this->sessionState = "CONTINUE";
            } else {

                $zoneArray = $this->getSessionVar("zones");
                $zones = $this->formJamboMessage($zoneArray);
                $message = "Invalid selection. Please choose the zone you are in\n";
                $message .= $zones;
                $this->displayText = $message;
                $this->previousPage = "zone";
                $this->nextFunction = "JamboPay";
                $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "vehicletype") {
            $vehicleTypeSize = $this->getSessionVar('vehicleTypesSize');
            $intValue = (int) $input;
            if ($intValue >= 1 && $intValue <= $vehicleTypeSize) {

                $vehicleTypes = $this->getSessionVar("vehicle");
                $vehicle = $vehicleTypes[$input - 1];
//$this->saveSessionVar("zoneCode", $vehicle->VehicleTypeCode);
                $this->logMessage(" Vehicle returned---> ", $vehicle, DTBUGconfigs::LOG_LEVEL_INFO);

                $this->saveSessionVar("vehicleTypeCode", $vehicle->VehicleTypeCode);
                $message = "Enter your vehicle registration number in the format \nKAA 100A";
                $this->displayText = $message;
                $this->previousPage = "regvehicle";
                $this->nextFunction = "JamboPay";
                $this->sessionState = "CONTINUE";
            } else {
                $vehicleTypes = $this->getSessionVar("vehicle");
                $vehicles = $this->formJamboMessage($vehicleTypes);
                $message = "Invalid selection. Choose your vehicle type\n";
                $message .= $vehicles;
                $this->displayText = $message;
                $this->previousPage = "vehicletype";
                $this->nextFunction = "JamboPay";
                $this->sessionState = "CONTINUE";
            }
        } elseif ($this->previousPage == "regvehicle") {
            if (preg_match("/^K[A-Z]{2}[ ][0-9]{3}[A-Z]{1}/", $input)) { //Regex to check if the input matches the pattern KAA 123A
                $this->saveSessionVar("vehicleRegistration", $input);

                $username = '97763838';
                $agentRef = $this->_activityID;
                $registrationNo = $input;
                $vehicleTypeCode = $this->getSessionVar("vehicleTypeCode");
                $zoneCode = $this->getSessionVar("zoneCode");
                $custMobileNo = $this->_msisdn;
                $passphrase = "3637137f-9952-4eba-9e33-17a507a2bbb2";
                $daily = new DailyPacking();
                $payment = $daily->PreparePaymentDailyPayment($agentRef, $registrationNo, $vehicleTypeCode, $zoneCode, $custMobileNo);

                if ($payment->price > 0) {
                    $amountDue = number_format($payment->price, 0, '.', '');
                    $this->saveSessionVar("utilityBillAmount", $amountDue);
                    $this->saveSessionVar("transactionID", $payment->transactionID);
                    $this->saveSessionVar(utilityBillAccountNo, $payment->transactionID);
                    $message = "Your parking charge  is $amountDue . Proceed to pay?\n1:Yes \n2:No";
                    $this->displayText = $message;
                    $this->previousPage = "confirmJambo";
                    $this->nextFunction = "JamboPay";
                    $this->sessionState = "CONTINUE";
                } else {
                    $message = "Sorry. An error occured.Try again later. Select \n1: Home \n0: Exit ";
                    $this->displayText = $message;
//$this->previousPage = "confirmJambo";
                    $this->nextFunction = "Reload";
                    $this->sessionState = "CONTINUE";
                }
            } else {
                $this->displayText = "Invalid entry. Enter your vehicle registration number in the format\nKAA 100A";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "regvehicle";
                $this->nextFunction = "JamboPay";
            }
        } else if ($this->previousPage == "confirmJambo") {


            $selectedAccount = $this->getSessionVar("selectedAccount");
//$amount = $topUpAmount;

            $profile = $this->getSessionVar("agencyProfile");
            $accounts = $profile["accounts"];
//$message="Please select an account";
            $pin = $this->getSessionVar("customerpin");
            $encryptedpin = $this->encryptPin($pin, 1);
            $accountID = $selectedAccount["accountID"];
            $accountAlias = $selectedAccount["alias"];
            $pin = $this->getSessionVar("customerpin");
            $encryptedPin = $this->encryptPin($pin, $uniqueID);
            $amount = $this->getSessionVar('utilityBillAmount');
            $merchantCode = $this->getSessionVar('merchantCode');
//$accountID =
            $billAccountNo = $this->getSessionVar('utilityBillAccountNo');
            $enrolment = $this->getSessionVar('billEnrolment');
            $enrolBillNo = $this->getSessionVar('billEnrolmentNumber');
            $transactionID = $this->getSessionVar('transactionID');


            $clientAccounts = $this->getSessionVar('clientAccounts');
            $accountIDs = $this->getSessionVar('storedAccountID');
            $this->displayText = "Select account:\n" . $clientAccounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
            $this->saveSessionVar(billEnrolment, 'NO');
            $this->saveSessionVar(billEnrolmentNumber, 'NULL');
        }
    }

    public function formJamboMessage($responseArray) {
        $message = "";
        for ($i = 0; $i < count($responseArray); $i++) {
            $current = $i + 1;
            $zoneCode = $responseArray[$i];
            $message .= " " . $current . ". " . $zoneCode->Description . "\n";
        }
        return $message;
    }

    function processFullStatement($input) {
        $today = date('m/d/Y');

        if ($this->previousPage == 'startDate') {
            $day = substr($input, 0, 2);
            $month = substr($input, 2, 2);
            $year = substr($input, 4, 4);
            $startDate = $month . "/" . $day . "/" . $year;

            if (!is_numeric($input) || (strlen($input) < 8) || (strlen($input) > 8)) {
                $this->displayText = "Invalid input. Enter start date for full statement in format ddmmyyyy(DayMonthYear) e.g '28122013'";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processFullStatement";
                $this->previousPage = "startDate";
            } elseif (strtotime($startDate) >= strtotime($today)) {
                $this->displayText = "Start Date cannot be after today's date. Please enter a correct To Date (ddmmyyyy)";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processFullStatement";
                $this->previousPage = "startDate";
                $this->saveSessionVar('extra', $startDate);
            } else {
                $this->displayText = "Please Enter End date (ddmmyyyy):";
                $this->nextFunction = "processFullStatement";
                $this->saveSessionVar('startDate', $input);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "endDate";
            }
        } elseif ($this->previousPage == 'endDate') {
            $day = substr($input, 0, 2);
            $month = substr($input, 2, 2);
            $year = substr($input, 4, 4);
            $endDate = $month . "/" . $day . "/" . $year;

            $startDate = $this->getSessionVar('startDate');

            if (!is_numeric($input) || (strlen($input) < 8) || (strlen($input) > 8)) {
                $this->displayText = "Invalid input. Enter start date for full statement in format ddmmyyyy (DayMonthYear) e.g " . date('dmY');
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processFullStatement";
                $this->previousPage = "endDate";
            } elseif (strtotime($endDate) > strtotime($today)) {
                $this->displayText = "End Date cannot be after today's date. Please enter a correct To Date (ddmmyyyy)";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processFullStatement";
                $this->previousPage = "endDate";
                $this->saveSessionVar('extra', $startDate);
            } elseif (strtotime($endDate) <= strtotime($startDate)) {
                $this->displayText = "End Date cannot be earlier than Start Date. Please enter a correct To Date (ddmmyyyy)";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processFullStatement";
                $this->previousPage = "endDate";
                $this->saveSessionVar('extra', $startDate);
            } else {
                $this->displayText = "Please choose delivery mode.\n1: Email";
                $this->nextFunction = "processFullStatement";
                $this->saveSessionVar('endDate', $input);
                $this->sessionState = "CONTINUE";
                $this->previousPage = "confirmMode";
            }
        } elseif ($this->previousPage == 'confirmMode') {
            switch ($input) {
                case 1 :
                    $accountDetails = $this->getSessionVar('accountID+accountAlias');

                    $accountDetails = explode("*", $accountDetails);
                    $accountID = $accountDetails [0];
                    $accountAlias = $accountDetails [1];

                    $encryptedpin = $this->getSessionVar('encryptedPin');
                    $startDate = $this->getSessionVar('startDate');
                    $endDate = $this->getSessionVar('endDate');



// formulate specific payload for this service as key value array
                    $chequeBookRequestServicePayloadArray = array(
                        "serviceID" => $this->CBSFULLSTATServiceID,
                        "flavour" => "noFlavour",
                        "pin" => $encryptedpin,
                        "accountAlias" => $accountAlias,
                        "columnA" => $startDate,
                        "columnB" => $endDate,
                        "accountID" => $accountID,
                        "columnC" => "email"
                    );

                    $statusCode = 2;

// log request into channelRequests
                    $successLog = $this->logChannelRequest($chequeBookRequestServicePayloadArray, $statusCode);

                    if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                        $this->displayText = "Your full statement request is being processed. $this->confirmatory";
                        $this->sessionState = "END";
// $this->nextFunction = "selectBankingServices";
                    } else {
                        $this->displayText = "Sorry, an error occured when processing your request. ";
                        $this->sessionState = "END";
                    }

                    break;

                default :
                    $this->displayText = "Wrong selection. Please choose delivery mode.\n1: Email";
                    $this->nextFunction = "processFullStatement";
                    $this->sessionState = "CONTINUE";
                    $this->previousPage = "confirmMode";
                    break;
            }
        } else {
            $this->displayText = "Please Enter Start date (ddmmyyyy):";
            $this->nextFunction = "processFullStatement";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "startDate";

            /*
             * switch ($input) { case 1 : $this -> displayText = "Please Enter Start date (ddmmyyyy):"; $this -> nextFunction = "processFullStatement"; $this -> sessionState = "CONTINUE"; $this -> previousPage = "startDate"; break; case 2 : $this -> startPage(); break; default : $this -> displayText = "Wrong selection. Please select\n1: Yes\n2: No"; $this -> nextFunction = "processFullStatement"; $this -> sessionState = "CONTINUE"; break; }
             */
        }
    }

    function processCurrency() {
        if ($this->previousPage == "selectCurrency") {
            $this->displayText = "Select currency wallet to add.\n1: USD\n2: EUR\n3: JPY\n4:GBP\n5: CHF\n6: CAD\n7: AUD/NZD\n8: ZAR";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "processSelectedCurrency";
            $this->nextFunction = "processCurrency";
        } elseif ($this->previousPage == "processSelectedCurrency") {
            $addCurrencyArray = array(
//What should be in here??
            );

            $statusCode = 2;

// log request into channelRequests
            $successLog = $this->logChannelRequest($addCurrencyArray, $statusCode);

            if ($successLog ['SUCCESS'] == TRUE) {
// send payload to system and get response
                $this->displayText = "Your full statement request is being processed. $this->confirmatory";
                $this->sessionState = "END";
// $this->nextFunction = "selectBankingServices";
            } else {
                $this->displayText = "Sorry, an error occured when processing your request. ";
                $this->sessionState = "END";
            }
        }
    }

    function processForexAlerts($input) {
        $clientAccounts = $this->getSessionVar('clientAccounts');

        $source = $this->getSessionVar('vanillaService');
        $this->displayText = "You selected " . $source;
        if ($source == 'forexRatesRequest') {
            if ($input == 1) {
                $this->saveSessionVar('forexRates', 'USD');
            } elseif ($input == 2) {
                $this->saveSessionVar('forexRates', 'EUR');
            } elseif ($input == 3) {
                $this->saveSessionVar('forexRates', 'GBP');
            } elseif ($input == 4) {
                $this->saveSessionVar('forexRates', 'KES');
            } elseif ($input == 5) {
                $this->saveSessionVar('forexRates', 'TZS');
            } else {
                $this->displayText = "Invalid entry. Please select number of leaves\n1. 25\n2. 50\n3.100";
                $this->sessionState = "CONTINUE";
                $this->saveSessionVar('vanillaService', 'chequeBookRequest');
                $this->nextFunction = "processChequeBookRequest";
            }

            $this->displayText = "Select account for the forex rates enquiry:\n" . $clientAccounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        } else {
            $this->saveSessionVar('chequeDetails', $input);
            $this->displayText = "Select account:\n" . $clientAccounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validateAccountDetails";
        }
    }

    function synchronousProcessing($requestPayload, $channelRequestID) {

        $this->logMessage("Making synchronous call using channelID: ", $channelRequestID, DTBUGconfigs::LOG_LEVEL_INFO);

        $request_xml = "<Payload>";
        foreach ($requestPayload as $key => $value) {

            $request_xml .= '<' . $key . '>' . $value . '</' . $key . '>';
        }

        $request_xml .= "</Payload>";

        $payload = $request_xml;

        $credentials = array(
            'cloudUser' => $this->walletusername,
            'cloudPass' => $this->walletpassword,
        );

        if (is_array($channelRequestID))
            $channelRequestID = $channelRequestID['LAST_INSERT_ID'];

        $cloudPacket = array(
            "MSISDN" => $this->_msisdn,
            "destination" => $this->accessPoint,
            "IMCID" => $this->IMCID,
            "channelRequestID" => $channelRequestID,
            "networkID" => 1,
            "clientSystemID" => 77,
            "systemName" => $this->systemName,
            "cloudDateReceived" => date("Y-m-d G:i:s"),
            "payload" => base64_encode($payload),
            "imcRequestID" => $this->imcRequestID,
            "requestMode" => $this->requestMode,
        );

        $params = array(
            'credentials' => $credentials,
            'cloudPacket' => $cloudPacket,
        );

        $this->logMessage("Payload to wallet: ", $params, DTBUGconfigs::LOG_LEVEL_INFO);

        try {
            $client = new IXR_Client($this->serverURL);
            $client->debug = false;
            $client->query($this->process_request, $params);
            $result = $client->getResponse();
            $data = json_decode($result, true);

            $this->logMessage("Response from wallet: ", $data, DTBUGconfigs::LOG_LEVEL_INFO);

            return $data;
        } catch (Exception $exception) {
            $this->log->debug($this->INFOLOG, -1, "ERROR OCCURED: " . $exception->getMessage());
            return $exception->getMessage();
        }
    }

    function fetchCustomerData() {
        /**
         * Make api call to wallet to fetch member details and respond to user
         */
//$client = new IXR_Client ( $this->walletUrl );
        $fields_string = null;
        $fields = null;


        $fields = array(
//  "RESPONSE_TYPE" => 'JSON',
            "MSISDN" => $this->_msisdn,
            "USERNAME" => "system-user",
            "PASSWORD" => "lipuka"
        );

//$client->query ( $this->fetch_customer_details_function, $payload );
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');


        $response = $this->http_post($this->walletUrl, $fields, $fields_string);

        return $response;
    }

//Self registration
    function customer_self_register($input) {
        $regLevel = $this->getSessionVar('Reglevel');
        $questions = $this->fetchSelfRegQuestions();

// $Questions = array('6' => Array ('questionID' => 1, 'question' => 'Please Enter your ID Number or Passport Number' ) ,'5' => Array ('questionID' => 2, 'question' => 'Please enter your Date of Birth DD MM YY' ) ,'3' => Array ('questionID' => 3, 'question' => 'Please enter your DTB Bank Account' ) );


        If ($regLevel == "StartPage") {
            $this->displayText = "DTB Mobile lets you check balance,move money from your acc to mobile money and more. Please select an option\n1.Register\n0. Go to back";
            $this->sessionState = "CONTINUE";
            $this->previousPage = "startPage";
            $this->nextFunction = "customer_self_register";
            $this->saveSessionVar('Reglevel', "Questions");
        } elseif ($regLevel == "Questions") {
            if (is_numeric($questions)) {
                $this->displayText = "Sorry, we cannot process your request. Try again later";
                $this->sessionState = "END";
            } else {

                ksort($questions);
                $questions = array_values($questions);

                if ($input == 0 && $this->previousPage == 'startPage') {
                    $this->startPage();
                } else {
                    $SelfRegNum = $this->getSessionvar('SelfRegNum');
                    $response = $this->getSessionvar('QResponse');
                    $response = empty($response) ? array() : $response;
                    $Answer = ($input != 1 || $input != 2 && $this->previousPage != "startPage") ? array($SelfRegNum => array('questionID' => $questions[$SelfRegNum - 1]['questionID'], 'questionAnswer' => $input)) : array();
                    $QResponse = $response + $Answer;
                    $this->saveSessionVar('QResponse', $QResponse);
                    $SelfRegNum = (!empty($SelfRegNum)) ? $SelfRegNum : 0;
                    $QuestionCount = count($questions) - $SelfRegNum;
//{"1":{"questionID":"4","questionAnswer":"123123"},"2":{"questionID":"5","questionAnswer":"123123"},"3":{"questionID":null,"questionAnswer":"123123"}}

                    if ($QuestionCount >= 1) {
                        $this->displayText = $questions[$SelfRegNum]['question'];
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "customer_self_register";
                        $this->nextFunction = "customer_self_register";
                        $this->saveSessionVar('Reglevel', "Questions");
                        $this->saveSessionVar("SelfRegNum", ++$SelfRegNum);
                    } else {
                        $this->displayText = "Do you accept the terms and conditions (www.dtbafrica.com).  \n1. Accept\n2. Decline ";
                        $this->sessionState = "CONTINUE";
                        $this->previousPage = "customer_self_register";
                        $this->nextFunction = "customer_self_register";
                        $this->saveSessionVar('Reglevel', "TnC");
                        $this->saveSessionVar('QresponsesA', $QResponse);
                    }
                }
            }
        } elseif ($regLevel == "TnC") {
            if ($input == 1) {
                $this->Qresponses($this->getSessionvar('QresponsesA'));
//$this->displayText  =json_encode($this->getSessionvar('QresponsesA'));
                $this->displayText = "Thank you for registering for DTB Mobile. Your application has been received and will be activated within 48 hours.";
                $this->sessionState = "END";
            } elseif ($input == 2) {
                $this->saveSessionVar('SelfRegNum', null);
                $this->saveSessionVar('QResponse', null);
                $this->saveSessionVar('QresponsesA', null);
                $this->startPage();
            } else {
                $this->displayText = "Invalid input\nDo you accept the terms and conditions. \n1. Yes\n2. No ";
                $this->sessionState = "CONTINUE";
                $this->previousPage = "customer_self_register";
                $this->nextFunction = "customer_self_register";
                $this->saveSessionVar('Reglevel', "TnC");
                $this->saveSessionVar('QresponsesA', $this->getSessionvar('QresponsesA'));
            }
        }
    }

    function fetchSelfRegQuestions() {
        $credentials = array("cloudUser" => "username",
            "cloudPass" => "password");
        $cloudPacket = array(
            "clientID" => 13,
            "languageID" => 1,
        );

        $payload = array("credentials" => $credentials,
            "cloudPacket" => $cloudPacket);
        $params = array('functionToCall' => 'selfRegistration.fetchQuestionsforUSSD', 'url' => $this->SelfRegServerUrl, 'payload' => $payload);
        $result = $this->SelfRegAPI($params);
        $this->logMessage("SelfReg FetchQuestions result: ", print_r($result, true), DTBUGconfigs::LOG_LEVEL_INFO);
        if ($result['STAT_CODE'] != 1) {
//            return $result['STAT_DESCRIPTION'];
            return $result['STAT_CODE'];
        } else {
            return $result['DATA'];
        }
    }

    function Qresponses($QResponse) {

        $credentials = array(
            "cloudUser" => "username",
            "cloudPass" => "password",
        );
        $payload = array(
            'MSISDN' => $this->_msisdn, //Valid phone number
            'CLIENTID' => '186', //the client ID set as per hub
            'CHANNEL' => 'USSD', //the channel
            "cloudUser" => "username",
            "cloudPass" => "password",
            'QUESTIONANSWERS' => json_encode($QResponse),
        );

        $params = array('functionToCall' => 'setResponses', 'url' => $this->SelfRegApiUrl, 'payload' => $payload);
        $result = $this->SelfRegAPI($params);
    }

    function SelfRegAPI($params) {
        extract($params);
        $client = new IXR_Client($url);
        $client->query($functionToCall, $payload);
        $client->debug = false;
        $response = $client->getResponse();
        if (!$response) {
            $error_message = $client->getErrorMessage();
            $return = array(
                "DATA" => "NULL",
                "STAT_CODE" => 3,
                "STAT_TYPE" => 4,
                "STAT_DESCRIPTION" => $error_message,
            );
            $this->logMessage("SelfRegAPI response: ", $response, DTBUGconfigs::LOG_LEVEL_INFO);

            return $return;
        } else {
            return $response;
        }
    }

    function panamaHome($amount = null, $phoneNumber = null) {
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = DTBUGconfigs::UG_CODE . substr($phoneNumber, 1);
        }
        $this->saveSessionVar('panamaAmount', $amount);
        $this->saveSessionVar('panamaPhoneNumber', $phoneNumber);
        $CountgetAcc = count($this->getSessionVar('storedAccountNumbers'));
        $this->logMessage("customer account numbers ", $CountgetAcc, DTBUGconfigs::LOG_LEVEL_INFO);
        if ($CountgetAcc == 1) {
            $this->saveSessionVar("panamaAccounts", 1);
            $this->panamaRequest(null, $phoneNumber);
        } else {
//            $this->toFile('i a');
            $this->panamaAccount($phoneNumber);
        }
    }

    function panamaAccount($msisdn = null) {
        $allAccountDetails = $this->getSessionVar("accountDetails");

        $accounts = "";
        $accountAlias = "";
        $accountCBSid = "";
        $countAccounts = 0;

        $accountDetails = explode("#", $allAccountDetails);
        $storedAliases = array();
// $storedAccountNumbers = array();
//For Each Account
        foreach ($accountDetails as $profileEnrolment) {
            $this->count++;

            $singleAccount = explode("|", $profileEnrolment);

            $accountCBSid = $singleAccount[0];
            $accountNumbers = $singleAccount[1];
//          $storedAccountNumbers[] = $accountNumbers;
            $accountAlias = $singleAccount[2];
            $storedAliases[] = $accountAlias;

            $countAccounts++;
            $accountIDs .= $accountCBSid . "^";
            $accounts .= $this->num . "@" . $accountAlias . "!";
            $clientAccounts .= $countAccounts . ": " . $accountAlias . "\n";
            $this->num++;
        }

        $this->displayText = "Select Account:\n$clientAccounts";
        $this->sessionState = "CONTINUE";
        $this->nextFunction = "panamaRequest";
    }

    function panamaRequest($input = null, $phoneNumber = null) {
        $availableAliases = $this->getSessionVar('availableAliases');
        $customerAliases = $this->getSessionVar('storedAliases');
        $customerAccounts = $this->getSessionVar('storedAccountNumbers');
        $accountIDs = $this->getSessionVar('storedAccountID');
        $amount = $this->getSessionVar('panamaAmount');
        $phoneNumber = $this->getSessionVar('panamaPhoneNumber');
        if ($this->previousPage == "panamaEnterAmount") {
            $amount = $input;
            $input = $this->getSessionVar("SelectedPanama");
        }

        $alias = "";
        $accountID = "";
        $acc = "";

        //    $this->logMessage("Customer account aliases :", $customerAliases[0], DTBUGconfigs::LOG_LEVEL_INFO);
        if (($amount >= $this->panamaMinimum && $amount <= $this->panamaMaximum) && $this->previousPage != "panamaRequest") {
            $this->displayText = "Enter your Pin:";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "panamaRequest";
            $this->previousPage = "panamaRequest";
            $this->saveSessionVar("SelectedPanama", $input);
        } else if (($amount < $this->panamaMinimum || $amount > $this->panamaMaximum) && $this->previousPage != "panamaRequest") {
            $this->displayText = "Invalid amount. Enter amount between {$this->panamaMinimum} and {$this->panamaMaximum}";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "panamaRequest";
            $this->previousPage = "panamaEnterAmount";
            $this->saveSessionVar("SelectedPanama", $input);
        } else {
            $airtimeReceipientNumber = $phoneNumber == null ? $this->_msisdn : $phoneNumber;
            if ($this->validateNumber($airtimeReceipientNumber)) {
                $receipientDetails = $this->getPanamaDetailsByPhoneNumber($airtimeReceipientNumber);
                if ($this->getSessionVar("panamaAccounts") == 1) {
                    $alias = $customerAliases[0];
                    $accountID = $accountIDs[0];
                    $acc = $customerAccounts[0];
                    $merchants = $receipientDetails["merchantCode"];
                    $pin = $input;

                    $this->logMessage("Customer one account: ", $alias, DTBUGconfigs::LOG_LEVEL_INFO);
                } else {

                    $accountPanama = $this->getSessionVar("SelectedPanama");
                    $merchants = $receipientDetails["merchantCode"];
                    $pin = $input;
                    $alias = $customerAliases[$accountPanama - 1];
                    $accountID = $accountIDs[$accountPanama - 1];
                    $acc = $customerAccounts[$accountPanama - 1];
                    $this->logMessage("Customer has many accounts but the selected account is : ", $alias, DTBUGconfigs::LOG_LEVEL_INFO);
                }
                /* $receipientDetails = $this->getPanamaDetailsByPhoneNumber($airtimeReceipientNumber);
                  if ($this->previousPage == "panamaRequest" && $this->getSessionVar("panamaAccounts") > 1) {
                  $accountPanama = $this->getSessionVar("SelectedPanama");
                  $merchants = $receipientDetails["merchantCode"];
                  $pin = $input;
                  $alias = $customerAliases[$accountPanama - 1];
                  $accountID = $accountIDs[$accountPanama - 1];
                  $acc = $customerAccounts[$accountPanama - 1];
                  $this->logMessage("Customer has many accounts but the selected account is : ", $alias, DTBUGconfigs::LOG_LEVEL_INFO);

                  } else {
                  $merchants = $receipientDetails["merchantCode"];
                  $pin = $input;
                  } */

                $payload = array(
                    "serviceID" => $this->BillPayServiceID,
                    "flavour" => "open",
                    "pin" => $this->encryptPin($pin, 1),
                    "accountAlias" => $alias,
                    "amount" => $amount,
                    "merchantCode" => $merchants,
                    "accountID" => $accountID,
                    "enroll" => "NO",
                    "CBSID" => 1,
                    "columnD" => "NULL",
                    "columnA" => $airtimeReceipientNumber,
                    "columnC" => $merchants,
                );

// log request into channelRequests
                $statusCode = 2;
                $successLog = $this->logChannelRequest($payload, $statusCode, NULL, 191);
                $this->logMessage("Channel log results: ", $successLog, DTBUGconfigs::LOG_LEVEL_INFO);

                if ($successLog['SUCCESS'] == TRUE) {
                    $this->displayText = "Your  request for UGX $amount worth of airtime has been received and is being processed. Thank you";
                    $this->sessionState = "END";
                } else {
                    $this->displayText = "Sorry, an error occured when processing your request.";
                    $this->sessionState = "END";
                }
            } else {
                $this->displayText = "Sorry, You entered an invalid receipient number.";
                $this->sessionState = "END";
            }
        }
    }

    function getPhoneNetwork($msisdn) {
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

    function getPanamaDetailsByPhoneNumber($msisdn) {
        $details = array();
        if (preg_match($this->mtn_reg, $msisdn)) {
            $details["network"] = "MTN";
            $details["merchantCode"] = "PanamaMTNAirtime";
            $details["serviceID"] = $this->BillPayServiceID;
        } else if (preg_match($this->airtel_reg, $msisdn)) {
            $details["network"] = "AIRTEL";
            $details["merchantCode"] = "PanamaAirtelAirtime";
            $details["serviceID"] = $this->BillPayServiceID;
        } else if (preg_match($this->orange_reg, $msisdn)) {
            $details["network"] = "ORANGE";
            $details["merchantCode"] = "PanamaOrangeAirtime";
            $details["serviceID"] = $this->BillPayServiceID;
        } else {
            $details["network"] = "Unknown";
            $details["merchantCode"] = "BILL_PAY";
            $details["serviceID"] = $this->BillPayServiceID;
        }
        return $details;
    }

    function validateNumber($msisdn) {
        return ((strlen($msisdn) >= 10 && strlen($msisdn) <= 12) && ctype_digit($msisdn));
    }

    function formatDynamicMenuList($records) {
        if (is_array($records)) {
            $num = 1;
            $string = "";
            foreach ($records as $key => $value) {
                $string .= $num . ".$value\n";
                $num++;
            }
        }
        return $string;
    }

    /*
     * Function used for logging data purposes
     * */

    function logMessage($message, $result = null, $logLevel = DTBUGconfigs::LOG_LEVEL_INFO) {
        if ($result != null) {
            CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message . print_r($result, true)), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
        } else {
            CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
        }

//Log the data in the custom log
//        $this->flog($message . print_r($result, true));
    }

    function generatePinEncryptionID($key) {
        if ($key == 'null') {
            $key = rand(1000, 9999);
        }
        return $key;
    }

    function format_cash($num, $currency) {
        $thecash = number_format($num);
// writes the final format where $currency is the currency symbol.
        return $currency . ' ' . $thecash . "/-";
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

    public function BuyMasterPass($input = null) {
        $level = $this->getSessionVar('mcLevel');
        $accounts = $this->getSessionVar('clientAccounts');

        if ($input === "00") {

            $this->startPage();
        } elseif ($input === "0") {

            switch ($level) {
                case 'confirm':
                    $this->saveSessionVar('mcLevel', 'home');
                    $this->BuyMasterPass();
                    break;
                case 'selectAccount':
                    $this->saveSessionVar('mcLevel', 'amount');
                    $this->BuyMasterPass($this->getSessionVar('merchantID'));
                    break;
                default:
                    $this->saveSessionVar('mcLevel', 'home');
                    $this->BuyMasterPass();
                    break;
            }
        } elseif ($level == 'home') {
            $this->displayText = "MasterPass\nEnter Merchant ID\n\n00.Main Menu";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "BuyMasterPass";
            $this->saveSessionVar('mcLevel', 'amount');
        } elseif ($level == 'amount') {
            $this->displayText = "MasterPass\nEnter Amount:\n\n 0.Back\n00.Main Menu";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "BuyMasterPass";
            $this->saveSessionVar('mcLevel', 'confirm');
            $this->saveSessionVar("merchantID", $input);
        } elseif ($level == 'confirm') {
            $merchantID = $this->getSessionVar('merchantID');
            $this->displayText = "Confirm you want to pay\nMercahant: " . $merchantID . "\nAmount: " . $input . "\n1.Yes\n2.No \n\n 0.Back\n00.Main Menu";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "BuyMasterPass";
            $this->saveSessionVar('mcLevel', 'selectAccount');
            $this->saveSessionVar('utilityBillAmount', $input);
        } elseif ($level == 'selectAccount') {
            $this->displayText = "Select account :\n" . $accounts;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "BuyMasterPass";
            $this->saveSessionVar('mcLevel', 'pin');
        } elseif ($level == 'pin') {
            $customerAliases = $this->getSessionVar('storedAliases');
            $accountIDs = $this->getSessionVar('storedAccountID');
            $this->saveSessionVar('alias', $customerAliases[$input - 1]);
            $this->saveSessionVar('accountID', $accountIDs[$input - 1]);
            $this->displayText = "Enter your pin: ";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "validatePin";
            $this->saveSessionVar('origin', 'masterpass');
            $this->saveSessionVar('merchantCode', 'MPB');
        }
    }

}

class DailyPacking {

    private $soapClient = null;
    private $wsdl = "https://197.155.81.226:1601/agencyservices?wsdl";
    private $passphrase = "3637137f-9952-4eba-9e33-17a507a2bbb2";
    private $userName = "97763838";
    private $date = "";
    private $log = null;
    private $mainClass = null;

    function __construct() {

        $this->soapClient = new SoapClient($this->wsdl);
        date_default_timezone_set('Australia/Melbourne');
        $this->date = date('Y/m/d h:i:s a', time());
        $this->mainClass = new UGDTBMobileBanking();
    }

    public function initPayment($param) {
        $Pass = SHA1($this->userName . '' . $this->date . '' . $this->passphrase);
        $options = array('userName' => $this->userName, 'timestamp' => $this->date, 'pass' => $Pass);

        $this->mainClass->logMessage("response from api ", $options);

        $theResponse = $this->soapClient->PreparePaymentDailyParkingInitDataPCKNCC($options);

        $this->mainClass->logMessage("response from api  ", $theResponse);

        $zoneCodes = $theResponse->PreparePaymentDailyParkingInitDataPCKNCCResult->ParkingZones->{'NCC.ZoneCodes'};
        $vehicleTypes = $theResponse->PreparePaymentDailyParkingInitDataPCKNCCResult->VehicleType->{'NCC.VehicleType'};
        $data = new stdClass();
        $data->zoneCodes = $zoneCodes;
        $data->vehicleTypes = $vehicleTypes;
//print_r($zoneCodes->{'NCC.ZoneCodes'}) ;
        return $data;
    }

    public function PreparePaymentDailyPayment($agentRef, $registrationNo, $vehicleTypeCode, $zoneCode, $custMobileNo) {

        $Pass = SHA1($this->userName . '' . $agentRef . '' . $registrationNo . '' . $vehicleTypeCode . '' . $zoneCode . '' . $this->passphrase);
        $options = array(
            'userName' => $this->userName,
            "agentRef" => $agentRef,
            "registrationNo" => $registrationNo,
            "vehicleTypeCode" => $vehicleTypeCode,
            "zoneCode" => $zoneCode,
            "custMobileNo" => $custMobileNo,
            "pass" => $Pass);
        $theResponse = $this->soapClient->PreparePaymentDailyPCKNCC($options);
        $this->mainClass->logMessage("data being sent out ", $options);

        $this->mainClass->logMessage(" response result code ", $theResponse->PreparePaymentDailyPCKNCCResult->Result->ResultCode);

        $payment = new stdClass();
        if ($theResponse->PreparePaymentDailyPCKNCCResult->Result->ResultCode == 0) {
            $payment->price = $theResponse->PreparePaymentDailyPCKNCCResult->PCKFee;
            $payment->transactionID = $theResponse->PreparePaymentDailyPCKNCCResult->TransactionID;
        }
        $payment->ResultText = $theResponse->PreparePaymentDailyPCKNCCResult->ResultText;
        return $payment;
    }

}

$UGDTBMobileBanking = new UGDTBMobileBanking ();
echo $UGDTBMobileBanking->navigate();
?>

