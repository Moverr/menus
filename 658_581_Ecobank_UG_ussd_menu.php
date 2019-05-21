    <?php

    /**

     * Created by PhpStorm.

     * User: Duncan

     * Date: 11/4/2016

     * Time: 2:46 PM

     */
    include "DynamicMenuController.php";

    require_once "ecobankSSLScripts/xmlrpc_client.php";

    class EcobankGlobalUSSDMenu extends DynamicMenuController {

        //Set the config Location

        const CONFIG_FILE = "ecobank_config_ug.xml";
        //Define the session constants to be used

        const SESSION_STATE_END = "END";
        const SESSION_STATE_CONTINUE = "CONTINUE";
        //Ecobank name

        const ECOBANK_NAME = "Ecobank";
        //Success authentication

        const HUB_SUCCESS_AUTH = 131;
    //    const HUB__BILLS_FOUND_CODES = array(226,227);

        const HUB_NO_BILLS_FOUND = 175;
        //Define the log levels

        const LOG_LEVEL_INFO = 4;
        const LOG_LEVEL_ERROR = 1;
        //Data constants where the actual values are needed,ie must be exactly as there are
        //Changing the value will break the menu functionality

        const SUCCESS = "success";
        const DATA = "data";
        const ERROR = "error";
        const MESSAGE = "message";
        const CHANNEL_REQUEST_SUCCESS = "SUCCESS";
        const CHANNEL_REQUEST_MESSAGE = "MESSAGE";
        const CHANNEL_REQUEST_DATA = "DATA";
        const CHANNEL_REQUEST_LAST_INSERT_ID = "LAST_INSERT_ID";
        const WALLET_SUCCESS = "SUCCESS";
        const WALLET_MESSAGE = "MESSAGE";
        const WALLET_DATA = "DATA";
        const WALLET_STAT_CODE = "STAT_CODE";
        const WALLET_STAT_TYPE = "STAT_TYPE";
        //Menu constants

        const WALLET_NOMINATION_NAME = "walletNominationName";
        const SAVE_NOMINATION = "saveNomination";
        const WALLET_NOMINATION_ACC_NOS = "walletNominationAccountNumber";
        const BILL_SERVICE_ID = "billServiceId";
        const BILL_SERVICE_CODE = "billServiceCode";
        const BILL_AMOUNT = "billAmount";
        const BILL_ACCOUNT_NUMBER = "billAccountNumber";
        const BILL_FUNCTION_DATA = "billFunctionData";
        const BILLS_FORMATTED_DATA = "billsFormatedData";
        const CHOSEN_BILL = "chosenBill";
        const BILL_INVOICE_NUMBER = "billInvoiceNumber";
        const NUMBER_OF_BILLS = "numberOfBills";
        const SAVE_BENEFICIARY = "saveBeneficiary";
        const ACCOUNT_ALIAS = "accountAlias";
        const ACCOUNT_NUMBER = "accountNumber";
        const CBS_ACCOUNT_ID = "cbsAccountID";
        const CLIENT_PROFILE_ID = "clientProfileID";
        const PROFILE_ACTIVE_STATUS = "profileActiveStatus";
        const PROFILE_PIN_STATUS = "profilePinStatus";
        const CUSTOMER_NAMES = "customerNames";
        const CUSTOMER_ACCOUNTS = "customerAccounts";
        const CUSTOMER_COMPLETE_DATA = "customerCompleteData";
        const CUSTOMER_IFT_NOMINATIONS = "customerIftNominations";
        const CHOSEN_CUSTOMER_ACCOUNT = "chosenCustomerAccount";
        const CHOSEN_CUSTOMER_NOMINATED_NAME = "chosenCustomerNominatedName";
        const SELECTED_FT_RECIPIENT = "selectedFTRecepient";
        const DISABLE_MENU = "disableMenu";
        const ENCRYPTED_PIN = "encryptedPin";
        const ENCRYPTED_AUTH_PIN = "encryptedAuthPin";
        const NEW_PIN = "newPin";
        const ONE_TAP_PIN = "oneTapPin";
        const RE_NEW_PIN = "reNewPin";
        const FINAL_TEXT = "finalText";
        const START_DATE = "startDate";
        const END_DATE = "endDate";
        const SELECTED_AMOUNT = "selectedAmount";
        const SELECTED_RTGS_BANK = "selectedRtgsBank";
        const SAVED_TEXT_SENTENCES = "savedTextSentences";
        const SAVED_TEXT = "savedText";
        const BENEFICIARY_ACC_NUMBER = "beneficiaryAccNumber";
        const BENEFICIARY_ACC_ALIAS = "beneficiaryAccAlias";
        const RECIPIENTS_FULL_NAMES = "recipientsFullNames";
        const PURPOSE_TRANSACTION = "purposeTransaction";
        const PREVIOUS_PAGE = "previousPage";
        const MAXIMUM_TEXT_SIZE = "maximumTextSize";
        const SELECTED_LEAVE = "selectedLeave";
        const SELECTED_CHEQUE_NUMBER = "selectedChequeNumber";
        const BACK_OPTION_CHARACTER = "backOptionCharacter";
        const HOME_OPTION_CHARACTER = "homeOptionCharacter";
        const PREV_PAGE_CHARACTER = "prevPageCharacter";
        const NEXT_PAGE_CHARACTER = "nextPageCharacter";
        const CURRENT_INDEX = "currentIndex";
        const DEFAULT_LANGUAGE = "defaultLanguage";
        const EMAIL_ADDRESS = "emailAddress";
        //Set the xml config variables

        const SERVICES = "services";
        const ALL_LANGUAGES_LIST = "allLanguagesList";
        const PREFERRED_LANGUAGE_LIST = "preferredLanguageList";
        const FOREX_CURRENCIES = "forexCurrencies";
        const CLIENT_SYSTEM_ID = "clientSystemID";
        const IMCID = "imcid";
        const REQUEST_MODE_ASYNC = "requestModeAsync";
        const REQUEST_MODE_SYNC = "requestModeSync";
        const SYSTEM_NAME = "systemName";
        const IMC_REQUEST_ID = "ImcRequestID";
        const UNIQUE_ID = "uniqueID";
        const MINIMUM_PIN_LENGTH = "MinimumPinLength";
        const MAXIMUM_PIN_LENGTH = "maximumPinLength";
        const CHANNEL_REQUEST_STATUS_CODE = "channelRequestStatusCode";
        const ACCESS_POINT = "accessPoint";
        const NETWORK_ID = "networkID";
        const SELECTED_AIRTIME_SERVICE = "selectedAirtimeService";
        const SELECTED_MNO_SERVICE = "selectedMnoService";
        const SELECTED_AIRTIME_RECIPIENT = "selectedAirtimeRecipient";
        const SELECTED_MONEY_RECIPIENT = "selectedMoneyRecipient";
        const SELECTED_FT_RECIPIENT_NAME = "selectedFTRecipientName";
        const OTP_SERVICE_ID = "otpServiceId";
        const FUNDS_SERVICES = "fundsServices";
        const CHECKBOOK_SERVICES = "checkbookServices";
        const CURRENCY = "currency";
        const COUNTRY_NUMBER_PREFIX = "countryNumberPrefix";
        const MOBILE_NUMBER_REGEX = "numberRegex";
        const AFFILIATE_CODE = "affiliateCode";
        const AFFILIATE_COUNTRIES = "affiliateCountries";
        const BILLERS = "billers";
        const QUERY_SERVICES = "queryServices";
        const SELECTED_TRANSFER_REASON = "transferReason";
        const SELECTED_MODE_OF_DELIVERY = "modeOfDelivery";
        const SELECTED_COUNTRY = "destinationCountry";
        const WALLET_USERNAME = "walletUsername";
        const MERCHANT_NAME = "merchantName";
        //Wallet configurations

        const WALLET_PASSWORD = "walletPassword";
        const WALLET_URL = "walletURL";
        const WALLET_AUTHENTICATION_FUNCTION = "walletAuthenticationFunction";
        const WALLET_PROFILE_DETAILS_URL = "walletProfileDetailsURL";
        const WALLET_FETCH_CUSTOMER_DETAILS_FUNCTION = "walletFetchCustomerDetailsFunction";
        const WALLET_FETCH_CUSTOMER_NOMINATIONS_FUNCTION = "walletFetchCustomerNominationsFunction";
        const WALLET_PROCESS_SYNCHRONOUS_FUNCTION = "walletProcessRequestSynchronousFunction";
        const WALLET_PROCESS_ASYNCHRONOUS_FUNCTION = "walletProcessRequestAsynchronousFunction";
        const CLOUD_USERNAME = "cloudUsername";
        const CLOUD_PASSWORD = "cloudPassword";
        const WALLET_CBS_ID = "walletCBSId";
        const HUB_USERNAME = "hubUsername";
        //Hub configurations

        const HUB_PASSWORD = "hubPassword";
        const BEEP_API_URL = "beepApiUrl";
        const BEEP_SOAP_API_URL = "beepSoapApiUrl";
        const HUB_FETCH_INVOICES_FUNCTION = "hubFetchInvoicesFunction";
        const BILLS_COUNT = "billsCount";
        const ALLOW_BILL_QUERY = "allowBillQuery";
        const BILLER_CODE = "billCode";
        const BILLER_ID = "billID";
        const PRODUCT_CODE = "productCode";
        const BILLER_ACCOUNT_TYPE_NAME = "billerAccountTypeName";

        private $merchantList = array(
            'DStv', 'GOtv', 'ZUKU', 'KPLC Prepaid', 'Jambojet', /* 'Jambopay', */
            'KPLC Postpaid'
        );

        const MNO_REGEX = "mnoRegex";
        const MOMO_MNO_SERVICES = "mnoServices";
        //const MOMO_MNO_SERVICES = "mnoServices";
        const AIRTIME_MNO_SERVICES = "airtimeMNOServices";

        /*

         * This start page is the first initial start point for the menu

         * */

        function processStartPage($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->startPage(null, $warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));

                $this->startPage(null, $warning);

                return;
            }



            //Log

            $this->logMessage("About to load the Home page..");


            //Get the input and encrypted it

            $this->saveSessionVar(self::ENCRYPTED_PIN, $this->encryptPinWallet($input));

            $this->saveSessionVar(self::ENCRYPTED_AUTH_PIN, $this->encryptAuthPinWallet($input));



            //invoke the wallet authentication API passing the encrypted PIN and the Mobile Number

            $request = array(
                "MSISDN" => $this->_msisdn,
                "PINHASH" => $this->getSessionVar(self::ENCRYPTED_AUTH_PIN),
            );



            $payload = array(
                "pinRequest" => $request
            );



            //Get the wallet url

            $walletUrl = $this->getSessionVar(self::WALLET_URL);



            //switch between https and http

            $urlScheme = parse_url($walletUrl);



            if ($urlScheme['scheme'] == "https") {



                $this->logMessage("The wallet uses SSL,initializing SSL client");



                $host = $urlScheme['host'];

                $path = $urlScheme['path'];

                $port = $urlScheme['port'];



                $client = new xmlrpc_client($walletUrl, false);
            } else {



                $this->logMessage("The wallet uses standard http,initializing standard IXR client");

                //invoke standard http

                $client = new IXR_Client($walletUrl);
            }



            //Log

            $this->logMessage("Authenticating user with function: "
                . ((String) $this->getSessionVar(self::WALLET_AUTHENTICATION_FUNCTION))
                . " and the following configurations: ", $payload);



            //Query

            $resp = $client->query($this->getSessionVar(self::WALLET_AUTHENTICATION_FUNCTION), $payload);
            $resp = $client->getResponse();
            $res = json_decode($resp);

            $this->logMessage("Response from wallet:::" . print_r($res, true));

            if ($res->STAT_CODE != 1) {

                $warning = $res->STAT_DESCRIPTION;



                $this->startPage(null, $warning);

                return;
            }



            //Log, test

            $this->logMessage("Loading home page .. ");



            //Go to the HomePage

            $this->HomePage();
        }

        //function that process the input from the startPage

        /**

         * This function is used to load the text loaded from the language pack

         *

         * @param $field_to_display - used to specific the field in the language array to be used.

         * @param null $arrayFields

         * @return mixed|string - The text that will sent back

         * @internal param $arrayFields - used to specific the elements that will be used in the special fields used in the text. Eg  ^MAX_PIN_LENGTH^

         *

         * NB Should not pass an array in any of the array_field array elements

         */
        function loadText($field_to_display, $arrayFields = null) {

            //Define the error to be displayed

            $errorText = "An error occurred while trying to display data";



            //First thing first get the language pack form the config

            $languagesPackArray = $this->getSessionVar(self::PREFERRED_LANGUAGE_LIST);

            $languagesPackArray = $languagesPackArray["TRANSLATIONS"];



            //log what we got
    //        $this->flog("The field to display is: {$field_to_display}, The language being passed: " . print_r($languagesPackArray,true));
            //Create the variable to be save the text that will be return after setting  everything and assign the text choosen

            $text = $languagesPackArray[$field_to_display];
    //$this->flog($this->_msisdn."| language pack:".print_r($languagesPackArray,true));
            //              $this->flog($this->_msisdn."| english text:$text");
            //Replace any new line with actual new lines

            $text = str_replace('\n', "\n", $text);



    //		$this->flog("The text being passed: " . $text);
            //Check if the arrayField is empty

            if (is_null($arrayFields) && !empty($text)) {

                //Return the text

                return $text;
            }

            //Regex pattern that will be used to check

            $regexPattern = "/(\^[A-Z_]+\^)/";

            //Match
            $nos_of_matches = preg_match_all($regexPattern, $text, $matches, PREG_PATTERN_ORDER);


    //		$this->flog("The number of matches received is: " . $nos_of_matches);
            //Assign the matches found

            $matches_found = array();



            //Parse through all the elements and append / $value / to allow for proper replacement

            foreach ($matches[0] as $single_match) {

                //Trim the character at the beginning and the end

                $single_match = trim($single_match, "^");

                //Append the signs

                $matches_found[] = "/\\^" . $single_match . "\\^/";
            }



    //		$this->flog(" and the matched elements are: \n " . print_r($matches_found, true) . "\n");
    //		$this->flog(" and the values are: \n " . print_r($arrayFields, true) . "\n");



            $result = null;

            //Get the number of matches found, then replace

            for ($i = 1; $i <= $nos_of_matches; $i++) {

                //Check for special character ^ that indicates text needs to be replaced

                $result = preg_replace($matches_found, $arrayFields, $text);
            }


    //        $this->flog("The \$result is: {$result} ");
            //Handle if an error occurred

            if (empty($result)) {

                //Log error
    //			$this->logMessage(2, "| Empty or invalid text is being returned to the user for LanguagesPack['" . $field_to_display . "]", null);
    //            $this->flog("| Empty or invalid text is being returned to the user for LanguagesPack['" . $field_to_display . "']");



                return $errorText;
            }



            //Log , success
    //        $this->logMessage("| Load text successfully and the data is: ",$result);
    //        $this->flog("| Load text successfully and the data is: " . $result);
            //Return the array

            return $result;
        }

        /*

         * Function that process one tap pin

         * */

        function flog($string) {

            $file = "/var/log/applications/ug/hub4/hubChannels/ussd/EcobankLogs.log";



            //Replace the newlines

            $date = date("Y-m-d G:i:s");

            if ($fo = fopen($file, 'ab')) {

                fwrite($fo, "$date | $string\n");

                fclose($fo);
            }
        }

        /*

         * Function to display setting up the pin for one tap pin

         * */

        function logMessage($message, $result = null, $logLevel = self::LOG_LEVEL_INFO) {
            if ($result == null)
                $result = "";

            if ($result != null) {

                CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message . print_r($result, true)), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
            } else {

                CoreUtils::flog4php($logLevel, $this->_msisdn, array("MESSAGE" => $message), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
            }



            //Log the data in the custom log

            $this->flog($message . print_r($result, true));
        }

        //function to process the input from EnterNewPin



        function startPage($input, $warning = null) {

            //Log
            //
            $this->displayText = "Testing Start of Application";
            $this->sessionState = "END";


            

    /*
            $this->logMessage("In the startPage ... About to load configs");



            //Load configs

            $this->loadConfigs();



            //Check if the option to disable menu is enabled

            if ($this->getSessionVar(self::DISABLE_MENU)) {

                //Log

                $this->logMessage("The menu has been disabled!!!!");



                //Load text
                //Actual text: Dear customer, this service is currently unavailable. Please try again later

                $text = $this->loadText("DisableMenu");



                //Display text

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;  
            }



            //Log

            $this->logMessage("Getting the list of customer details");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log, test

            $this->logMessage("The response from getting customer details are: ", $response);



            //Check if we got the customer details successfully

            if (empty($response[self::SUCCESS])) {

                //Check if the message is if the account is not present

                if (!empty($response[self::MESSAGE]) &&
                        $response[self::MESSAGE] == "Error occured while fetching the profile"
                ) {

                    //Log error

                    $this->logMessage("Got an error while loading customer details, the exception is: "
                            , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                    //Load the error text
                    //Actual text: You are not registered with Ecobank. Please visit our branches to register.

                    $text = $this->loadText("WelcomeNonUser") . "\n";



                    //Display the error

                    $this->presentData($text, null, null, self::SESSION_STATE_END);

                    return;
                }



                //Log error

                $this->logMessage("Got an error while loading customer details, the exception is: "
                        , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load the error text
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage") . "\n";



                //Display the error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Get the customer data

            $customerNames = (String) $response[self::DATA][self::CUSTOMER_NAMES];



            //Save customer names

            $this->saveSessionVar(self::CUSTOMER_NAMES, $customerNames);



            //Get the profile pin status

            $profilePinStatus = $response[self::DATA][self::PROFILE_PIN_STATUS];



            //Get the profile active status

            $profileActiveStatus = $response[self::DATA][self::PROFILE_ACTIVE_STATUS];



            //Get the client profile ID

            $clientProfileID = $response[self::DATA][self::CLIENT_PROFILE_ID];



            //Get the data and format it

            $customerAccounts = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);

            $storedAccountNumbers = $customerAccounts;

            $this->saveSessionVar('storedAccountNumbers', $storedAccountNumbers);



            //Check if any warning was set

            if (empty($warning)) {

                //Check if the client Profile ID is 0

                if ($clientProfileID != null || $clientProfileID != 0) {

                    //Log

                    $this->logMessage("The client profile ID is not null... ");



                    // TODO --hack

                    if ($profilePinStatus == 1 and $profileActiveStatus == 1) {

    //                if (true) {
                        //Check if user dialed with amount, panama oneTap

                        $getDial = explode('*', $input);



                        //Log

                        $this->logMessage("The exploded input is: ", $getDial);



                        if ($getDial[2] == 9 && !empty($getDial[3])) {

                            $this->logMessage('-----count-------' . count($storedAccountNumbers));

                            $amount = rtrim($getDial[3], "#");

                            $this->PanamaHome($amount);

                            return;
                        } else {

                            //Load the text to be used
                            //Actual text: Welcome ^CUSTOMER_DETAILS^ to Ecobank MBanking.

                            $text = $this->loadText("Welcome", array($customerNames)) . " ";



                            //Actual text: Please enter your mobile banking pin:

                            $text .= $this->loadText("EnterPin") . "\n";
                        }
                    } elseif ($profilePinStatus == 2) {

                        //Load the text to be used
                        //Actual text: Welcome ^CUSTOMER_DETAILS^ to Ecobank MBanking.

                        $text = $this->loadText("Welcome", array($customerNames)) . " ";



                        //Actual text: Please enter your One Time Pin:

                        $text .= $this->loadText("OneTimePin") . "\n";



                        //The start page of the menu;

                        // $this->presentData($text,"startPage","processOneTimePin");  return; 
                    } elseif ($profileActiveStatus != 1) {

                        //Customer is not active
                        //Actual Text: Dear ^CUSTOMER_NAME^, Please call customer care to activate your Mobile Banking Service.

                        $text = $this->loadText("CallCareActivate", array($customerNames));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } elseif ($profilePinStatus == 3) {

                        //customer PIN is expired
                        //Actual Text: Dear ^CUSTOMER_NAME^, your PIN has been locked. Please contact customer care for further assistance.^BANK^

                        $text = $this->loadText("PinLocked", array($customerNames, self::ECOBANK_NAME));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } elseif ($profilePinStatus == 4) {

                        //customer is not active
                        //Actual Text: Dear ^CUSTOMER_NAME^, your One Time PIN has been locked. Please contact customer care for further assistance. ^BANK^

                        $text = $this->loadText("OneTimePinLocked", array($customerNames, self::ECOBANK_NAME));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } elseif ($profilePinStatus == 5) {

                        //customer is not active
                        //Actual Text:Dear ^CUSTOMER_NAME^, your PIN has expired. Please contact customer care for further assistance. ^BANK^

                        $text = $this->loadText("PinExpired", array($customerNames, self::ECOBANK_NAME));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } elseif ($profilePinStatus == 6) {

                        //customer is not active
                        //Actual Text:Dear ^CUSTOMER_NAME^, your One Time PIN has expired. Please contact customer care for further assistance. ^BANK^

                        $text = $this->loadText("OneTimePinExpired", array($customerNames, self::ECOBANK_NAME));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } elseif ($profilePinStatus == 8) {

                        //customer is not active
                        //Actual Text:Dear ^CUSTOMER_NAME^, your PIN has been temporarily locked. Please try again after some time. ^BANK^

                        $text = $this->loadText("PinTempLocked", array($customerNames, self::ECOBANK_NAME));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    } else {

                        //OTP status not known to this menu
                        //Actual Text: Dear ^CUSTOMER_NAME^, Please call customer care to activate your Mobile Banking Service.

                        $text = $this->loadText("CallCareActivate", array($customerNames));



                        //Display Text

                        $this->presentData($text, null, null, self::SESSION_STATE_END);

                        return;
                    }
                } //The profileStatus is zero or null
                else {

                    //Not registered for mobile banking
                    //Actual Text: Dear Customer, Please visit your nearest ^BANK^ branch to register for mobile banking

                    $text = $this->loadText("BankRegister", array());



                    //Display text

                    $this->presentData($text, null, null, self::SESSION_STATE_END);

                    return;
                }
            } else {

                //Load the text

                $text = $warning . "\n";
            }



            //Check its one tap

            if ($profilePinStatus == 2) {

                //The start page of the menu;

                $this->presentData($text, "startPage", "processOneTimePin");

                return;
            }



            //The start page of the menu;

            $this->presentData($text, "startPage", "processStartPage");
            */
        }

        /*

         * Function to display setting up the pin for one tap pin

         * */

        function loadConfigs() {

            //Log

            $this->logMessage("Loading config file " . self::CONFIG_FILE);

            //Check if the config file is valid

            if (!file_exists(self::CONFIG_FILE)) {

                //Log error

                $this->logMessage("The config file:" . self::CONFIG_FILE . " does not exists. Existing!!!"
                    , null, self::LOG_LEVEL_ERROR);



                //Exit

                exit();
            }



            //Load the xml file

            $xml = simplexml_load_file(self::CONFIG_FILE);



            //Load the data

            $xmlArray = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));



            //Log, test
    //        $this->logMessage("The config array is ",$xmlArray);
            //Get the list of services

            $services = $xmlArray["SERVICES"];



            //$this->logMessage("The list of services::".print_r($services));
            //Save the list of services

            $this->saveSessionVar(self::SERVICES, $services);



            //Load the default language

            $defaultLanguage = $xmlArray["DefaultLanguage"];

            $this->saveSessionVar(self::DEFAULT_LANGUAGE, $defaultLanguage);



            //Load the languages pack

            $languagePacks = $xmlArray["LANGUAGES"];

            $this->saveSessionVar(self::ALL_LANGUAGES_LIST, $languagePacks);



            //Load the preferred language pack

            $this->saveSessionVar(self::PREFERRED_LANGUAGE_LIST, $languagePacks[$defaultLanguage]);



            //Log, test
    //        $this->logMessage("The config array is ",$xmlArray["DefaultLanguage"]);
            //Load the wallet's username

            $this->saveSessionVar(self::WALLET_USERNAME, $xmlArray["WalletUsername"]);

            //Load the wallet's url

            $this->saveSessionVar(self::WALLET_URL, $xmlArray["WalletURL"]);

            //Load the fetch profile wallet url

            $this->saveSessionVar(self::WALLET_PROFILE_DETAILS_URL, $xmlArray["WalletProfileDetailsURL"]);

            //Load the wallet's password

            $this->saveSessionVar(self::WALLET_PASSWORD, $xmlArray["WalletPassword"]);

            //Load the wallet's fetch customer functions

            $this->saveSessionVar(self::WALLET_FETCH_CUSTOMER_DETAILS_FUNCTION, $xmlArray["WalletFetchCustomerDetailsFunction"]);

            //Load the authentication function

            $this->saveSessionVar(self::WALLET_AUTHENTICATION_FUNCTION, $xmlArray["WalletAuthenticationFunction"]);

            //Load the wallet synchronous process request function

            $this->saveSessionVar(self::WALLET_PROCESS_SYNCHRONOUS_FUNCTION, $xmlArray["WalletProcessRequestSynchronousFunction"]);

            //Load the wallet asynchronous process request function

            $this->saveSessionVar(self::WALLET_PROCESS_ASYNCHRONOUS_FUNCTION, $xmlArray["WalletProcessRequestAsynchronousFunction"]);

            //Load the fetch nomination function

            $this->saveSessionVar(self::WALLET_FETCH_CUSTOMER_NOMINATIONS_FUNCTION, $xmlArray["WalletFetchCustomerNominationsFunction"]);

            //Load wallet CBS ID

            $this->saveSessionVar(self::WALLET_CBS_ID, $xmlArray["WalletCBSID"]);



            //Load the client System ID

            $this->saveSessionVar(self::CLIENT_SYSTEM_ID, $xmlArray["ClientSystemID"]);

            //Load the IMCID

            $this->saveSessionVar(self::IMCID, $xmlArray["IMCID"]);

            //Load the Request Mode Synchronously

            $this->saveSessionVar(self::REQUEST_MODE_SYNC, $xmlArray["RequestModeSync"]);

            //Load the Request Mode Asynchronously

            $this->saveSessionVar(self::REQUEST_MODE_ASYNC, $xmlArray["RequestModeAsync"]);

            //Load the system name

            $this->saveSessionVar(self::SYSTEM_NAME, $xmlArray["SystemName"]);

            //Load the IMCRequestID

            $this->saveSessionVar(self::IMC_REQUEST_ID, $xmlArray["IMCRequestID"]);



            //Load disable menu option

            $this->saveSessionVar(self::DISABLE_MENU, $xmlArray["DisableMenu"]);



            //Load the unique id

            $this->saveSessionVar(self::UNIQUE_ID, $xmlArray["UniqueID"]);



            //Load the minimum and maximum pin lengths

            $this->saveSessionVar(self::MINIMUM_PIN_LENGTH, $xmlArray["MinimumPinLength"]);

            $this->saveSessionVar(self::MAXIMUM_PIN_LENGTH, $xmlArray["MaximumPinLength"]);



            //Load the channel request status code

            $this->saveSessionVar(self::CHANNEL_REQUEST_STATUS_CODE, $xmlArray["ChannelRequestStatusCode"]);



            //Load the accessPoint

            $this->saveSessionVar(self::ACCESS_POINT, $xmlArray["AccessPoint"]);



            //Load the network ID

            $this->saveSessionVar(self::NETWORK_ID, $xmlArray["NetworkID"]);

            //Load the cloud username and password

            $this->saveSessionVar(self::CLOUD_USERNAME, $xmlArray["CloudUsername"]);

            $this->saveSessionVar(self::CLOUD_PASSWORD, $xmlArray["CloudPassword"]);



            //Load the hub details

            $this->saveSessionVar(self::BEEP_API_URL, $xmlArray["BeepPaymentGatewayURL"]);

            $this->saveSessionVar(self::BEEP_SOAP_API_URL, $xmlArray["BeepSoapAPIURL"]);

            $this->saveSessionVar(self::HUB_PASSWORD, $xmlArray["HubPassword"]);

            $this->saveSessionVar(self::HUB_USERNAME, $xmlArray["HubUsername"]);

            $this->saveSessionVar(self::HUB_FETCH_INVOICES_FUNCTION, $xmlArray["FetchInvoices"]);



            //Load the list of airtime services

            $this->saveSessionVar(self::MOMO_MNO_SERVICES, $xmlArray["MOBILEMONEYMNOS"]);
            $this->saveSessionVar(self::AIRTIME_MNO_SERVICES, $xmlArray["AIRTIMEMNOS"]);


            //Load the one time pin OTP pin service ID

            $this->saveSessionVar(self::OTP_SERVICE_ID, $xmlArray["OTPServiceID"]);



            //Get the list of Funds Transfer Services

            $this->saveSessionVar(self::FUNDS_SERVICES, $xmlArray["FUNDSSERVICES"]);



            //Save the maximum text size for MNO handling

            $this->saveSessionVar(self::MAXIMUM_TEXT_SIZE, $xmlArray["MaximumTextSize"]);



            //Load the check book services

            $this->saveSessionVar(self::CHECKBOOK_SERVICES, $xmlArray["CHECKBOOKSERVICES"]);



            //Save the back, next, home and previous option characters

            $this->saveSessionVar(self::HOME_OPTION_CHARACTER, $xmlArray["HomeOptionCharacter"]);

            $this->saveSessionVar(self::BACK_OPTION_CHARACTER, $xmlArray["BackOptionCharacter"]);

            $this->saveSessionVar(self::PREV_PAGE_CHARACTER, $xmlArray["PrevPageCharacter"]);

            $this->saveSessionVar(self::NEXT_PAGE_CHARACTER, $xmlArray["NextPageCharacter"]);



            //Load the currency

            $this->saveSessionVar(self::CURRENCY, $xmlArray["Currency"]);



            //Save the country prefix

            $this->saveSessionVar(self::COUNTRY_NUMBER_PREFIX, $xmlArray["CountryNumberPrefix"]);



            //Save the affiliate countries

            $this->saveSessionVar(self::AFFILIATE_COUNTRIES, $xmlArray["AFFILIATECOUNTRIES"]);



            //Save the list of billers

            $this->saveSessionVar(self::BILLERS, $xmlArray["BILLERS"]);



            //Save the query services

            $this->saveSessionVar(self::QUERY_SERVICES, $xmlArray["QUERYSERVICES"]);



            //Save the affiliate code

            $this->saveSessionVar(self::AFFILIATE_CODE, $xmlArray["AffiliateCode"]);

            //Load mobile number Regex

            $this->saveSessionVar(self::MOBILE_NUMBER_REGEX, $xmlArray["numberRegex"]);
        }

        //function to process the input from RenterNewPin



        function presentData($text, $previousPage, $nextPage = null, $state = self::SESSION_STATE_CONTINUE) {

            //Sets the display text

            $this->displayText = $text;

            if ($previousPage != null) {

                //Sets the previous page

                $this->previousPage = $previousPage;
            }

            if ($nextPage != null) {

                //Set the next page

                $this->nextFunction = $nextPage;
            }

            //Sets the state

            $this->sessionState = $state;
        }

        /*

         * ******************** HomePage ***************************************************

         * */

        function getCustomerData() {

            //Get the complete customer data

            $completeCustomerData = $this->getSessionVar(self::CUSTOMER_COMPLETE_DATA);



            //Check if data was already saved

            if (!empty($completeCustomerData)) {

                //Return the data

                return $completeCustomerData;
            }



            //Set the sample template the will be returned

            $response = array(
                self::SUCCESS => false,
                self::DATA => false,
                self::ERROR => false
            );



            //Fetch data from wallet

            $customerData = $this->fetchCustomerDataWallet();

            //Log
            $this->logMessage("The customer data received from wallet is: ", $customerData);


            //Check if the data is null
            if (empty($customerData) || empty($customerData["SUCCESS"])) {

                //Set the error
                $response[self::ERROR] = $customerData["ERRORS"];

                $response[self::MESSAGE] = $customerData["MESSAGE"];


                //Return the response as failed
                return $response;
            }

            //Get the customer details
            $customerDetails = explode("|", $customerData["customerDetails"]);


            //Get the profile ID
            $clientProfileID = $customerDetails[0];

            //Get the profile active status

            $profileActiveStatus = $customerDetails[1];

            //Get the profile pin status

            $profilePinStatus = $customerDetails[2];

            //Get the customer's name

            $customerNames = $customerDetails[4] . ", " . $customerDetails[3];

            //Get the account details
            $accountsDetails = $customerData["accountDetails"];

            //Get the accounts
            $accountsDetails = explode("#", $accountsDetails);

            //Log, Test
            $this->logMessage("The account details are ", $accountsDetails);

            //Holds the accounts
            $accounts = null;

            //Hold Account Aliases
            $storedAliases = array();


            //Get the array data
            foreach ($accountsDetails as $key => $value) {

                //Explode the array to get the individual properties

                $accountDetails = explode("|", $accountsDetails[$key]);

                //Get the CBS ID details
                $accounts[] = array(
                    //Set the CBS ID

                    self::CBS_ACCOUNT_ID => $accountDetails[0],
                    //Set the account number
                    self::ACCOUNT_NUMBER => $accountDetails[1],
                    //Set the account alias
                    self::ACCOUNT_ALIAS => $accountDetails[2]
                );

                $storedAliases[] = $accountDetails[2];
            }

            $this->saveSessionVar('storedAliases', $storedAliases);

            //Set the nomination
            $customerNominations = null;

            //Set the nomination
            if (!empty($customerData["nominationDetails"])) {

                //Get the array data

                foreach ($customerData["nominationDetails"] as $key => $value) {

                    //Explode the array to get the individual properties
                    $customerNomination = explode("|", $value);


                    //Check if the type if IFT

                    if ($customerNomination[6] == "IFT") {

                        $customerNominations[] = array(
                            //Add the name

                            self::WALLET_NOMINATION_NAME => $customerNomination[0],
                            //Add the account number
                            self::WALLET_NOMINATION_ACC_NOS => $customerNomination[1]
                        );
                    }
                }



                //Format the accounts to the expected format

                $customerNominations = $this->formatRecords($customerNominations);
            }

            //Format the accounts to the expected format
            $accounts = $this->formatRecords($accounts);


            //Log
            $this->logMessage("The customer details are: ", $customerDetails);

            //Log the account details

            $this->logMessage("The account details are: ", $accounts);

            //Set the final array data
            $data = array(
                self::CLIENT_PROFILE_ID => $clientProfileID,
                self::PROFILE_ACTIVE_STATUS => $profileActiveStatus,
                self::PROFILE_PIN_STATUS => $profilePinStatus,
                self::CUSTOMER_NAMES => $customerNames,
                self::CUSTOMER_ACCOUNTS => $accounts,
                self::CUSTOMER_IFT_NOMINATIONS => $customerNominations
            );

            //Set the response
            $response = array(
                self::SUCCESS => true,
                self::DATA => $data
            );


            //Set the data to the session variable to avoid calling this function multiple times
            $this->saveSessionVar(self::CUSTOMER_COMPLETE_DATA, $response);


            //return the respose

            return $response;
        }

        //function that process the input from the startPage



        function fetchCustomerDataWallet() {

            //Log

            $this->logMessage("Getting customer data from wallet");



            //Get the wallet url

            $walletUrl = $this->getSessionVar(self::WALLET_URL);

            //switch between https and http

            $urlScheme = parse_url($walletUrl);

            if ($urlScheme['scheme'] == "https") {



                $this->logMessage("The wallet uses SSL,initializing SSL client");



                $host = $urlScheme['host'];

                $path = $urlScheme['path'];

                $port = $urlScheme['port'];





                $client = new xmlrpc_client($walletUrl, false);
            } else {



                $this->logMessage("The wallet uses standard http,initializing standard IXR client");

                //invoke standard http

                $client = new IXR_Client($walletUrl);
            }





            //Define the payload to be sent

            $payload = array(
                "MSISDN" => $this->_msisdn,
                "USERNAME" => $this->getSessionVar(self::WALLET_USERNAME),
                "PASSWORD" => $this->getSessionVar(self::WALLET_PASSWORD)
            );



            //Log

            $this->logMessage("Fetching data from wallet with function: "
                . ((String) $this->getSessionVar(self::WALLET_FETCH_CUSTOMER_DETAILS_FUNCTION))
                . " and the following configurations: ", $payload);



            //Query

            $resp = $client->query($this->getSessionVar(self::WALLET_FETCH_CUSTOMER_DETAILS_FUNCTION), $payload);
            $resp = $client->getResponse();
            $this->logMessage("Response from wallet:::" . print_r($resp, true));



            //Return the response

            return $resp;
        }

        /*

         * ******************** Service 1: Airtime Topup *************************************

         * */

        function formatRecords($array) {

            //Format the array and return it

            return array_combine(range(1, count($array)), array_values($array));
        }

        //function to process airtime menu



        function PanamaHome($amount = null) {

            //Save amount

            $this->saveSessionVar('panamaAmount', $amount);



            if ($amount > 1000) {
                
            } else {

                //checkAccounts

                $CountgetAcc = count($this->getSessionVar('storedAccountNumbers'));

                $this->logMessage("The client has one account: ", $CountgetAcc);



                if ($CountgetAcc == 1) {

                    $this->logMessage("The client has a Single account: ", $accounts);

                    $this->panamaRequest("101");
                } else {

                    // $this->toFile('i a');

                    $this->panamaAccount();
                }
            }
        }

        /*

         * Function to select the top up options

         * */

        function panamaRequest($input = null) {

            $availableAliases = $this->getSessionVar('availableAliases');

            $customerAliases = $this->getSessionVar('storedAliases');

            $customerAccounts = $this->getSessionVar('storedAccountNumbers');

            $accountIDs = $this->getSessionVar('storedAccountID');



            $amount = $this->getSessionVar('panamaAmount');

            //Log

            $this->logMessage("Processing Panama airtime request..." . $input);



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::SERVICES);

            //$serviceID = $serviceID["AIRTIME"]["ServiceID"];

            $serviceID = "BILL_PAY";

            $resp = $this->getSessionVar(self::CUSTOMER_COMPLETE_DATA);



            if ($input == "101") {

                //$alias= $customerAliases[0];
                //Get the account alias
                //$accountAlias = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);

                $accountAlias = $resp[self::DATA][self::CUSTOMER_ACCOUNTS];

                $accountAlias = $accountAlias[1][self::ACCOUNT_ALIAS];





                // $accountID=$accountIDs[0];
                //Get the account ID
                //$accountID = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);

                $accountID = $resp[self::DATA][self::CUSTOMER_ACCOUNTS];

                $accountID = $accountID[1][self::CBS_ACCOUNT_ID];



                //$acc  = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);

                $acc = $resp[self::DATA][self::CUSTOMER_ACCOUNTS];



    //    $profileID = $resp[self::DATA][self::CLIENT_PROFILE_ID];
            } else {

                $alias = $customerAliases[$input - 1];

                $accountID = $accountIDs[$input - 1];

                $acc = $customerAccounts[$input - 1];
            }





            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->encryptPin("xxxx", 1),
                //"pin"          => "xxxx",
                "accountAlias" => $accountAlias,
                "amount" => $amount,
                "merchantCode" => "MTNPinless",
                "accountID" => $accountID,
                "enroll" => "NO",
                "CBSID" => 1,
                "columnD" => "topup",
                "columnA" => $this->_msisdn,
                "columnC" => 200,
                    //        "merchantID"   => 34,
                    //        "profileID"    => $profileID,
            );



            // log request into channelRequests
            //$statusCode = 2;
            //$successLog = $this->logChannelRequest($payload, $statusCode);
            //Call wallet and get the response

            $successLog = $this->asynchronousProcessing($payload);



            if ($successLog[self::SUCCESS] == TRUE) {

                // $this->logMessage("Processing channel request...".print_r($successLog));
                // send payload to system and get response

                $text = 'Your request has been received and is being processed.';

                $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));

                //Display message

                $this->FinalPage($text);

                //$this->displayText = "Your request has been received and is being processed.";
                //$this->displayText = "Your request has been received. $this->confirmatory";
            } else {

                $text = "Sorry, an error occured when processing your request.";

                //Display message

                $this->FinalPage($text);

                //$this->displayText  = "Sorry, an error occured when processing your request.";
                //$this->sessionState = "END";
            }
        }

        //Function to process input from SelectSelfOtherMobile



        function asynchronousProcessing($requestPayload, $isBill = false) {

            //Log

            $this->logMessage("Logging the request to channelRequests Logs");



            //Log the payload to channel request logs

            $response = $this->logChannelRequest($requestPayload
                , $this->getSessionVar(self::CHANNEL_REQUEST_STATUS_CODE));



            //Check if it was successful

            if (empty($response[self::CHANNEL_REQUEST_SUCCESS])) {

                //Log error

                $this->logMessage("Unable to log request to channel requests"
                    , $response[self::CHANNEL_REQUEST_MESSAGE], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual tetx: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return null;
            }



            //Get the channel request ID

            $channelRequestID = $response[self::CHANNEL_REQUEST_DATA][self::CHANNEL_REQUEST_LAST_INSERT_ID];



            //Log

            $this->logMessage("Calling wallet asynchronously ...");



            //Generate the wallet payload

            if (!$isBill) {

                $requestXML = "<Payload>";

                foreach ($requestPayload as $key => $value) {

                    $requestXML .= '<' . $key . '>' . $value . '</' . $key . '>';
                }

                $requestXML .= "</Payload>";
            } else {

                $requestXML = json_encode($requestPayload);
            }



            //Log

            $this->logMessage("The payload to be sent to wallet is: ", $requestXML);



            $payload = $requestXML;



            $credentials = array(
                'cloudUser' => $this->getSessionVar(self::CLOUD_USERNAME),
                'cloudPass' => $this->getSessionVar(self::CLOUD_PASSWORD),
            );



            $cloudPacket = array(
                "MSISDN" => $this->_msisdn,
                "destination" => $this->getSessionVar(self::ACCESS_POINT),
                "IMCID" => $this->getSessionVar(self::IMCID),
                "channelRequestID" => $channelRequestID,
                "networkID" => $this->getSessionVar(self::NETWORK_ID),
                "clientSystemID" => $this->getSessionVar(self::CLIENT_SYSTEM_ID),
                "systemName" => $this->getSessionVar(self::SYSTEM_NAME),
                "cloudDateReceived" => date("Y-m-d G:i:s"),
                "payload" => base64_encode($payload),
                "imcRequestID" => $this->getSessionVar(self::IMC_REQUEST_ID),
                "requestMode" => $this->getSessionVar(self::REQUEST_MODE_ASYNC),
            );



            $params = array(
                'credentials' => $credentials,
                'cloudPacket' => $cloudPacket,
            );





            //Default template of a response

            $response = array(
                self::SUCCESS => false,
                self::DATA => false,
                self::ERROR => false
            );



            //Call wallet and pass the payload

            try {

                //Log

                $this->logMessage("Calling wallet asynchronously with the payload: ", $params);

                //Get the wallet url

                $walletUrl = $this->getSessionVar(self::WALLET_URL);

                //switch between https and http

                $urlScheme = parse_url($walletUrl);

                if ($urlScheme['scheme'] == "https") {



                    $this->logMessage("The wallet uses SSL,initializing SSL client");



                    $host = $urlScheme['host'];

                    $path = $urlScheme['path'];

                    $port = $urlScheme['port'];



                    $client = new xmlrpc_client($walletUrl, false);
                } else {



                    $this->logMessage("The wallet uses standard http,initializing standard IXR client");

                    //invoke standard http

                    $client = new IXR_Client($walletUrl);
                }



                $result = $client->query($this->getSessionVar(self::WALLET_PROCESS_ASYNCHRONOUS_FUNCTION), $params);
                $result = $client->getResponse();
                $this->logMessage("Response from wallet:::" . print_r($result, true));



                //Get the data

                $data = json_decode($result, true);



                //Log

                $this->logMessage("Successfully got a response from wallet by calling it asynchronously...");



                //Set the response

                $response = array(
                    self::SUCCESS => true,
                    self::DATA => $data,
                    self::ERROR => false
                );
            } catch (Exception $exception) {

                //Get the error

                $error = $exception->getMessage();



                //Log

                $this->logMessage("An error occurred while calling wallet asynchronously ....", $error, self::LOG_LEVEL_ERROR);



                //Set the response

                $response[self::ERROR] = $error;
            }



            //Return the response

            return $response;
        }

        /*

         * Function to select the mobile provider for the recepient mobile number

         * */


        /*
          function FinalPage($text, $warning = null, $previousPage = null)

          {

          //Check if the message in null

          if (empty($text)) {

          //Log error

          $this->logMessage("Final page.. Got empty text....", null, self::LOG_LEVEL_ERROR);



          //Actual Text: Unable to process your request at this time. Please try again later

          $text = $this->loadText("ErrorMessage");



          //Display message

          $this->presentData($text, null, null, self::SESSION_STATE_END);

          return;

          }



          if (empty($warning)) {

          //Save the text

          $this->saveSessionVar(self::FINAL_TEXT, $text);

          }



          //Check if the previous page is empty

          if (empty($previousPage)) {

          $this->logMessage("Final page.. Got final display text....", $text);

          //Display message

          $this->presentData($text, null, null, self::SESSION_STATE_END);

          return;

          }



          //Save the previous page

          $this->saveSessionVar(self::PREVIOUS_PAGE, $previousPage);



          //Add the back button functionality

          //Actual Text: ^BACK^. Go Back

          $text .= $this->loadText("Back", array($this->getSessionVar(self::BACK_OPTION_CHARACTER)));



          //Display message

          $this->presentData($text, $previousPage, "processFinalPage");



          }

         */

          function FinalPage($text = null, $delimiter = ".") {
            //Check if the message in null
            if (empty($text))
                $text = $this->getSessionVar(self::FINAL_TEXT);
            else
                $this->saveSessionVar(self::FINAL_TEXT, $text);

            //Add go home text
            //Actual Text: \n ^HOME_OPTION_CHARACTER^. To Go Home
            $text .= $this->loadText("GoHome", array($this->getSessionVar(self::HOME_OPTION_CHARACTER)));

            //Handle large text
            $text = $this->largeTextFormatting($text, $delimiter);

            //Display message
            $this->presentData($text, null, "processFinalPage");
        }

        //function to process input from SelectRecipientMNO



        function panamaAccount() {

            $allAccountDetails = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);



            $accounts = "";

            $accountAlias = "";

            $accountCBSid = "";

            $countAccounts = 0;



            $accountDetails = explode("#", $allAccountDetails);

            $storedAliases = array();

            //        $storedAccountNumbers = array();
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

        /*

         * Function to allow user to enter the recepients phone number

         * */

        function isValidNumber($number) {

            //Check if its a number

            if (!is_numeric($number)) {

                //Return false

                return false;
            }



            //Check if the number is positive

            if ($number >= 0) {

                //Return true

                return true;
            }



            //return false

            return false;
        }

        /*

         * Function to verify if the email address passed is valid

         * */

        function isValidEmail($emailAddress) {

            return filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
        }

        //function to process the input from EnterRecipientMobileNumber



        function encryptPinWallet($input) {

            //Get the uniqueID that will be used to encrypt the pin

            $uniqueID = (int) $this->getSessionVar(self::UNIQUE_ID);



            //Return the encrypted pin

            return $this->encryptPin($input, $uniqueID);
        }

        /*

         * Function to select the airtime amount

         * */

        function encryptAuthPinWallet($input) {

            $encryptedPIN = $this->encryptPin($input);

            //Log
            $this->logMessage("The encrypted PIN is: " . $encryptedPIN);

            //Return the encrypted pin
            return $encryptedPIN;
        }

        //function to process the input from SelectAirtimeMenu



        function HomePage($warning = null) {

            $this->logMessage("In the homepage ... about to load the main services");

            $this->logMessage("Getting the list of all services");

            //Get the services of all active services
            $services = $this->loadServices();

            $this->logMessage("The list of services are: ", $services);

            //Check if any warning was set
            if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Home Menu

                $text = $this->loadText("HomeMenu") . "\n";
            } else {

                $text = $warning . "\n";
            }



            //Get the names

            foreach ($services as $key => $value) {

                $text .= $key . ". "
                . $value["FullName"]["TRANSLATIONS"][$this->getSessionVar(self::DEFAULT_LANGUAGE)]
                . "\n ";
            }



            //Format the data

            $text = $this->largeTextFormatting($text);

            //The start page of the menu;
            $this->presentData($text, null, "processHomePage");
        }

        /*

         * Function to custom insert the amount

         * */

        function loadServices() {

            //Get the services of all active services

            return $this->removeInActiveFormatRecords((array) $this->getSessionVar(self::SERVICES));
        }

        //function to load input from EnterCustomAmount menu



        function removeInActiveFormatRecords($array) {

            //Iterate through the array

            foreach ($array as $key => $data) {

                //remove the array from the list if its inactive

                if ($data['Active'] == 0) {

                    $this->logMessage(4, "The array [$key] is inactive. " . print_r($data, true) . " We will remove it");

                    unset($array[$key]);
                }
            }



            //return the array and arrange it appropriately

            return array_combine(range(1, count($array)), array_values($array));
        }

        /*

         * Function to validate details entered by the user

         * */

        function largeTextFormatting($text, $sentenceIndicator = PHP_EOL) {

            //Set the variable to default max size

            $maxTextLimitSize = (int) $this->getSessionVar(self::MAXIMUM_TEXT_SIZE);

            //Check if the text needs formatting

            if (strlen($text) <= $maxTextLimitSize) {

                //return the text

                return $text;
            }



            //Account for prev and next page text
            //Get the length of previous and next page text

            $prevNextLength = strlen($this->loadText("PrevNext"));



            //Get the length of the prev and next page text

            $maxTextLimitSize = $maxTextLimitSize - $prevNextLength;



            //Save the text

            $savedText = $this->getSessionVar(self::SAVED_TEXT);



            //Check if the text was saved

            if ($savedText != $text) {

                //Save the text

                $this->saveSessionVar(self::SAVED_TEXT, $text);



                //Break the text into sentences arrays

                $sentenceArrays = (array) explode($sentenceIndicator, $text);



                //Log

                $this->logMessage("The unformatted text is: ", $text);



                //Get the last element key

                $lastKey = count($sentenceArrays) - 1;



                //Log, test

                $this->logMessage("The last key is:", $lastKey);



                //Log

                $this->logMessage("The sentence array is:", $sentenceArrays);



                //Trim the last element

                $sentenceArrays[$lastKey] = trim($sentenceArrays[$lastKey]);



                //Check if the last part of the string is the sentenceIndicator

                if ($sentenceArrays[$lastKey] == $sentenceIndicator || empty($sentenceArrays[$lastKey])) {

                    //Log, test

                    $this->logMessage("Removing the last element since its empty or it is just a new line");



                    //Remove the last element is the last

                    unset($sentenceArrays[$lastKey]);
                }



                //For each element add the sentenceIndicator again

                foreach ($sentenceArrays as $key => $value) {

                    //Add the sentenceIndicator

                    $sentenceArrays[$key] .= $sentenceIndicator;
                }



                //Log, test

                $this->logMessage("The new sentence array is:", $sentenceArrays);



                //Define the final string

                $finalString = null;



                //Define the str string

                $str = "";



                //Get the desired current index

                foreach ($sentenceArrays as $i => $value) {

                    //Set the previousText

                    $previousText = $str;



                    //Get the current string and append the current one

                    $str .= $value;



                    //Check if the string is long enough

                    if (strlen($str) == $maxTextLimitSize) {

                        //Set the finalText array

                        $finalString[] = $str;



                        //Set the str to empty

                        $str = "";



                        continue;
                    } //Check if the string is long enough
                    else if (strlen($str) > $maxTextLimitSize && !empty($previousText)) {

                        //Set the finalText array
                        //Remove the current string

                        $finalString[] = $previousText;



                        //Set the str to the current value since we have left it out

                        $str = $value;



                        continue;
                    } //Check if its the last element, to set the final string
                    else if ($i == (count($sentenceArrays) - 1)) {

                        //Set the finalText array

                        $finalString[] = $str;



                        continue;
                    }
                }



                //Preform some due diligence
                //Check if the each element ends with a new line if not add one

                foreach ($finalString as $key => $value) {

                    //Trim any spaces

                    $finalString[$key] = trim($value);



                    //Log

                    $this->logMessage("The value is:{$value}, The substring is:" . substr($value, -2));



                    //Check

                    if (substr($value, -2) != PHP_EOL) {

                        //Add the new line

                        $finalString[$key] .= PHP_EOL;
                    }
                }



                //Log, test

                $this->logMessage("The final string array is", $finalString);



                //Save the final string

                $this->saveSessionVar(self::SAVED_TEXT_SENTENCES, $finalString);



                //Reset the current index

                $this->resetTextFormatting();
            }



            //Check the current index

            $currentIndex = (int) $this->getSessionVar(self::CURRENT_INDEX);

            $currentIndex = empty($currentIndex) ? 0 : $this->getSessionVar(self::CURRENT_INDEX);



            //Define the final string

            $finalString = $this->getSessionVar(self::SAVED_TEXT_SENTENCES);



            //Check if the remaining string is more than the max limit

            if ($currentIndex == 0) {

                //Return the text from the current position to the max text limit
                //Actual Text:^\n^ ^NEXT^. Next Page

                return $finalString[$currentIndex] . "\n"
                . $this->loadText("Next", array($this->getSessionVar(self::NEXT_PAGE_CHARACTER)));
            } //Check if the remaining string is more than the max limit
            else if (in_array($currentIndex, array_keys($finalString)) && $currentIndex != (count($finalString) - 1)
        ) {

                //Return the text from the current position to the max text limit
                //Actual Text: ^PREV^. Previous Page ^\n^ ^NEXT^. Next Page

                return $finalString[$currentIndex] . "\n"
            . $this->loadText("PrevNext", array(
                $this->getSessionVar(self::PREV_PAGE_CHARACTER),
                $this->getSessionVar(self::NEXT_PAGE_CHARACTER)
            ));
        }



            //Return the text with the previous option to go back
            //Actual: ^\n^ ^PREV^. Previous Page

        return $finalString[$currentIndex] . "\n" . $this->loadText("Prev", array(
            $this->getSessionVar(self::PREV_PAGE_CHARACTER)
        ));
    }

        //function to process input from DetailsValidationAirtimePage



    function resetTextFormatting() {

            //Set the current index to zero

        $this->saveSessionVar(self::CURRENT_INDEX, 0);
    }

        /*

         * ******************** Service 2: Send Money *************************************

         * */

        function processOneTimePin($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->startPage(null, $warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->startPage(null, $warning);

                return;
            } //Check if the input entered is the correct pin
            else if (strlen($input) < $this->getSessionVar(self::MINIMUM_PIN_LENGTH) || strlen($input) > $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
        ) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



            $this->startPage(null, $warning);

            return;
        }



            //Save the one tap pin

        $this->saveSessionVar(self::ONE_TAP_PIN, $input);



            //Load enter new pin

        $this->EnterNewPin();
    }

        //function to process SendMoneyPage menu



    function EnterNewPin($warning = null) {

            //Check if a warning has been set

        if (!empty($warning)) {

                //Set text

            $text = $warning . "\n";
        } else {

                //Set text
                //Actual text: Please enter your new mobile banking pin

            $text = $this->loadText("EnterNewPin") . "\n";
        }



            //Display text

        $this->presentData($text, "startPage", "processEnterNewPin");
    }

        /*

         * Function to select the top up options

         * */

        function processEnterNewPin($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->EnterNewPin($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->EnterNewPin($warning);

                return;
            } //Check if the input entered is the correct pin
            else if (strlen($input) < $this->getSessionVar(self::MINIMUM_PIN_LENGTH) || strlen($input) > $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
        ) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



            $this->EnterNewPin($warning);

            return;
        }



            //Get the input and encrypted it

        $this->saveSessionVar(self::NEW_PIN, $input);



            //Log, test

        $this->logMessage("Loading re enter new pin .. ");



            //Go to the RenterNewPin

        $this->RenterNewPin();
    }

        //Function to process input from SelectSelfOtherMobileMoney



    function RenterNewPin($warning = null) {

            //Check if a warning has been set

        if (!empty($warning)) {

                //Set text

            $text = $warning . "\n";
        } else {

                //Set text
                //Actual text: Please renter your new mobile banking pin

            $text = $this->loadText("RenterNewPin") . "\n";
        }



            //Display text

        $this->presentData($text, "startPage", "processRenterNewPin");
    }

        /*

         * Function to select the mobile provider for the recepient mobile number

         * */

        function processRenterNewPin($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->RenterNewPin($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



                $this->RenterNewPin($warning);

                return;
            } //Check if the input entered is the correct pin
            else if (strlen($input) < $this->getSessionVar(self::MINIMUM_PIN_LENGTH) || strlen($input) > $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
        ) {

                //Warning text
                //Actual Text:Invalid pin entry. The PIN should be have a minimum of ^MIN_NUMBER^
                //              digits and a maximum of ^MAX_NUMBER^ digits.

                $warning = $this->loadText("InvalidPin", array(
                    $this->getSessionVar(self::MINIMUM_PIN_LENGTH),
                    $this->getSessionVar(self::MAXIMUM_PIN_LENGTH)
                ));



            $this->RenterNewPin($warning);

            return;
            } //Check if the pin previous entered is the same as this one
            else if ($this->getSessionVar(self::NEW_PIN) != $input) {

                //Set text
                //Actual Text:Your pins do not match. Please enter new pin again

                $warning = $this->loadText("MismatchPin");



                //Display warning

                $this->EnterNewPin($warning);

                return;
            }



            //Save the pin

            $this->saveSessionVar(self::RE_NEW_PIN, $input);



            //Encrypt the new pin

            $encryptedNewPin = $this->encryptPinWallet($input);



            //Encrypt the one time pin OTP

            $encryptedOTPPin = $this->encryptPinWallet($this->getSessionVar(self::ONE_TAP_PIN));



            //Log

            $this->logMessage("Calling wallet from new pin set.....");



            //Define the payload

            $payload = array(
                "serviceID" => $this->getSessionVar(self::OTP_SERVICE_ID),
                "flavour" => "noFlavour",
                "pin" => $encryptedOTPPin,
                "newPin" => $encryptedNewPin
            );



            //Call wallet and get the response

            $response = $this->synchronousProcessing($payload);



            //Check if the response was successful\

            if (empty($response[self::SUCCESS])) {

                //Log, error

                $this->logMessage("Unable to process, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully got the OTP pin stat, the data received is: ", $response[self::DATA]);



            //Get the wallet data

            $walletData = $response[self::DATA][self::WALLET_DATA];



            //Log, test

            $this->logMessage("The wallet data is: ", $walletData);



            //Log, test

            $this->logMessage("The message is: ", $walletData[self::WALLET_MESSAGE]);



            //Get the data

            $text = $walletData[self::WALLET_MESSAGE];



            //Display message

            $this->presentData($text, null, null, self::SESSION_STATE_END);
        }

        //function to process input from SelectRecipientMNO



        function synchronousProcessing($requestPayload) {

            //Log

            $this->logMessage("Logging the request to channelRequests Logs");



            //Log the payload to channel request logs

            $response = $this->logChannelRequest($requestPayload
                , $this->getSessionVar(self::CHANNEL_REQUEST_STATUS_CODE));



            //Check if it was successful

            if (empty($response[self::CHANNEL_REQUEST_SUCCESS])) {

                //Log error

                $this->logMessage("Unable to log request to channel requests"
                    , $response[self::CHANNEL_REQUEST_MESSAGE], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual tetx: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return null;
            }



            //Get the channel request ID

            $channelRequestID = $response[self::CHANNEL_REQUEST_DATA][self::CHANNEL_REQUEST_LAST_INSERT_ID];



            //Log

            $this->logMessage("Calling wallet synchronously ...");



            //Generate the wallet payload

            $requestXML = "<Payload>";

            foreach ($requestPayload as $key => $value) {

                $requestXML .= '<' . $key . '>' . $value . '</' . $key . '>';
            }

            $requestXML .= "</Payload>";



            $payload = $requestXML;



            //Log

            $this->logMessage("The payload to be sent to wallet is: ", $payload);



            $credentials = array(
                'cloudUser' => $this->getSessionVar(self::CLOUD_USERNAME),
                'cloudPass' => $this->getSessionVar(self::CLOUD_PASSWORD),
            );



            $cloudPacket = array(
                "MSISDN" => $this->_msisdn,
                "destination" => $this->getSessionVar(self::ACCESS_POINT),
                "IMCID" => $this->getSessionVar(self::IMCID),
                "channelRequestID" => $channelRequestID,
                "networkID" => $this->getSessionVar(self::NETWORK_ID),
                "clientSystemID" => $this->getSessionVar(self::CLIENT_SYSTEM_ID),
                "systemName" => $this->getSessionVar(self::SYSTEM_NAME),
                "cloudDateReceived" => date("Y-m-d G:i:s"),
                "payload" => base64_encode($payload),
                "imcRequestID" => $this->getSessionVar(self::IMC_REQUEST_ID),
                "requestMode" => $this->getSessionVar(self::REQUEST_MODE_SYNC)
            );



            //Create the final payload to be sent

            $params = array(
                'credentials' => $credentials,
                'cloudPacket' => $cloudPacket,
            );



            //Default template of a response

            $response = array(
                self::SUCCESS => false,
                self::DATA => false,
                self::ERROR => false
            );



            //Call wallet and pass the payload

            try {

                //Log

                $this->logMessage("Calling wallet synchronously with the payload: ", $params);

                //Get the wallet url

                $walletUrl = $this->getSessionVar(self::WALLET_URL);

                //switch between https and http

                $urlScheme = parse_url($walletUrl);

                if ($urlScheme['scheme'] == "https") {



                    $this->logMessage("The wallet uses SSL,initializing SSL client");



                    $host = $urlScheme['host'];

                    $path = $urlScheme['path'];

                    $port = $urlScheme['port'];



                    $client = new xmlrpc_client($walletUrl, false);
                } else {



                    $this->logMessage("The wallet uses standard http,initializing standard IXR client");

                    //invoke standard http

                    $client = new IXR_Client($walletUrl);
                }





                $result = $client->query($this->getSessionVar(self::WALLET_PROCESS_SYNCHRONOUS_FUNCTION), $params);
                $result = $client->getResponse();
                $this->logMessage("Response from wallet:::" . print_r($result, true));



                //Get the data

                $data = json_decode($result, true);



                //Log

                $this->logMessage("Successfully got a response from wallet by calling it synchronously...");



                //Set the response

                $response = array(
                    self::SUCCESS => true,
                    self::DATA => $data,
                    self::ERROR => false
                );
            } catch (Exception $exception) {

                //Get the error

                $error = $exception->getMessage();



                //Log

                $this->logMessage("An error occurred while calling wallet synchronously ....", $error, self::LOG_LEVEL_ERROR);



                //Set the response

                $response[self::ERROR] = $error;
            }



            //Return the response

            return $response;
        }

        /*

         * Function to allow user to enter the recepients phone number

         * */

        function processHomePage($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->HomePage($warning);

                return;
            } //Check if the input is the next character
            else if ($input === $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Go to the next page segment

                $this->forwardTextFormatting();



                $this->HomePage();

                return;
            } //Check if the input is previous character
            else if ($input === $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Go to the previous page segment

                $this->rewindTextFormatting();



                $this->HomePage();

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->HomePage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadServices())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->HomePage($warning);

                return;
            }



            //Get the service number

            $serviceNumber = $this->loadServices();

            $serviceNumber = $serviceNumber[$input]["ServiceNumber"];



            //Log, test

            $this->logMessage("The service number is: " . $serviceNumber);



            //Iterate through the service code to know which service to go to next

            switch ($serviceNumber) {

                //Balance Enquiry

                case 1:

                    //Go to balance enquiry menu

                $this->BalanceEnquiryPage();

                return;

                //Airtime

                case 2:

                    //Go to the airtime service page

                $this->AirtimeTopupPage();

                return;

                //Send Money

                case 3:

                    //Go to send money menu

                $this->SendMoneyPage();

                return;

                //Full Statement

                case 4:

                    //Go to full statement menu

                $this->FullStatementPage();

                return;

                //Pending Bills

                case 5:

                    //Go to pending bills menu
    //				$this->PendingBillsPage();

                $this->BillPaymentsPage();

                return;

                //Funds Transfer

                case 6:

                    //Go to funds transfer menu

                $this->FundsTransferPage();

                return;

                //Mini Statement/

                case 7:

                    //Go to mini statement menu

                $this->MiniStatementPage();

                return;

                //Forex Rates

                case 8:

                    //Go to forex rates menu

                $this->ForexRatesPage();

                return;

                //Checkbook

                case 9:

                    //Go to checkbook menu

                $this->CheckbookPage();

                return;
            }
        }

        //function to process the input from EnterRecipientMobileNumberMoney



        function forwardTextFormatting() {  //Check the current index
            $currentIndex = (int) $this->getSessionVar(self::CURRENT_INDEX);



            //Log, test

            $this->logMessage("Forward,The current index is:" . $currentIndex
                . " and the new current index is: " . ($currentIndex + 1));



            //Get the final sentence array

            $finalString = $this->getSessionVar(self::SAVED_TEXT_SENTENCES);



            //Check if increasing exceeds the max limit

            if (($currentIndex + 1) > (count($finalString) - 1)) {

                //Log

                $this->logMessage("Reached the end cannot go further");



                return;
            }



            //Set the current index count

            $this->saveSessionVar(self::CURRENT_INDEX, $currentIndex + 1);
        }

        /*

         * Function to select the airtime amount

         * */

        function rewindTextFormatting() {

            //Check the current index

            $currentIndex = (int) $this->getSessionVar(self::CURRENT_INDEX);



            //Log, test

            $this->logMessage("Rewind,The current index is:" . $currentIndex
                . " and the new current index is: " . ($currentIndex - 1));



            //Check if increasing exceeds the max limit

            if (($currentIndex - 1) < 0) {

                //Log

                $this->logMessage("Reached the very start cannot go further");



                return;
            }



            //Set the current index count

            $this->saveSessionVar(self::CURRENT_INDEX, $currentIndex - 1);
        }

        //function to process the input from SelectMoneyMenu



        function BalanceEnquiryPage($warning = null) {

            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "HomePage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */





                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processBalanceEnquiryPage");
        }

        /*

         * Function to custom insert the amount

         * */

        function AirtimeTopupPage($warning = null) {

            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "HomePage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*  $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */





                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processAirtimeTopupPage");
        }

        //function to load input from EnterCustomAmountMoney menu



        function SendMoneyPage($warning = null) {

            //Log

            $this->logMessage("Sending money..");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "HomePage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processSendMoneyPage");
        }

        /*

         * Function to validate details entered by the user

         * */

        function FullStatementPage($warning = null) {

            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processFullStatementPage");
        }

        //function to process input from DetailsValidationAirtimePage



        /*

         * ******************** Service 3: Pending Bills *************************************

         * */



        function getCustomerBills($serviceID, $serviceCode, $isNewRequest = false) {

            //get the bill function data

            $billFunctionData = $this->getSessionVar(self::BILL_FUNCTION_DATA);



            //Save the bills

            if (!empty($billFunctionData) && !$isNewRequest) {

                return $billFunctionData;
            }



            //Set the sample template the will be returned

            $response = array(
                self::SUCCESS => false,
                self::DATA => false,
                self::NUMBER_OF_BILLS => false,
                self::ERROR => false
            );



            //Fetch bills from hub

            $hubResponse = $this->fetchPendingBills($serviceID, $serviceCode);

            $hubResponse = $hubResponse["return"];



            //Log

            $this->logMessage("The bills response from hub is: ", $hubResponse);



            //Get the status code

            $authStatusCode = $hubResponse["authStatus"]["authStatusCode"];



            //Log, test

            $this->logMessage("The auth status code is:", $authStatusCode);



            //Check if it was successfully

            if ($authStatusCode != self::HUB_SUCCESS_AUTH) {

                //Log error

                $this->logMessage("Unable to auth on HUB .", null, self::LOG_LEVEL_ERROR);



                //Return response

                return $response;
            }



            //Set the billArray

            $billsArray = $hubResponse["results"];



            //Get the status code of the first bill

            $firstBillStatusCode = $billsArray["Item"]["statusCode"];



            //Log

            $this->logMessage("The first bill status code is: ", $firstBillStatusCode);



            //Log, test

            $this->logMessage("The bill array is:", $billsArray);



            //Check if there are any invoices

            if ($billsArray && in_array($firstBillStatusCode, array(226, 227, 308))) {

                //Bills array

                $bills = null;



                //Get the bills
                //Get the service ID

                $bill[self::BILL_SERVICE_ID] = $billsArray["Item"]["serviceID"];

                //Get the amount

                $bill[self::BILL_AMOUNT] = $billsArray["Item"]["dueAmount"];

                //Get the service code

                $bill[self::BILL_SERVICE_CODE] = $serviceCode;

                //Get the account number

                $bill[self::BILL_ACCOUNT_NUMBER] = $this->getSessionVar(self::BILL_ACCOUNT_NUMBER);

                //Get the invoice number
    //				$bill[self::BILL_INVOICE_NUMBER] = $value["invoiceNumber"];
                //Add to the bills array

                $bills[] = $bill;



                //Set the response

                $response [self::SUCCESS] = true;

                $response [self::DATA] = $bills;



                //Set the number of bills

                $response[self::NUMBER_OF_BILLS] = count($bills);



                //Save bill data

                $this->saveSessionVar(self::BILL_FUNCTION_DATA, $response);



                //Log

                $this->logMessage("The number of bills are: ", count($bills));
            } else if ($billsArray && $firstBillStatusCode == self::HUB_NO_BILLS_FOUND) {

                //Set the response

                $response [self::SUCCESS] = true;



                //Set the number of bills to zero

                $response[self::NUMBER_OF_BILLS] = 0;



                //Save bill data

                $this->saveSessionVar(self::BILL_FUNCTION_DATA, $response);



                //Log

                $this->logMessage("The number of bills are zero");
            }



            //return the response

            return $response;
        }

        //function to process input from PendingBillsPage function



        function fetchPendingBills($serviceID, $serviceCode) {

            //Log

            $this->logMessage("Getting bills from hub using the mobile number:", $this->_msisdn);



            //Get the beep url

            $beepSoapUrl = $this->getSessionVar(self::BEEP_SOAP_API_URL);



            //Create a new soapClient instance

            $soapClient = new SoapClient($beepSoapUrl);



            //Set the credentials

            $credentials = array(
                "username" => $this->getSessionVar(self::HUB_USERNAME),
                "password" => $this->getSessionVar(self::HUB_PASSWORD)
            );



            //Define the payload

            $payload = array(
                "serviceCode" => $serviceCode,
                "serviceID" => $serviceID,
                "accountNumber" => $this->getSessionVar(self::BILL_ACCOUNT_NUMBER),
                "requestExtraData" => ""
            );



            //Define the final payload to be sebt

            $finalPayload = array(
                "credentials" => $credentials,
                "packet" => array("Item" => $payload)
            );



            //Log

            $this->logMessage("Fetching data from hub with function: "
                . ((String) $this->getSessionVar(self::HUB_FETCH_INVOICES_FUNCTION))
                . " and the following configurations: ", $finalPayload);



            //Query

            $response = $soapClient->queryBill($finalPayload);



            //Convert the response to a normal array

            $response = unserialize(serialize(json_decode(json_encode((array) $response), 1)));



            //Log

            $this->logMessage("The response gotten from fetching bills is: ", $response);



            //Return the response

            return $response;
        }

        /*

         * Function to display the SelectAccountPendingBills menu

         * */

        function FundsTransferPage($warning = null) {

            //Log

            $this->logMessage("Funds transfer....");



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an option:

                $text = $this->loadText("SelectOption") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Get all the FT services

            $ftServices = $this->loadFTServices();



            //Log, test

            $this->logMessage("The list of FT services are:", $ftServices);



            //Format the data

            foreach ($ftServices as $key => $value) {

                //Append to text

                $text .= $key . ". "
                . $value["FullName"]["TRANSLATIONS"][$this->getSessionVar(self::DEFAULT_LANGUAGE)] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processFundsTransferPage");
        }

        //function to process input from SelectAccountPendingBills



        function loadFTServices() {

            //Return a list of formatted FT services

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::FUNDS_SERVICES));
        }

        /*

         * function to verify details of FTP Transaction

         * */

        function MiniStatementPage($warning = null) {

            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processMiniStatementPage");
        }

        //function to process input from DetailsValidationPageBills



        function ForexRatesPage($warning = null) {

            //Log

            $this->logMessage("Hit Forex Rates page.. getting the list of supported currencies.");



            //Get the currencies

            $currencies = $this->loadCurrencies();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text:Please select a currency

                $text = $this->loadText("SelectCurrency") . "\n";
            }



            //Create the format string

            foreach ($currencies as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "HomePage", "processForexRatesPage");
        }

        /*

         * ******************** Service 4: Funds Transfer *************************************

         * */

        function loadCurrencies() {

            //Get the forex currencies

            $forexCurrencies = $this->getSessionVar(self::FOREX_CURRENCIES);



            //Check if the currencies was loaded before

            if (!empty($forexCurrencies)) {

                //Return the currencies

                return $forexCurrencies;
            }



            //Get the currencies

            $currencies = $this->getSessionVar(self::SERVICES);

            $currencies = $currencies["FOREX"]["Currencies"];

            $currencies = $this->formatRecords(explode(",", $currencies));



            //Save the currencies

            $this->saveSessionVar(self::FOREX_CURRENCIES, $currencies);



            //Return the currencies

            return $currencies;
        }

        //function to process FundsTransferPage menu



        function CheckbookPage($warning = null) {

            //Log

            $this->logMessage("Hit CheckbookPage function.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("SelectOption") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text: Please select an option

                $text = $this->loadText("SelectOption") . "\n";
            }



            //Load the list of check book services

            $checkbookServices = $this->loadCheckbookServices();



            //Format the data

            foreach ($checkbookServices as $key => $value) {

                //Append to text

                $text .= $key . ". "
                . $value["FullName"]["TRANSLATIONS"][$this->getSessionVar(self::DEFAULT_LANGUAGE)] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processCheckbookPage");
        }

        /*

         * ******************** Service 4.1: Internal Funds Transfer *************************************

         * */





        /*

         * Function that presets the InterBank funds Transfer

         * */

        function loadCheckbookServices() {

            //Return a list of formatted FT services

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::CHECKBOOK_SERVICES));
        }

        //function to process InternalFundsTransferPage menu



        function processAirtimeTopupPage($input) {

            //Get customer accounts

            $customerData = (array) $this->getCustomerData();

            $customerData = $customerData[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->AirtimeTopupPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->AirtimeTopupPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array_keys($customerData))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->AirtimeTopupPage($warning);

                return;
            }



            //Save the choosen account

            $customerAccount = $customerData[$input];

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $customerAccount);



            //Navigate to select recipient

            $this->SelectSelfOtherMobile();
        }

        /*

         * Function to select the nomination account

         * */

        function navigateBack() {

            //Get the previous function

            $previousFunction = trim($this->previousPage);



            //Log

            $this->logMessage("The previous page is: " . $previousFunction);



            //Call the previous function

            self::$previousFunction();
        }

        //function to process the input from SelectNominationAccPage



        function GoHome() {

            //Destroy session
            // $this->destroySession();
            //Go to the startPage

            $this->HomePage();
        }

        /*

         * Function to allow user to enter account number

         * */

        function SelectSelfOtherMobile($warning = null) {

            //Check if the warning system is set

            if (empty($warning)) {

                //Set the text
                //Actual Text: Select Airtime Top Up Option:

                $text = $this->loadText("SelectToupOption") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Set the options
            //Actual Text: 1.My Phone ^\n^ 2. Other Phone

            $text .= $this->loadText("SelectToupOptions");



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, "AirtimeTopupPage", "processSelectSelfOtherMobile");
        }

        //function to process EnterAccountNumber



        function processSelectSelfOtherMobile($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectSelfOtherMobile($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectSelfOtherMobile($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectSelfOtherMobile($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Go to custom enter amount

                case 1:

                    //Save the selected recipient

                $this->saveSessionVar(self::SELECTED_AIRTIME_RECIPIENT, $this->_msisdn);



                $selectAirtimeMNO = $this->loadSupportedMNOs();

                for ($i = 1; $i < count($selectAirtimeMNO); $i++) {

                    if ($this->_networkID == $selectAirtimeMNO[$i]["NetworkID"]) {

                        $selectAirtimeMNO = $selectAirtimeMNO[$i];
                    }
                }

                $this->logMessage("Selected MNO:::", $selectAirtimeMNO);

                    //$selectAirtimeMNO = $selectAirtimeMNO[1];
                    //Save the selected MNO

                $this->saveSessionVar(self::SELECTED_AIRTIME_SERVICE, $selectAirtimeMNO);



                $this->SelectAirtimeMenu(null, "SelectSelfOtherMobile");

                return;

                //Go to enter the recipient phone number

                case 2:

                $this->SelectRecipientMNO();

                return;
            }
        }

        /*

         * Function to prompt the user to nominate account

         * */

        function loadSupportedMNOs() {

            //Get the services and convert to a formatted structure

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::AIRTIME_MNO_SERVICES));
        }

        function loadMobileMoneyMNOs() {

            //Get the services and convert to a formatted structure

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::MOMO_MNO_SERVICES));
        }

        //function to process input from



        function SelectAirtimeMenu($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Log

            $this->logMessage("Hit select airtime menu getting the airtime list.");



            //Get the airtime presets

            $currencies = $this->loadAirtimePresets();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an amount

                $text = $this->loadText("SelectAmount") . "\n";
            }



            //Create the format string

            foreach ($currencies as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add the option to select the other number

            $text .= (count($currencies) + 1) . ". " . $this->loadText("EnterOtherAmount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, $previous, "processSelectAirtimeMenu");
        }

        /*

         * Function to enter the account alias

         * */

        function loadAirtimePresets() {

            //Get the presets

            $presets = $this->getSessionVar(self::SERVICES);

            $presets = $presets["AIRTIME"]["Presets"];



            //Explode the array and return it

            return $this->formatRecords(explode(",", $presets));
        }

        //function to process EnterAccountAlias



        function SelectRecipientMNO($warning = null) {

            //Get the list of the supported MNOs

            $supportedAirtimeMnos = $this->loadSupportedMNOs();



            //Check for the warning

            if (empty($warning)) {

                //Set text
                //Actual Text:Please select a mobile provider

                $text = $this->loadText("SelectMNO") . "\n";
            } else {

                //Set the warning

                $text = $warning . "\n";
            }



            //Get the MNOS

            foreach ($supportedAirtimeMnos as $key => $value) {

                //Set the text

                $text .= $key . ". " . $value["ShortName"] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "SelectSelfOtherMobile", "processSelectRecipientMNO");
        }

        /*

         * Function to confirm the saving of the alias

         * */

        function processSelectRecipientMNO($input) {

            //Log, test
    //        $this->logMessage("The input is: " . $input .
    //            " and the value is:" . in_array($input,array_keys($this->loadSupportedAirtimeMNOs()))
    //            . " the array keys is: ",array_keys($this->loadSupportedAirtimeMNOs()));
            //Check if the input is the back character



            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectRecipientMNO($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectRecipientMNO($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array_keys($this->loadSupportedMNOs()))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectRecipientMNO($warning);

                return;
            }



            //Get the custom preset

            $selectAirtimeMNO = $this->loadSupportedMNOs();

            $selectAirtimeMNO = $selectAirtimeMNO[$input];



            //Log

            $this->logMessage("The MNO selected is: ", $selectAirtimeMNO);



            //Save the selected MNO

            $this->saveSessionVar(self::SELECTED_AIRTIME_SERVICE, $selectAirtimeMNO);



            //Navigate to enter the recepient's phone number

            $this->EnterRecipientMobileNumber();
        }

        //function to process the ConfirmNominateAccount



        function EnterRecipientMobileNumber($warning = null) {



            //Check for the warning

            if (empty($warning)) {

                //Set text
                //Actual Text: Please Enter The Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $text = $this->loadText("EnterMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX)) . "\n";
            } else {

                //Set the warning

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "SelectRecipientMNO", "processEnterRecipientMobileNumber");
        }

        /*

         * Function to allow user to select amount to send

         * */

        function processEnterRecipientMobileNumber($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty Input. Please Enter The Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("EmptyMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));

                $this->logMessage("The Input is empty", $input);



                $this->EnterRecipientMobileNumber($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please Enter A Valid Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("InvalidMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));

                $this->logMessage("The Input is not numeric", $input);



                $this->EnterRecipientMobileNumber($warning);

                return;
            } //Check if the input entered is a valid phone number
            else if (!$this->isValidMSISDN($input)) {

                //Warning text
                //Actual Text: Please Enter A Valid Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("InvalidMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));

                $this->logMessage("The Input is not a valid MSISDN", $input);



                $this->EnterRecipientMobileNumber($warning);

                return;
            }



            //Save the phone number

            $this->saveSessionVar(self::SELECTED_AIRTIME_RECIPIENT, $input);



            //Navigate to enter the amount

            $this->SelectAirtimeMenu(null, "EnterRecipientMobileNumber");
        }

        //function to process the input from SelectAmountToSend



        function isValidMSISDN($mobileNumber) {

            //return preg_match("/^((\+?\d{3})?|0)2\d{8}$", $mobileNumber);

            return preg_match("/^((\+?\d{3})?|0)(2|5|7)\d{8}$/", $mobileNumber);
        }

        /*

         * function to enter custom amount

         * */

        function processSelectAirtimeMenu($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectAirtimeMenu($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectAirtimeMenu($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadAirtimePresets()) + 1 && !in_array(
                $input, array_keys($this->loadAirtimePresets())
            )
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectAirtimeMenu($warning);

                return;
            }



            //Get the custom input text

            $customInputID = count($this->loadAirtimePresets()) + 1;



            //Switch the statement

            switch ($input) {

                //Go to custom enter amount

                case $customInputID:

                $this->EnterCustomAmount();

                return;

                //One of the presets we selected

                default:

                    //Get the custom preset

                $amountPreset = $this->loadAirtimePresets();

                $amountPreset = $amountPreset[$input];



                    //Save the preset

                $this->saveSessionVar(self::SELECTED_AMOUNT, $amountPreset);



                    //Navigate to DetailsValidation page

                $this->DetailsValidationAirtimePage(null, "SelectAirtimeMenu");

                break;
            }
        }

        //function to process input from EnterCustomAmountMoneyFTP function



        function EnterCustomAmount($warning = null) {

            //Log

            $this->logMessage("Hit entering custom amount.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please enter amount

                $text = $this->loadText("EnterAmount") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "SelectAirtimeMenu", "processEnterCustomAmount");
        }

        /*

         * function to verify details of FTP Transaction

         * */

        function DetailsValidationAirtimePage($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the amount

            $amount = $this->getSessionVar(self::SELECTED_AMOUNT);



            //Get the account

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Set the text
            //Actual text: Are You Sure You Want To Buy ^CURRENCY^ ^AMOUNT^ Worth Of Airtime, With Account ^ACCOUNT_ALIAS^ To ^RECIPIENT^. ^\n^ 1. Yes ^\n^ 2. No

            $text .= $this->loadText("ValidateAirtime", array(
                $this->getSessionVar(self::CURRENCY), $amount, $selectedAccountAlias,
                $this->getSessionVar(self::SELECTED_AIRTIME_RECIPIENT)
            )) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationAirtimePage");
        }

        //function to process input from DetailsValidationPageMoneyFTP



        function processEnterCustomAmount($input) {

            //Minimum limit

            $minimumLimit = $this->getSessionVar(self::SERVICES);

            $minimumLimit = $minimumLimit["AIRTIME"]["MinimumLimit"];

            //Maximum limit

            $maximumLimit = $this->getSessionVar(self::SERVICES);

            $maximumLimit = $maximumLimit["AIRTIME"]["MaximumLimit"];



            //Check if the input is zero

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is 99
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyAmount");



                $this->EnterCustomAmount($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please enter a valid number, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("InvalidAmount", array($minimumLimit, $maximumLimit));



                $this->EnterCustomAmount($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($minimumLimit > $input || $maximumLimit < $input) {

                //Warning text
                //Actual Text: Please enter a valid amount, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("MinMaxAmount", array($minimumLimit, $maximumLimit));



                $this->EnterCustomAmount($warning);

                return;
            }



            //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $input);



            //Navigate to DetailsValidation page

            $this->DetailsValidationAirtimePage(null, "EnterCustomAmount");
        }

        /*

         * ******************** Service 4.2: External Funds Transfer (RTGS) *************************************

         * */





        /*

         * Function that represents the RTGS page

         * */

        function processDetailsValidationAirtimePage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationAirtimePage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationAirtimePage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationAirtimePage($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing airtime from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing airtime request...");


            //Get the serviceID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["AIRTIME"]["ServiceID"];

            $serviceID = "BILL_PAY";



            //Get account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $this->logMessage("Account Aliasst..." . $accountAlias);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $this->logMessage("AccountID..........." . $accountID);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //Get the serviceCode

            $serviceCode = $this->getSessionVar(self::SELECTED_AIRTIME_SERVICE);

            $this->logMessage("Selected airtime service: ", $serviceCode);

            $serviceCode = $serviceCode["ServiceCode"];

            $this->logMessage("Service Code...", $serviceCode);

            //$serviceCode = "MTNTOPUP";



            /*

             * Sample payload

             *

             * <Payload><serviceID>BILL_PAY</serviceID><pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9c670855cd2e854458047533bf</pin><flavour>open</flavour><accountAlias>DIRECT CURRENT AC</accountAlias><merchantCode>SAFTOPUP</merchantCode><amount>10000</amount><columnA>254717124841</columnA><columnC>SAFTOPUP</columnC><columnD>null</columnD><enroll>NO</enroll><CBSID>1</CBSID><accountID>34368</accountID></Payload>



             * */



            //Process the airtime request

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "amount" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "merchantCode" => $serviceCode,
                "enroll" => "NO",
                "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),
                "columnA" => $this->getSessionVar(self::SELECTED_AIRTIME_RECIPIENT),
                "columnC" => $serviceCode,
                "columnD" => "null"
            );



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted airtime request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        //function to process RTGS input



        function processSendMoneyPage($input) {

            //Get customer accounts

            $customerAccounts = (array) $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SendMoneyPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");

                $this->SendMoneyPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SendMoneyPage($warning);

                return;
            }



            //Get the chosen customer account

            $chosenCustomerAccount = $this->getCustomerData();

            $chosenCustomerAccount = $chosenCustomerAccount[self::DATA][self::CUSTOMER_ACCOUNTS][$input];


            //Save the chosen account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $chosenCustomerAccount);



            //Navigate to select recipient

            $this->SelectSelfOtherMobileMoney();
        }

        /*

         * Function to add the Beneficiary's name

         * */

        function SelectSelfOtherMobileMoney($warning = null) {

            //Check if the warning system is set

            if (empty($warning)) {

                //Set the text
                //Actual text: Select send money option.

                $text = $this->loadText("SelectSendMoneyOption") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Set the options
            //Actual Text: 1.My Phone ^\n^ 2. Other Phone

            $text .= $this->loadText("SelectSendMoneyOptions") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));


            //Display the text

            $this->presentData($text, "SendMoneyPage", "processSelectSelfOtherMobileMoney");
        }

        /**
         * Function to get the MNO ID based on msisdn
         */
        function getSelectedMNOByMSISDN($msidn) {

            if (preg_match($this->getSessionVar(self::MTN_REGEX), $msisdn)) {
                return 1;
            } else if (preg_match(EcobankUGC2BConfig::AIRTEL_REGEX, $msisdn)) {
                return EcobankUGC2BConfig::airtelNetworkID;
            } else if (preg_match(EcobankUGC2BConfig::ORANGE_REGEX, $msisdn)) {
                return EcobankUGC2BConfig::africelNetworkID;
            } else {
                return EcobankUGC2BConfig::airtelNetworkID;
            }
        }

        /*

         * Function to process the input of EnterBeneficiary page

         * */

        function processSelectSelfOtherMobileMoney($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectSelfOtherMobileMoney($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectSelfOtherMobileMoney($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectSelfOtherMobileMoney($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Go to custom enter amount

                case 1:

                    //Save the selected recipient
                $this->saveSessionVar(self::SELECTED_MONEY_RECIPIENT, $this->_msisdn);

                $selectedMNO = $this->loadMobileMoneyMNOs();

                foreach ($selectedMNO as $key => $value) {
                    if (preg_match($value[self::MNO_REGEX], $this->_msisdn)) {
                        $selectedMNO = $value;
                        break;
                    }
                }

                    //Log
                $this->logMessage("The MNO selected is: ", $selectedMNO);

                    //Save the selected MNO

                $this->saveSessionVar(self::SELECTED_MNO_SERVICE, $selectedMNO);

                $this->SelectMoneyMenu(null, "SelectSelfOtherMobileMoney");

                return;

                //Go to enter the recipient phone number

                case 2:

                $this->SelectRecipientMNOMoney();

                return;
            }
        }

        /*

         * Function to add thea

         * */

        function SelectMoneyMenu($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }

            //Log
            $this->logMessage("Hit select money menu getting the presets money list.");



            //Get the airtime presets

            $moneyPresets = $this->loadMoneyPresets();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an amount

                $text = $this->loadText("SelectAmount") . "\n";
            }



            //Create the format string

            foreach ($moneyPresets as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add the option to select the other number

            $text .= (count($moneyPresets) + 1) . ". " . $this->loadText("EnterOtherAmount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display data

            $this->presentData($text, $previous, "processSelectMoneyMenu");
        }

        /*

         * Function to process the input of a EnterRecepientNamesPage page

         * */

        function loadMoneyPresets() {

            //Get the presets

            $presets = $this->getSessionVar(self::SERVICES);

            $presets = $presets["MOMO"]["Presets"];



            //Explode the array and return it

            return $this->formatRecords(explode(",", $presets));
        }

        /*

         * Function to add the purpose of the transcation

         * */

        function SelectRecipientMNOMoney($warning = null) {

            //Get the list of the supported MNOs

            $supportedMNOs = $this->loadMobileMoneyMNOs();

            //Check for the warning

            if (empty($warning)) {

                //Set text
                //Actual Text:Please select a mobile provider

                $text = $this->loadText("SelectMNO") . "\n";
            } else {

                //Set the warning

                $text = $warning . "\n";
            }



            //Get the MNOS

            foreach ($supportedMNOs as $key => $value) {

                //Set the text

                $text .= $key . ". " . $value["ShortName"] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "SelectSelfOtherMobileMoney", "processSelectRecipientMNOMoney");
        }

        /*

         * Function to process the EnterPurposePage input of a page

         * */

        function processSelectRecipientMNOMoney($input) {

            //Log, test
    //        $this->logMessage("The input is: " . $input .
    //            " and the value is:" . in_array($input,array_keys($this->loadSupportedAirtimeMNOs()))
    //            . " the array keys is: ",array_keys($this->loadSupportedAirtimeMNOs()));
            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectRecipientMNOMoney($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectRecipientMNOMoney($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array_keys($this->loadSupportedMNOs()))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectRecipientMNOMoney($warning);

                return;
            }



            //Get the custom preset

            $selectedMNO = $this->loadMobileMoneyMNOs();

            $selectedMNO = $selectedMNO[$input];

            //Log

            $this->logMessage("The MNO selected is: ", $selectedMNO);



            //Save the selected MNO

            $this->saveSessionVar(self::SELECTED_MNO_SERVICE, $selectedMNO);



            //Navigate to enter the recepient's phone number

            $this->EnterRecipientMobileNumberMoney();
        }

        /*

         * Function to confirm the saving of the alias

         * */

        function EnterRecipientMobileNumberMoney($warning = null) {



            //Check for the warning

            if (empty($warning)) {

                //Set text
                //Actual Text: Please Enter The Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $text = $this->loadText("EnterMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX)) . "\n";
            } else {

                //Set the warning

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "SelectRecipientMNOMoney", "processEnterRecipientMobileNumberMoney");
        }

        //function to process the SaveBeneficiaryAccPage



        function processEnterRecipientMobileNumberMoney($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty Input. Please Enter The Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("EmptyMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));



                $this->EnterRecipientMobileNumberMoney($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please Enter A Valid Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("InvalidMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));



                $this->EnterRecipientMobileNumberMoney($warning);

                return;
            } //Check if the input entered is a valid phone number
            else if (!$this->isValidMSISDN($input)) {

                //Warning text
                //Actual Text: Please Enter A Valid Mobile Number. Example: ^COUNTRY_MOB_PREFIX^

                $warning = $this->loadText("InvalidMSISDN", $this->getSessionVar(self::COUNTRY_NUMBER_PREFIX));



                $this->EnterRecipientMobileNumberMoney($warning);

                return;
            }



            //Save the phone number

            $this->saveSessionVar(self::SELECTED_MONEY_RECIPIENT, $input);



            //Navigate to enter the amount

            $this->SelectMoneyMenu(null, "EnterRecipientMobileNumberMoney");
        }

        /*

         * Function to add the EnterAccountAliasRTGS

         * */

        function processSelectMoneyMenu($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectMoneyMenu($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectMoneyMenu($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadMoneyPresets()) + 1 && !in_array(
                $input, array_keys($this->loadMoneyPresets())
            )
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectMoneyMenu($warning);

                return;
            }



            //Get the custom input text

            $customInputID = count($this->loadMoneyPresets()) + 1;



            //Switch the statement

            switch ($input) {

                //Go to custom enter amount

                case $customInputID:

                $this->EnterCustomAmountMoney();

                return;

                //One of the presets we selected

                default:

                    //Get the custom preset

                $amountPreset = $this->loadMoneyPresets();

                $amountPreset = $amountPreset[$input];



                    //Save the preset

                $this->saveSessionVar(self::SELECTED_AMOUNT, $amountPreset);



                    //Navigate to DetailsValidation page

                $this->DetailsValidationPageMoney(null, "SelectMoneyMenu");

                break;
            }
        }

        /*

         * Function to process the input of a page

         * */

        function EnterCustomAmountMoney($warning = null) {

            //Log

            $this->logMessage("Hit entering custom amount.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please enter amount

                $text = $this->loadText("EnterAmount") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "SelectMoneyMenu", "processEnterCustomAmountMoney");
        }

        /*

         * Function to confirm the saving of the alias

         * */

        function DetailsValidationPageMoney($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the amount

            $amount = $this->getSessionVar(self::SELECTED_AMOUNT);



            //Get the account

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];

            //Set the text
            //Actual text: Are You Sure You Want To Send ^CURRENCY^ ^AMOUNT^ Worth Of Money, With Account ^ACCOUNT_ALIAS^ To ^RECIPIENT^. \n1. Yes \n2. No

            $text .= $this->loadText("ValidateSendMoney", array(
                $this->getSessionVar(self::CURRENCY), $amount, $selectedAccountAlias,
                $this->getSessionVar(self::SELECTED_MONEY_RECIPIENT)
            )) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationPageMoney");
        }

        //function to process the ConfirmSaveBeneficiaryPage

        function processEnterCustomAmountMoney($input) {

            //Get the minimum limits

            $minimumLimits = $this->getSessionVar(self::SERVICES);

            $minimumLimits = $minimumLimits["MOMO"]["MinimumLimit"];



            //Get the maximum limits

            $maximumLimits = $this->getSessionVar(self::SERVICES);

            $maximumLimits = $maximumLimits["MOMO"]["MaximumLimit"];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyAmount");



                $this->EnterCustomAmountMoney($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please enter a valid number, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("InvalidAmount", array($minimumLimits, $maximumLimits));



                $this->EnterCustomAmountMoney($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($minimumLimits > $input || $maximumLimits < $input) {

                //Warning text
                //Actual Text: Please enter a valid amount, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("MinMaxAmount", array($minimumLimits, $maximumLimits));



                $this->EnterCustomAmountMoney($warning);

                return;
            }



            //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $input);



            //Navigate to DetailsValidation page

            $this->DetailsValidationPageMoney(null, "EnterCustomAmountMoney");
        }

        /*

         * Function to select the airtime amount for RTGS

         * */

        function processDetailsValidationPageMoney($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationPageMoney($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationPageMoney($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationPageMoney($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing send money .....");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }

    /////////////////////////Needs to change///////////////$services = $this->getSessionVar(self::SERVICES);
            //Get the servicIDS
            $services = $this->getSessionVar(self::SERVICES);

    //        $serviceID = $services["MOMO"]["ServiceID"]; ///replaced
    //		$serviceID = "BILL_PAY";
            //Get the account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the accountID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];


            //Get the services code

            $serviceSelected = $this->getSessionVar(self::SELECTED_MNO_SERVICE);
            $serviceID = $serviceSelected["ServiceID"];

            $merchantCode = $serviceSelected["merchantCode"];
            //Log

            $this->logMessage("The MOMO serviceID is: ", $serviceID);

            $this->logMessage("The MOMO serviceCode is: ", $merchantCode);



            /*

             * Sample payload

             *

             * <Payload><serviceID>BILL_PAY</serviceID><flavour>open</flavour><pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9c670855cd2e854458047533bf</pin><accountAlias>DIRECT CURRENT AC</accountAlias><amount>100</amount><columnA>254717124841</columnA><columnC>MPESA</columnC><merchantCode>MPESA</merchantCode><CBSID>1</CBSID><enrollmentAlias>254717124841</enrollmentAlias><DestinationAccount>254717124841</DestinationAccount><enroll>NO</enroll><columnD>254717124841</columnD><accountID>34368</accountID></Payload>

             * */



            //Process the airtime request

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "amount" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "merchantCode" => $merchantCode,
                "enroll" => "NO",
                "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),
                "columnA" => $this->getSessionVar(self::SELECTED_MONEY_RECIPIENT),
                "columnC" => $merchantCode,
                "enrollmentAlias" => $this->getSessionVar(self::SELECTED_MONEY_RECIPIENT),
                "columnD" => $this->getSessionVar(self::SELECTED_MONEY_RECIPIENT),
                "DestinationAccount" => $this->getSessionVar(self::SELECTED_MONEY_RECIPIENT)
            );



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted airtime request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        //function to process the input from SelectMoneyMenuRTGS



        /*

         * Function to custom insert the amount

         * */



        function SelectAccountPendingBills($warning = null) {

            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "PendingBillsPage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "PendingBillsPage", "processSelectAccountPendingBills");
        }

        //function to load input from EnterCustomAmountRTGS menu



        function processSelectAccountPendingBills($input) {

            //Get customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectAccountPendingBills($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectAccountPendingBills($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectAccountPendingBills($warning);

                return;
            }



            //Get chosen customer account

            $chosenCustomerAccount = $this->getCustomerData();

            $chosenCustomerAccount = $chosenCustomerAccount[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the chosen account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $chosenCustomerAccount);



            //Confirm Details

            $this->DetailsValidationPageBills(null, "SelectAccountPendingBills");
        }

        /*

         * Function to validate details entered by the user

         * */

        function DetailsValidationPageBills($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the accountAlias

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Get the saved bill

            $bill = $this->getSessionVar(self::CHOSEN_BILL);



            //Get the bill amount

            $billAmount = $bill[self::BILL_AMOUNT];



            //Get the bill name

            $billName = $bill[self::BILL_INVOICE_NUMBER];



            //Set the text
            //Actual Text: Are You Sure You Want To Pay ^CURRENCY^ ^AMOUNT^ With Account ^ACCOUNT_ALIAS^ For Bill ^BILL_NAME^. \n1. Yes \n2. N

            $text .= $this->loadText("ValidateBill", array(
                $this->getSessionVar(self::CURRENCY), $billAmount,
                $selectedAccountAlias, $billName
            )) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationPageBills");
        }

        //function to process input from DetailsValidationMoneyPageRTGS



        function processDetailsValidationPageBills($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationPageBills($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationPageBills($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationPageBills($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing bills from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Get the saved bill

            $bill = $this->getSessionVar(self::CHOSEN_BILL);



            /*

             * <Payload>

             * <serviceID>BILL_PAY</serviceID>

             * <flavour>open</flavour>

             * <pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9d6d0b59cd2e854458047533bf</pin>

             * <accountAlias>Andrew_254704050143</accountAlias>

             * <accountID>367</accountID>

             * <amount>100</amount>

             * <merchantCode>HMCONE</merchantCode>

             * <enroll>null</enroll>

             * <CBSID>1</CBSID>

             * <columnA>254704050143</columnA>

             * <columnC>HMCONE</columnC>

             * <columnD>null</columnD>

             * </Payload>

             * */



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["BILLS"]["ServiceID"];



            //Process the transaction

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountData[self::ACCOUNT_ALIAS],
                "accountID" => $accountData[self::CBS_ACCOUNT_ID],
                "amount" => $bill[self::BILL_AMOUNT],
                "merchantCode" => $bill[self::BILL_SERVICE_CODE],
                "enroll" => null,
                "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),
                "columnA" => $this->_msisdn,
                "columnC" => $bill[self::BILL_SERVICE_CODE],
                "columnD" => null
            );



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response, self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted pay bill request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        /*

         * ******************** Service 4.3: Interaffiliate Funds Transfer *************************************

         * */

        function processFundsTransferPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->FundsTransferPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->FundsTransferPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($this->loadFTServices())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->FundsTransferPage($warning);

                return;
            }



            //Get the Service Number

            $serviceNumber = $this->loadFTServices();

            $serviceNumber = $serviceNumber[$input]["ServiceNumber"];



            //Check

            switch ($serviceNumber) {

                //Internal funds transfer

                case 1:

                $this->InternalFundsTransferPage();

                break;

                //RTGS

                case 2:

                $this->RTGSPage();

                break;

                //Interaffiliate funds transfer

                case 3:

                $this->InteraffiliateFundsTransferPage();

                break;

                default:

                    //Go to funds Transfer

                $this->FundsTransferPage();

                break;
            }
        }

        //function to process InteraffiliateFundsTransferPage menu



        function InternalFundsTransferPage($warning = null) {

            //Log

            $this->logMessage("Internal FT page transfer....");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "FundsTransferPage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "FundsTransferPage", "processInternalFundsTransferPage");
        }

        function RTGSPage($warning = null) {

            //Log

            $this->logMessage("External FT page transfer....");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "FundsTransferPage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "FundsTransferPage", "processRTGSPage");
        }

        function processRTGSPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->RTGSPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->RTGSPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->RTGSPage($warning);

                return;
            }



            //Get the chosen customer account

            $chosenCustomerAccount = $this->getCustomerData();

            $chosenCustomerAccount = $chosenCustomerAccount[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the chosen account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $chosenCustomerAccount);



            //Proceed to select an external bank

            $this->SelectExternalBankMenu();
        }

        function SelectExternalBankMenu($warning = null) {

            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please select a bank

                $text = $this->loadText("SelectBank") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Get a list of all supported banks

            $rtgsBanks = $this->loadRTGSBanks();



            //Log, test
    //        $this->logMessage("The list of RTGS banks are: ", $rtgsBanks);
            //Format the list of the Banks

            foreach ($rtgsBanks as $key => $value) {

                //Append

                $text .= $key . ". " . $value["FullName"] . "\n";
            }



            //Format the largeText

            $text = $this->largeTextFormatting($text);



            //Display text

            $this->presentData($text, "RTGSPage", "processSelectExternalBankMenu");
        }

        function processSelectExternalBankMenu($input) {   //Check if its previous page
            if ($input == $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Forward the page

                $this->rewindTextFormatting();



                $this->SelectExternalBankMenu();

                return;
            } //Check if its next page
            else if ($input == $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Forward the page

                $this->forwardTextFormatting();



                $this->SelectExternalBankMenu();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectExternalBankMenu($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectExternalBankMenu($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadRTGSBanks())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectExternalBankMenu($warning);

                return;
            }



            //Get the selected bank

            $selectedBank = $this->loadRTGSBanks();

            $selectedBank = $selectedBank[$input];



            //Get the Bank configuration

            $this->saveSessionVar(self::SELECTED_RTGS_BANK, $selectedBank);



            //Check if there a list on any beneficiary's have been loaded; TODO
            //Navigate to enter beneficiary account number

            $this->EnterBeneficiaryAccNumberPage();
        }

        //function to process SelectDestinationCountry input



        function loadRTGSBanks() {

            //Get the list of banks

            $rtgsBanks = $this->getSessionVar(self::FUNDS_SERVICES);

            $rtgsBanks = $rtgsBanks["RTGS"]["BANKS"];



            //Load the banks

            return $this->removeInActiveFormatRecords($rtgsBanks);
        }

        function InteraffiliateFundsTransferPage($warning = null) {

            //Log

            $this->logMessage("Interaffilaite FT page transfer....");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "FundsTransferPage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "FundsTransferPage", "processInteraffiliateFundsTransferPage");
        }

        //function to process SelectDeliveryMode input



        function processInternalFundsTransferPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->InternalFundsTransferPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->InternalFundsTransferPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->InternalFundsTransferPage($warning);

                return;
            }



            //Get the chosen customer account

            $chosenCustomerAccount = $this->getCustomerData();

            $chosenCustomerAccount = $chosenCustomerAccount[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the chosen account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $chosenCustomerAccount);



            //Get customer nominations

            $iftCustomerNomination = $this->getCustomerData();

            $iftCustomerNomination = $iftCustomerNomination[self::CUSTOMER_IFT_NOMINATIONS];



            //Check if any nomination data was set

            if (empty($iftCustomerNomination)) {

                //Log

                $this->logMessage("No nominations found proceeding to entering bank account.");



                //Navigate to enter account number

                $this->EnterAccountNumber(null, "FundsTransferPage");

                return;
            }



            //Navigate to select the Nomination

            $this->SelectNominationAccPage();
        }

        /*

         * Function to allow user to enter account number

         * */

        private function EnterAccountNumber($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please enter account number:

                $text = $this->loadText("EnterAccount") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, $previous, "processEnterAccountNumber");
        }

        //function to process EnterAffiliateAccountNumber



        function SelectNominationAccPage($warning = null) {

            //Log

            $this->logMessage("Hit select nomination account getting list.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            }



            //Get a list of nomination pages

            $nominationAccounts = $this->getCustomerData();

            $nominationAccounts = $nominationAccounts[self::CUSTOMER_IFT_NOMINATIONS];



            //Create the format string

            foreach ($nominationAccounts as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value[self::WALLET_NOMINATION_ACC_NOS]
                . ", " . $value[self::WALLET_NOMINATION_NAME] . "\n";
            }



            //Add the option to select the other number
            //Actual Text: Enter other account

            $text .= (count($nominationAccounts) + 1) . ". " . $this->loadText("EnterOtherAccount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "FundsTransferPage", "processSelectNominationAccPage");
        }

        function processSelectNominationAccPage($input) {

            //Get the ift nominations

            $iftNominations = $this->getCustomerData();

            $iftNominations = $iftNominations[self::CUSTOMER_IFT_NOMINATIONS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectNominationAccPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectNominationAccPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($iftNominations) + 1 && !in_array($input, array_keys($iftNominations))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectNominationAccPage($warning);

                return;
            }



            //Get the ift nominations

            $iftNominations = $this->getCustomerData();

            $iftNominations = $iftNominations[self::CUSTOMER_IFT_NOMINATIONS];



            //Get the custom input text

            $customInputID = count($iftNominations) + 1;



            //Switch the statement

            switch ($input) {

                //Go to custom enter account number

                case $customInputID:

                $this->EnterAccountNumber(null, "SelectNominationAccPage");

                return;

                //One of the presets we selected

                default:

                    //Get the account number

                $accountNumber = $this->getCustomerData();

                $accountNumber = $accountNumber[self::CUSTOMER_IFT_NOMINATIONS][$input][self::WALLET_NOMINATION_ACC_NOS];



                    //Save the preset

                $this->saveSessionVar(self::SELECTED_FT_RECIPIENT, $accountNumber);



                    //Navigate to SelectAmountToSend page

                $this->SelectAmountToSend(null, "SelectNominationAccPage");

                break;
            }
        }

        //function to process SelectTransfer Reason input



        function SelectAmountToSend($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Log

            $this->logMessage("Hit select money FT menu getting the presets money list.");



            //Get the airtime presets

            $moneyPresets = $this->loadMoneyFTPPresets();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an amount

                $text = $this->loadText("SelectAmount") . "\n";
            }



            //Create the format string

            foreach ($moneyPresets as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add the option to select the other number

            $text .= (count($moneyPresets) + 1) . ". " . $this->loadText("EnterOtherAmount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display data

            $this->presentData($text, $previous, "processSelectAmountToSend");
        }

        /*

         * Function to custom insert transfer reason

         * */

        function loadMoneyFTPPresets() {

            //Get the presets

            $presets = $this->getSessionVar(self::SERVICES);

            $presets = $presets["FUNDSTRANSFER"]["Presets"];



            //Explode the array and return it

            return $this->formatRecords(explode(",", $presets));
        }

        //function to load input from EnterInterAffiliateCustomAmountIAFT menu



        function processEnterAccountNumber($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty input. Please enter account number

                $warning = $this->loadText("EmptyAccount");



                $this->EnterAccountNumber($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid account number

                $warning = $this->loadText("InvalidAccount");



                $this->EnterAccountNumber($warning);

                return;
            }

            /* <Payload>

              <serviceID>220</serviceID>

              <flavour>noFlavour</flavour>

              <MSISDN>2348023644432</MSISDN>

              <pin>####</pin>

              <accountAlias>ecobank-acc3561</accountAlias>

              <accountID>2139</accountID>

              <columnA>0010014402255901</columnA> account number to query

              <columnB>EGH</columnB> affiliate code

              </Payload> */



            //Get the service ID
    //		$serviceID = $this->getSessionVar(self::SERVICES);
    //		$serviceID = $serviceID["GETACCOUNTINFO"]["ServiceID"];

              $serviceID = 220;



            //Get the account alias

              $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

              $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the account ID

              $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

              $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //Process the name enquiry request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "MSISDN" => $this->_msisdn,
                "accountID" => $accountID,
                "columnB" => $this->getSessionVar(self::AFFILIATE_CODE),
                "columnA" => $input
            );



              $response = $this->synchronousProcessing($payload);

              $this->logMessage("Response from wallet: " . json_encode($response));



            if ($response[self::DATA][self::WALLET_DATA]['STATUS_CODE'] == 1) {//success from wallet.

                /*

                 * accountInformation: michael

                 */

                //send request to wallet

                $accNameString = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

                $accountName = explode('accountName: ', $accNameString);

                $this->logMessage("Received account name: ", $accountName);
            } else {

                //Get the data

                $text = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

    //			$this->presentData($text, "EnterAccountNumber", null);

                $this->FinalPage($text);

                return;
            }





            //Save the account number

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT, $input);



            //Save the account name

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT_NAME, $accountName[1]);



            //Log

            $this->logMessage("The entered recipient account number is: ", $input);



            //Navigate to select amount to be send

            $this->NominateAccountPage();
        }

        /*

         * Function to allow user to select amount to send

         * */

        private function NominateAccountPage($warning = null) {

            //Set the text

            $text = "";



            //Check if the warning has been set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Load text
            //Actual text: Do You Wish To Nominate Account ^ACCOUNT^.\n1. Yes \n2. No

            $text .= $this->loadText("NominateAccount", array($this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME))) . "\n";



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "EnterAccountNumber", "processNominateAccountPage");
        }

        //function to process the input from SelectAmountToSend



        function processNominateAccountPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty input. Please select again

                $warning = $this->loadText("EmptyInput");



                $this->NominateAccountPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option

                $warning = $this->loadText("InvalidInput");



                $this->NominateAccountPage($warning);

                return;
            } //Check if its 1 or 2
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option

                $warning = $this->loadText("InvalidInput");



                $this->NominateAccountPage($warning);

                return;
            }



            //Switch

            if ($input == 1) {

                //Save user info

                $this->EnterAccountAlias();

                return;
            } //Proceed to select amount
            else {

                //Enter account

                $this->SelectAmountToSend(null, "NominateAccountPage");

                return;
            }
        }

        /*

         * Function to custom insert the amount

         * */

        function EnterAccountAlias($warning = null) {  //Check if the warning has been set
            if (empty($warning)) {

                //Load text
                //Actual text: Please enter the name alias for account number ^ACCOUNT_NUMBER^.

                $text = $this->loadText("EnterAccountAlias", array($this->getSessionVar(self::SELECTED_FT_RECIPIENT))) . "\n";

                $this->processEnterAccountAlias($this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME));
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text
            // $this->presentData($text, "NominateAccountPage", "processEnterAccountAlias");
        }

        //function to load input from EnterInterAffiliateCustomAmountIAFT menu



        function processEnterAccountAlias($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty input. Please enter the name alias for account number ^ACCOUNT_NUMBER^.

                $warning = $this->loadText("EmptyAccountAlias", array($this->getSessionVar(self::SELECTED_FT_RECIPIENT)));



                $this->EnterAccountAlias($warning);

                return;
            }



            //Check if the input is not a number

            /* else if (strlen($input) < 4 || strlen($input) > 15) {

              //Warning text

              //Actual Text: Incorrect account alias. The name alias should be between 4 and 15 characters for account ^ACCOUNT_NUMBER^

              $warning = $this->loadText("InvalidAccountAlias", array($this->getSessionVar(self::SELECTED_FT_RECIPIENT)));



              $this->EnterAccountAlias($warning);

              return;

          } */



            //Save the account number

          $this->saveSessionVar(self::CHOSEN_CUSTOMER_NOMINATED_NAME, $input);



            //Log

          $this->logMessage("The entered nominated name is: ", $input);



            //Navigate to select amount to be send

          $this->ConfirmNominateAccount();
      }

        /*

         * Function to validate details entered by the user

         * */

        function ConfirmNominateAccount($warning = null) {

            //Log

            $this->logMessage("Entered confirm nominated account ... ");



            //Set the text

            $text = "";



            if (!empty($warning)) {

                //Set the text

                $text = $warning . "\n";
            }



            //Set the text
            //Actual Text: Confirm saving alias ^ALIAS^ for account number ^ACCOUNT_NUMBER^ ^\n^ 1. Yes ^\n^ 2. No

            $text .= $this->loadText("ConfirmNomination", array(
                $this->getSessionVar(self::CHOSEN_CUSTOMER_NOMINATED_NAME),
                $this->getSessionVar(self::SELECTED_FT_RECIPIENT)
            )) . "\n";





            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, "EnterAccountAlias", "processConfirmNominateAccount");
        }

        //function to process input from DetailsValidationPageIAFT



        function processConfirmNominateAccount($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->ConfirmNominateAccount($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->ConfirmNominateAccount($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->ConfirmNominateAccount($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Save the nomination account

                $this->saveSessionVar(self::SAVE_NOMINATION, true);



                    //Proceed to enter amount

                $this->SelectAmountToSend(null, "ConfirmNominateAccount");

                return;

                //No

                case 2:

                $this->SelectAmountToSend(null, "ConfirmNominateAccount");

                return;

                default:

                $this->ConfirmNominateAccount();

                return;
            }
        }

        /*

         * ******************** Service 5: Forex Rates *************************************

         * */

        function processSelectAmountToSend($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectAmountToSend($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectAmountToSend($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadMoneyFTPPresets()) + 1 && !in_array($input, array_keys($this->loadMoneyFTPPresets()))
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



            $this->SelectAmountToSend($warning);

            return;
        }



            //Get the custom input text

        $customInputID = count($this->loadMoneyFTPPresets()) + 1;



            //Switch the statement

        switch ($input) {

                //Go to custom enter amount

            case $customInputID:

            $this->EnterCustomAmountMoneyFTP();

            return;

                //One of the presets we selected

            default:

                    //Get the custom preset

            $amountPreset = $this->loadMoneyFTPPresets();

            $amountPreset = $amountPreset[$input];



                    //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $amountPreset);



                    //Navigate to DetailsValidation page

            $this->DetailsValidationPageMoneyFTP(null, "SelectAmountToSend");

            break;
        }
    }

        /*

         * Function to process the input of ForexRatesPage page

         * */

        function EnterCustomAmountMoneyFTP($warning = null) {

            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please enter amount:

                $text = $this->loadText("EnterAmount") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "SelectAmountToSend", "processEnterCustomAmountMoneyFTP");
        }

        /*

         * ******************** Service 6: Full Statement *************************************

         * */

        function DetailsValidationPageMoneyFTP($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the amount

            $amount = $this->getSessionVar(self::SELECTED_AMOUNT);



            //Get the account

            $selectedAccount = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccount[self::ACCOUNT_ALIAS];



            //Log

            $this->logMessage("The choosen account details are: ", $selectedAccount);

            $this->logMessage("The choosen alias is: ", $selectedAccountAlias);

            $this->logMessage("The Recipient's name is: ", $this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME));



            //Set the text
            //Actual text: Are You Sure You Want To Send ^CURRENCY^ ^AMOUNT^ Worth Of Money,
            // From Account ^ACCOUNT_ALIAS^ To ^RECIPIENT^.\n1. Yes \n2. No

            $text .= $this->loadText("ValidateFTP", array(
                $this->getSessionVar(self::CURRENCY),
                $amount,
                $selectedAccountAlias,
                $this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME)
            )) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER),
                $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationPageMoneyFTP");
        }

        //function to process FullStatementPage



        function processEnterCustomAmountMoneyFTP($input) {

            //Get the minimum limits

            $minimumLimits = $this->getSessionVar(self::SERVICES);

            $minimumLimits = $minimumLimits["FUNDSTRANSFER"]["MinimumLimit"];



            //Get the maximum limits

            $maximumLimits = $this->getSessionVar(self::SERVICES);

            $maximumLimits = $maximumLimits["FUNDSTRANSFER"]["MaximumLimit"];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty input. Please enter amount

                $warning = $this->loadText("EmptyAmount");



                $this->EnterCustomAmountMoneyFTP($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please enter a valid number, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("InvalidAmount", array($minimumLimits, $maximumLimits));



                $this->EnterCustomAmountMoneyFTP($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($minimumLimits > $input || $maximumLimits < $input) {

                //Warning text
                //Actual Text: Please enter a valid amount, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("MinMaxAmount", array($minimumLimits, $maximumLimits));



                $this->EnterCustomAmountMoneyFTP($warning);

                return;
            }





            //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $input);



            //Navigate to DetailsValidation page

            $this->DetailsValidationPageMoneyFTP(null, "EnterCustomAmount");
        }

        //function to enter the start date from full statement



        function processDetailsValidationPageMoneyFTP($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationPageMoneyFTP($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationPageMoneyFTP($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationPageMoneyFTP($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing FT from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing FTP request...");



            /*

             * Sample payload

             *

             * <Payload>

             * <serviceID>13</serviceID>

             * <flavour>open</flavour>

             * <pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9d6e095ccd2e854458047533bf</pin>

             * <accountAlias>patrick</accountAlias>

             * <amount>3500</amount>

             * <columnA>100500444</columnA>

             * <columnD>1</columnD>

             * <accountID>879</accountID>

             * <nominate>NO</nominate>

             * </Payload>

             * */



            //Get the service ID





            $serviceID = $this->getSessionVar(self::FUNDS_SERVICES);

            $serviceID = $serviceID["INTERNALFT"]["ServiceID"];

            //Get the service code

            $serviceCode = $this->getSessionVar(self::FUNDS_SERVICES);

            $serviceCode = $serviceCode["INTERNALFT"]["ServiceCode"];



            //Get the account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            $recipientName = $this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME);

            $systemName = $this->getSessionVar(self::SYSTEM_NAME);



            //Log

            $this->logMessage("The FT recipient account number is: ", $this->getSessionVar(self::SELECTED_FT_RECIPIENT));



            /*

             * <Payload><serviceID>93</serviceID><flavour>open</flavour><pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9c670855cd2e854458047533bf</pin><accountAlias>DIRECT CURRENT AC</accountAlias><amount>10000</amount><columnA>0100003991711</columnA><columnB>3199000</columnB><columnC>Max N</columnC><columnD>null</columnD><columnF>Ecobank app test</columnF><nominate>NO</nominate><CBSID>1</CBSID><extra>Max N|Ecobank app test|</extra><accountID>34368</accountID></Payload>

             * */

            //Process the airtime request

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "amount" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),
                "columnA" => $this->getSessionVar(self::SELECTED_FT_RECIPIENT),
                "columnB" => $serviceCode,
                "columnC" => $recipientName,
                "columnD" => "null",
                "columnF" => $systemName,
                "extra" => "{$recipientName}|{$systemName}|",
                "nominate" => "NO"
            );



            //Check if nomination has been enabled

            if ($this->getSessionVar(self::SAVE_NOMINATION)) {

                //Add the nomination field

                $payload["nominate"] = "YES";

                $payload["columnD"] = $this->getSessionVar(self::CHOSEN_CUSTOMER_NOMINATED_NAME);
            }



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted airtime request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        //function to enter the start date from full statement



        function EnterBeneficiaryAccNumberPage($warning = null) {

            //Log

            $this->logMessage("Hit enter acc number beneficiary page.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("EnterBeneficiaryAcc") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text:Please enter the beneficiary account number:

                $text = $this->loadText("EnterBeneficiaryAcc") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "RTGSPage", "processEnterBeneficiaryAccNumberPage");
        }

        //function to process entry from EnterStartDateMenu



        function processEnterBeneficiaryAccNumberPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterBeneficiaryAccNumberPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->EnterBeneficiaryAccNumberPage($warning);

                return;
            }



            //Save the account number

            $this->saveSessionVar(self::BENEFICIARY_ACC_NUMBER, $input);

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT, $input);



            //Log

            $this->logMessage("The saved recipient account number is: ", $this->getSessionVar(self::SELECTED_FT_RECIPIENT));



            //Navigate to enter recepient's full name

            $this->EnterRecipientNamesPage();
        }

        /*

         * ******************** Service 7: Mini Statement *************************************

         * */

        function EnterRecipientNamesPage($warning = null) {

            //Log

            $this->logMessage("Hit EnterRecepientNamesPage function.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("EnterRecipientName") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text:Please enter the recipient full names:

                $text = $this->loadText("EnterRecipientName") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "EnterBeneficiaryAccNumberPage", "processEnterRecipientNamesPage");
        }

        //function to process MiniStatementPage



        function processEnterRecipientNamesPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterRecipientNamesPage($warning);

                return;
            }





            //Save the account number

            $this->saveSessionVar(self::RECIPIENTS_FULL_NAMES, $input);

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT_NAME, $input);



            //Navigate to enter the purpose

            $this->EnterPurposePage();
        }

        /*

         * This is the page that validates the information regarding ministatements

         * */

        function EnterPurposePage($warning = null) {

            //Log

            $this->logMessage("Hit EnterPurposePage function.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("EnterPurpose") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text: Please enter the purpose

                $text = $this->loadText("EnterPurpose") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "EnterRecipientNamesPage", "processEnterPurposePage");
        }

        //function to process the ConfirmMiniStatementPage



        function processEnterPurposePage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterPurposePage($warning);

                return;
            }



            //Save the purpose

            $this->saveSessionVar(self::PURPOSE_TRANSACTION, $input);



            //Navigate to enter recepient's full name

            $this->SaveBeneficiaryAccPage();
        }

        /*

         * ******************** Service 8: Balance Enquiry *************************************

         * */

        function SaveBeneficiaryAccPage($warning = null) {

            //Log

            $this->logMessage("Entered SaveBeneficiaryAccPage ... ");



            //Set the text

            $text = "";



            if (!empty($warning)) {

                //Set the text

                $text = $warning . "\n";
            }



            //Set the text
            //Actual Text: Would you like to save account number ^ACCOUNT_NUMBER^ for future use? ^\n^ 1. Yes ^\n^ 2. No

            $text .= $this->loadText("SaveAcc", array($this->getSessionVar(self::BENEFICIARY_ACC_NUMBER))) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, "EnterPurposePage", "processSaveBeneficiaryAccPage");
        }

        //function to process balance enquiry data



        function processSaveBeneficiaryAccPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SaveBeneficiaryAccPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SaveBeneficiaryAccPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SaveBeneficiaryAccPage($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Proceed to enter account alias

                $this->EnterAccountAliasRTGS();

                return;

                //No

                case 2:

                $this->SelectMoneyMenuRTGS();

                return;

                default:

                $this->SaveBeneficiaryAccPage();

                return;
            }
        }

        /*

         * ******************** Service 9: Checkbook *************************************

         * */

        function EnterAccountAliasRTGS($warning = null) {

            //Log

            $this->logMessage("Hit EnterAccountAliasRTGS function.");



            //Get the account number

            $beneficiaryAccNumber = $this->getSessionVar(self::BENEFICIARY_ACC_NUMBER);



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("EnterAccountAlias", array($beneficiaryAccNumber)) . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text:Please enter the name alias for account number ^ACCOUNT_NUMBER^.

                $text = $this->loadText("EnterAccountAlias", array($beneficiaryAccNumber)) . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "ConfirmSaveBeneficiaryAccPage", "processEnterAccountAliasRTGS");
        }

        //Function to process the input of CheckbookPage page



        function processEnterAccountAliasRTGS($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterAccountAliasRTGS($warning);

                return;
            }



            //Save the account number

            $this->saveSessionVar(self::BENEFICIARY_ACC_ALIAS, $input);



            //Navigate to enter recipient's full name

            $this->ConfirmSaveBeneficiaryPage();
        }

        /*

         * ******************** Service 9.1: Checkbook Request *************************************

         * */





        /*

         * Function that handles checkbook requests

         * */

        function ConfirmSaveBeneficiaryPage($warning = null) {

            //Log

            $this->logMessage("Entered ConfirmSaveBeneficiaryPage ... ");



            //Set the text

            $text = "";



            if (!empty($warning)) {

                //Set the text

                $text = $warning . "\n";
            }



            //Set the text
            //Actual Text: Would you like to save account alias ^ACCOUNT_ALIAS^ for account number ^ACCOUNT_NUMBER^ ^\n^ 1. Yes ^\n^ 2. No

            $text .= $this->loadText("ConfirmSaveAcc", array($this->getSessionVar(self::BENEFICIARY_ACC_ALIAS), $this->getSessionVar(self::BENEFICIARY_ACC_NUMBER))) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, "EnterAccountAliasRTGS", "processConfirmSaveBeneficiaryPage");
        }

        //function to process CheckbookRequestPage input



        function processConfirmSaveBeneficiaryPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->ConfirmSaveBeneficiaryPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->ConfirmSaveBeneficiaryPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->ConfirmSaveBeneficiaryPage($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Save the beneficiary account

                $this->saveSessionVar(self::SAVE_BENEFICIARY, true);



                    //Proceed to enter amount

                $this->SelectMoneyMenuRTGS(null, "ConfirmSaveBeneficiaryPage");

                return;

                //No

                case 2:

                    //Proceed to enter amount

                $this->SelectMoneyMenuRTGS(null, "ConfirmSaveBeneficiaryPage");

                return;

                default:

                $this->ConfirmSaveBeneficiaryPage();

                return;
            }
        }

        /*

         * Function to select the number of leaves

         * */

        function SelectMoneyMenuRTGS($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Log

            $this->logMessage("Hit select money menu RTGS.");



            //Get the airtime presets

            $moneyFTPPresets = $this->loadMoneyFTPPresets();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an amount

                $text = $this->loadText("SelectAmount") . "\n";
            }



            //Create the format string

            foreach ($moneyFTPPresets as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add the option to select the other number

            $text .= (count($moneyFTPPresets) + 1) . ". " . $this->loadText("EnterOtherAmount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, $previous, "processSelectMoneyMenuRTGS");
        }

        /*

         * Function to process the input of a SelectNumberLeaves page

         * */

        function processSelectMoneyMenuRTGS($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectMoneyMenuRTGS($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectMoneyMenuRTGS($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadMoneyFTPPresets()) + 1 && !in_array(
                $input, array_keys($this->loadAirtimePresets())
            )
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectMoneyMenuRTGS($warning);

                return;
            }



            //Get the custom input text

            $customInputID = count($this->loadMoneyFTPPresets()) + 1;



            //Switch the statement

            switch ($input) {

                //Go to custom enter amount

                case $customInputID:

                $this->EnterCustomAmountRTGS();

                return;

                //One of the presets we selected

                default:

                    //Get the custom preset

                $amountPreset = $this->loadMoneyFTPPresets();

                $amountPreset = $amountPreset[$input];



                    //Save the preset

                $this->saveSessionVar(self::SELECTED_AMOUNT, $amountPreset);



                    //Navigate to DetailsValidation page

                $this->DetailsValidationMoneyPageRTGS(null, "SelectMoneyMenuRTGS");

                break;
            }
        }

        /*

         * Function to validate details entered by the user

         * */

        function EnterCustomAmountRTGS($warning = null) {

            //Log

            $this->logMessage("Hit entering custom amount RTGS.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please enter amount

                $text = $this->loadText("EnterAmount") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "SelectMoneyMenuRTGS", "processEnterCustomAmountRTGS");
        }

        //function to process input from DetailsValidationCheckbookRequest



        function DetailsValidationMoneyPageRTGS($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the amount

            $amount = $this->getSessionVar(self::SELECTED_AMOUNT);



            //Get the account

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Set the text
            //Actual text: Are You Sure You Want To Send ^CURRENCY^ ^AMOUNT^ Worth Of Money, With Account ^ACCOUNT_ALIAS^ To ^RECIPIENT^.\n1. Yes \n2. No

            $text .= $this->loadText("ValidateFTP", array(
                $this->getSessionVar(self::CURRENCY),
                $amount, $selectedAccountAlias,
                $this->getSessionVar(self::SELECTED_FT_RECIPIENT)
            )) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationMoneyPageRTGS");
        }

        /*

         * ******************** Service 9.2: Stop Checkbook Request *************************************

         * */





        /*

         * Function that handles stopping checkbook requests

         * */

        function processEnterCustomAmountRTGS($input) {

            //Minimum limit

            $minimumLimit = $this->getSessionVar(self::SERVICES);

            $minimumLimit = $minimumLimit["FUNDSTRANSFER"]["MinimumLimit"];

            //Maximum limit

            $maximumLimit = $this->getSessionVar(self::SERVICES);

            $maximumLimit = $maximumLimit["FUNDSTRANSFER"]["MaximumLimit"];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyAmount");



                $this->EnterCustomAmountRTGS($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please enter a valid number, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("InvalidAmount", array($minimumLimit, $maximumLimit));



                $this->EnterCustomAmountRTGS($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($minimumLimit > $input || $maximumLimit < $input) {

                //Warning text
                //Actual Text: Please enter a valid amount, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("MinMaxAmount", array($minimumLimit, $maximumLimit));



                $this->EnterCustomAmountRTGS($warning);

                return;
            }





            //Switch the statement

            switch ($input) {

                //One of the presets we selected

                default:

                    //Save the preset

                $this->saveSessionVar(self::SELECTED_AMOUNT, $input);



                    //Navigate to DetailsValidation page

                $this->DetailsValidationMoneyPageRTGS(null, "EnterCustomAmountRTGS");

                break;
            }
        }

        //function to process StopCheckbookRequestPage input



        function processDetailsValidationMoneyPageRTGS($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationMoneyPageRTGS($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationMoneyPageRTGS($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationMoneyPageRTGS($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing RTGS from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing RTGS request...", "");



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::FUNDS_SERVICES);

            $serviceID = $serviceID["RTGS"]["ServiceID"];

            $this->logMessage("Service id is", $serviceID);


            //Get account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //Get the bank code

            $bankCode = $this->getSessionVar(self::SELECTED_RTGS_BANK);

            $bankCode = $bankCode["BankCode"];

            $this->logMessage("Bank code is", $bankCode);


            //Get the bank short name

            $bankShortName = $this->getSessionVar(self::SELECTED_RTGS_BANK);

            $bankShortName = $bankShortName["ShortName"];



            /*

             * "serviceID" => $this->getSessionVar("_SERVICEID"),

              "flavour" => "open",

              "pin" => $this->getSessionVar("encryptedPin"),

              "accountAlias" => $this->getSessionVar("_accountAlias"),

              "accountID" => $this->getSessionVar("_accountID"),

              "amount" => $this->getSessionVar("_AMOUNT"),

              "columnA" => $this->getSessionVar("beneficiaryAccount"),

              "columnB" => $this->getSessionVar("swiftCode"),

              "columnC" => $this->getSessionVar("_NARATION") ."|". $this->getSessionVar("beneficiaryAddress"),//$this->getSessionVar("_NARATION"),

              "columnD" => $this->getSessionVar("beneficiaryName"),

              "columnF" => $this->getSessionVar("beneficiaryBank"),

              "extra" => str_replace(" ", "|", $this->getSessionVar("beneficiaryName")));

             * */



            //Process the airtime request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "open",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "amount" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),
                "columnA" => $this->getSessionVar(self::BENEFICIARY_ACC_NUMBER),
                "columnB" => $bankCode,
                "columnC" => $this->getSessionVar(self::RECIPIENTS_FULL_NAMES),
                "columnD" => $this->getSessionVar(self::PURPOSE_TRANSACTION),
                "columnF" => $this->getSessionVar(self::RECIPIENTS_FULL_NAMES),
                "extra" => str_replace(" ", "|", $this->getSessionVar(self::RECIPIENTS_FULL_NAMES))
            );



            //Call wallet and get the response

              $response = $this->asynchronousProcessing($payload);



            //Log

              $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

              if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted RTGS request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        /*

         * Function to enter the check number

         * */

        function processInteraffiliateFundsTransferPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->InteraffiliateFundsTransferPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->InteraffiliateFundsTransferPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->InteraffiliateFundsTransferPage($warning);

                return;
            }



            //Get the chosen customer account

            $chosenCustomerAccount = $this->getCustomerData();

            $chosenCustomerAccount = $chosenCustomerAccount[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the chosen account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $chosenCustomerAccount);



            //Get customer nominations

            $iftCustomerNomination = $this->getCustomerData();

            $iftCustomerNomination = $iftCustomerNomination[self::CUSTOMER_IFT_NOMINATIONS];



            //Check if any nomination data was set

            /* if (empty($iftCustomerNomination)) {

              //Log

              $this->logMessage("No nominations found proceeding to entering bank account.");



              //Navigate to enter account number

              $this->EnterAccountNumber(null, "FundsTransferPage");

              return;

          } */



            //Navigate to select the Nomination

          $this->SelectDestinationCountryPage();
      }

        /*

         * Function to process the input of a SelectNumberLeaves page

         * */

        function SelectDestinationCountryPage($warning = null) {

            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please select Destination Country

                $text = $this->loadText("SelectCountry") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Get a list of all countries

            $affiliateCountries = $this->loadCountries();



            //Log, test
    //        $this->logMessage("The list of Countries are: ", $affiliateCountries);
            //Format the list of the countries

            foreach ($affiliateCountries as $key => $value) {

                //Append

                $text .= $key . ". " . $value["CountryName"] . "\n";
            }



            //Format the largeText

            $text = $this->largeTextFormatting($text);



            //Display text

            $this->presentData($text, "FundsTransferPage", "processSelectDestinationCountryPage");
        }

        /*

         * Function to validate details entered by the user

         * */

        function loadCountries() {

            //Load the affilaite countries

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::AFFILIATE_COUNTRIES));
        }

        //function to process input from DetailsValidationStopCheckbookRequest



        function processSelectDestinationCountryPage($input) {   //Check if its previous page
            if ($input == $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Forward the page

                $this->rewindTextFormatting();



                //Load the SelectDestinationCountryPage page

                $this->SelectDestinationCountryPage();

                return;
            } //Check if its next page
            else if ($input == $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Forward the page

                $this->forwardTextFormatting();



                //Load the SelectDestinationCountryPage page

                $this->SelectDestinationCountryPage();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectDestinationCountryPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectDestinationCountryPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadCountries())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectDestinationCountryPage($warning);

                return;
            }



            //Get the selected country

            $selectedCountry = $this->loadCountries();

            $selectedCountry = $selectedCountry[$input];



            //Save the country configuration

            $this->saveSessionVar(self::SELECTED_COUNTRY, $selectedCountry);



            //Navigate to select mode of delivery

            $this->SelectModeOfDeliveryPage();
        }

        /*

         * Function that display the last page with one one option to Go home

         * */

        function SelectModeOfDeliveryPage($warning = null) {

            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please select Delivery Mode

                $text = $this->loadText("SelectModeOfDelivery") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Get a list of all delivery modes

            $deliveryModes = $this->loadModesOfDelivery();



            //Log, test
    //        $this->logMessage("The list of Delivery modes are: ", $deliveryModes);
            //Format the list of the countries

            foreach ($deliveryModes as $key => $value) {

                //Append

                $text .= $key . ". " . $value["FullName"] . "\n";
            }



            //Format the largeText

            $text = $this->largeTextFormatting($text);



            //Display text

            $this->presentData($text, "FundsTransferPage", "processSelectDeliveryModePage");
        }

        //Function to process input from FinalPage function



        function loadModesOfDelivery() {

            //Get the delivery modes

            $deliveryModes = $this->getSessionVar(self::FUNDS_SERVICES);

            $deliveryModes = $deliveryModes["INTERAFFILIATE"]["ModeofDelivery"];



            //Load the delivery modes

            return $this->removeInActiveFormatRecords($deliveryModes);
        }

        /*

         * ******************* Utility functions *********************************

         * */





        /*

         * Function used to handle numerous text and format them into new pages

         * */

        function processSelectDeliveryModePage($input) {   //Check if its previous page
            if ($input == $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Forward the page

                $this->rewindTextFormatting();



                //Load the SelectModeOfDeliveryPage page

                $this->SelectModeOfDeliveryPage();

                return;
            } //Check if its next page
            else if ($input == $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Forward the page

                $this->forwardTextFormatting();



                //Load the SelectModeOfDelivery page

                $this->SelectModeOfDeliveryPage();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectModeOfDeliveryPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectModeOfDeliveryPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadModesOfDelivery())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectDestinationCountryPage($warning);

                return;
            }



            //Get the selected country

            $selectedDeliveryMode = $this->loadModesOfDelivery();

            $selectedDeliveryMode = $selectedDeliveryMode[$input];



            //Save the mode of delivery configuration

            $this->saveSessionVar(self::SELECTED_MODE_OF_DELIVERY, $selectedDeliveryMode);



            //Navigate to select mode of delivery

            $this->EnterAffiliateAccountNumber();
        }

        /*

         * Function to set the current index forward

         * */

        private function EnterAffiliateAccountNumber($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please enter account number:

                $text = $this->loadText("EnterAccount") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array(
                $this->getSessionVar(self::BACK_OPTION_CHARACTER),
                $this->getSessionVar(self::HOME_OPTION_CHARACTER)
            ));



            //Display text

            $this->presentData($text, $previous, "processEnterAffiliateAccountNumber");
        }

        /*

         * Function to set the current index forward

         * */

        function processEnterAffiliateAccountNumber($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: Empty input. Please enter account number

                $warning = $this->loadText("EmptyAccount");



                $this->EnterAffiliateAccountNumber($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid account number

                $warning = $this->loadText("InvalidAccount");



                $this->EnterAffiliateAccountNumber($warning);

                return;
            }

            /* <Payload>

              <serviceID>229</serviceID>

              <flavour>noFlavour</flavour>

              <MSISDN>234802000000</MSISDN>

              <pin>####</pin>

              <accountAlias>ecobank-acc0000</accountAlias>

              <accountID>290</accountID>

              <columnA>0000000000000</columnA> account number to query

              <columnB>EKE</columnB> affiliate code

              </Payload> */



            //Get the service ID

              $this->saveSessionVar(self::QUERY_SERVICES, $this->loadQueryServices());

              $serviceID = $this->getSessionVar(self::QUERY_SERVICES);

              $this->logMessage("Query services::::", $serviceID);

              $serviceID = $serviceID["2"]["ServiceID"];



            //Get the account alias

              $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

              $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the account ID

              $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

              $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //get the destination country affiliate code

              $affiliateCode = $this->getSessionVar(self::SELECTED_COUNTRY);

              $affiliateCode = $affiliateCode["AffiliateCode"];



            //Process the airtime request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "MSISDN" => $this->_msisdn,
                "accountID" => $accountID,
                "columnB" => $affiliateCode,
                "columnA" => $input
            );



              $response = $this->synchronousProcessing($payload);

              $this->logMessage("Response from wallet: " . json_encode($response));



            if ($response[self::DATA][self::WALLET_DATA]['STATUS_CODE'] == 1) {//success from wallet.

                /*

                 * accountInformation: michael

                 */

                //send request to wallet

                $accNameString = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

                $accountName = explode('accountName: ', $accNameString);

                $this->logMessage("Received account name: ", $accountName);
            } else {

                //Get the data

                $text = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

                $this->presentData($text, "EnterAccountNumber", null);

                return;
            }





            //Save the account number

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT, $input);



            //Save the account name

            $this->saveSessionVar(self::SELECTED_FT_RECIPIENT_NAME, $accountName[1]);



            //Log

            $this->logMessage("The entered recipient account number is: ", $input);



            //Navigate to select amount to be send

            $this->SelectTransferReasonPage();
        }

        /*

         * Function to reset the current index to the start

         * */

        function loadQueryServices() {

            //Load the affilaite countries

            return $this->removeInActiveFormatRecords($this->getSessionVar(self::QUERY_SERVICES));
        }

        /*

         * Function thats load the services and removes inactive records

         * */

        function SelectTransferReasonPage($warning = null) {

            //Check if the warning has been set

            if (empty($warning)) {

                //Load text
                //Actual text: Please select Transfer Reason

                $text = $this->loadText("SelectTransferReason") . "\n";
            } else {

                //Set text

                $text = $warning . "\n";
            }



            //Get a list of all transfer reasons

            $transferReasons = $this->loadTransferReasons();



            //Log, test
    //        $this->logMessage("The list of Delivery modes are: ", $transferReasons);
            //Format the list of the countries

            foreach ($transferReasons as $key => $value) {

                //Append

                $text .= $key . ". " . $value["FullName"] . "\n";
            }



            //Format the largeText

            $text = $this->largeTextFormatting($text);



            //Display text

            $this->presentData($text, "FundsTransferPage", "processSelectTransferReasonPage");
        }

        /*

         * Function that load the currencies

         *

         * */

        function loadTransferReasons() {

            //Get the list of transfer reasons

            $transferReasons = $this->getSessionVar(self::FUNDS_SERVICES);

            $transferReasons = $transferReasons["INTERAFFILIATE"]["TransferReasons"];



            //Load the transfer reasons

            return $this->removeInActiveFormatRecords($transferReasons);
        }

        /*

         * Function that loads a list of the supported MNOs for airtime transactions

         * */

        function processSelectTransferReasonPage($input) {   //Check if its previous page
            if ($input == $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Forward the page

                $this->rewindTextFormatting();



                //Load the SelectTransferReasonPage page

                $this->SelectTransferReasonPage();

                return;
            } //Check if its next page
            else if ($input == $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Forward the page

                $this->forwardTextFormatting();



                //Load the SelectTransferReason page

                $this->SelectTransferReasonPage();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectTransferReasonPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectTransferReasonPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadTransferReasons())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                //Reset the page

                $this->resetTextFormatting();



                $this->SelectTransferReasonPage($warning);

                return;
            }



            //Get the selected country

            $selectedTransferReason = $this->loadTransferReasons();

            $selectedTransferReason = $selectedTransferReason[$input];



            if ($selectedTransferReason == "Other") {

                //Log

                $this->logMessage("user select other as transfer reason.");



                //Navigate to custom reason

                $this->EnterCustomTransferReason();

                return;
            }



            //Get the country configuration

            $this->saveSessionVar(self::SELECTED_TRANSFER_REASON, $selectedTransferReason);



            //Navigate to select amount

            $this->SelectInterAffiliateAmountToSend();
        }

        /*

         * Function to load the airtime presets

         * */

        function EnterCustomTransferReason($warning = null) {

            //Log

            $this->logMessage("Hit entering custom transfer reason.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please enter transfer reason

                $text = $this->loadText("EnterTransferReason") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "SelectTransferReasonPage", "processEnterCustomTransferReason");
        }

        /*

         * Function to load the money presets

         * */

        function SelectInterAffiliateAmountToSend($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Log

            $this->logMessage("Hit select money FT menu getting the presets money list.");



            //Get the airtime presets

            $moneyPresets = $this->loadMoneyFTPPresets();



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please select an amount

                $text = $this->loadText("SelectAmount") . "\n";
            }



            //Create the format string

            foreach ($moneyPresets as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add the option to select the other number

            $text .= (count($moneyPresets) + 1) . ". " . $this->loadText("EnterOtherAmount") . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display data

            $this->presentData($text, $previous, "processSelectInterAffiliateAmountToSend");
        }

        /*

         * Function to load the FT services

         * */

        function processEnterCustomTransferReason($input) {



            //Check if the input is zero

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is 99
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyAmount");



                $this->SelectTransferReasonPage($warning);

                return;
            }





            //Save the preset

            $this->saveSessionVar(self::SELECTED_TRANSFER_REASON, $input);



            //Navigate to Select amount page

            $this->SelectInterAffiliateAmountToSend();
        }

        /*

         * Function to load the billers

         * */

        function processSelectInterAffiliateAmountToSend($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectInterAffiliateAmountToSend($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectInterAffiliateAmountToSend($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadMoneyFTPPresets()) + 1 && !in_array($input, array_keys($this->loadMoneyFTPPresets()))
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



            $this->SelectInterAffiliateAmountToSend($warning);

            return;
        }



            //Get the custom input text

        $customInputID = count($this->loadMoneyFTPPresets()) + 1;



            //Switch the statement

        switch ($input) {

                //Go to custom enter amount

            case $customInputID:

            $this->EnterInterAffiliateCustomAmountIAFT();

            return;

                //One of the presets we selected

            default:

                    //Get the custom preset

            $amountPreset = $this->loadMoneyFTPPresets();

            $amountPreset = $amountPreset[$input];



                    //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $amountPreset);



                    //Navigate to DetailsValidation page

            $this->DetailsValidationMoneyPageIAFT(null, "SelectAmountToSend");

            break;
        }
    }

        /*

         * Function to load the FTP money presets

         * */

        function EnterInterAffiliateCustomAmountIAFT($warning = null) {

            //Log

            $this->logMessage("Hit entering custom amount.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n";
            } else {

                //Set the text to be empty
                //Actual text: Please enter amount

                $text = $this->loadText("EnterAmount") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            $this->presentData($text, "SelectInterAffiliateAmountToSend", "processInterAffiliateEnterCustomAmount");
        }

        /*

         * Function to load the checkbook leaves

         * */

        function DetailsValidationMoneyPageIAFT($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }





            //Get the service ID

            $this->saveSessionVar(self::QUERY_SERVICES, $this->loadQueryServices());

            $serviceID = $this->getSessionVar(self::QUERY_SERVICES);

            $serviceID = $serviceID["3"]["ServiceID"];



            //Get the amount

            $amount = $this->getSessionVar(self::SELECTED_AMOUNT);



            //Get the accountAlias

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Get the accountID

            $selectedAccountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountID = $selectedAccountID[self::CBS_ACCOUNT_ID];



            //Get the destination country

            $destinationAffiliateCode = $this->getSessionVar(self::SELECTED_COUNTRY);

            $destinationAffiliateCode = $destinationAffiliateCode["AffiliateCode"];



            //Get the mode of delivery

            $deliveryMode = $this->getSessionVar(self::SELECTED_MODE_OF_DELIVERY);

            $deliveryMode = $deliveryMode["FullName"];



            /*

              <Payload>

              <serviceID>225</serviceID>

              <flavour>noFlavour</flavour>

              <MSISDN>224631751556</MSISDN>

              <accountAlias>Group Test Account</accountAlias>

              <pin>####</pin>

              <amount>1</amount>

              <columnA>EKE</columnA>

              <columnB>ACCOUNT</columnB>

              <columnE>1</columnE>

              <columnC>0010345025380301</columnC>

              <accountID>531</accountID>

              </Payload>

             */



            //Process the Interaffiliate request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $selectedAccountAlias,
                "MSISDN" => $this->_msisdn,
                "accountID" => $selectedAccountID,
                "amount" => $amount,
                "columnA" => $destinationAffiliateCode,
                "columnB" => $deliveryMode,
                "columnC" => $this->getSessionVar(self::SELECTED_FT_RECIPIENT),
                "columnE" => $amount
            );



              $response = $this->synchronousProcessing($payload);

              $this->logMessage("Response from wallet: " . json_encode($response));



            if ($response[self::DATA][self::WALLET_DATA]['STATUS_CODE'] == 1) {//success from wallet.

                /**

                 * validationResponse: COUNTRY_NAME : Kenya

                 * AFFILIATE_CODE : EKE ## COUNTRY_NAME: Uganda

                 * AFFILIATE_CODE : EUG ##

                 */

                //extract the countries response

                $destCountriesString = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

                $strWithoutLines = str_replace("\n", "|", $destCountriesString);

                $this->logMessage("String after removing the new lines: " . $strWithoutLines);



                $strWithoutLines = trim($strWithoutLines);



                //build an array with the responses

                $lookUpDetails = explode('iftValidationDetails: ', $strWithoutLines);



                $resultMSR = array();

                $count = 0;



                //get the multiple object

                $lookups = explode("##", $lookUpDetails[1]);

                $this->logMessage("Look up details arrays: ", $lookups);



                //extract the details for each function

                for ($i = 0; $i < count($lookups); $i++) {

                    $deposits = $lookups[$i];



                    //extract the details element and break it into array elements

                    $lookUpArray = explode('|', $deposits);



                    $this->logMessage("Look up details: ", $lookUpArray);



                    //Here we get the details and make then an associative array
                    //The array should already ne formatted into the proper key value pairs

                    $lookUpDetailsAssoc = array();

                    array_walk($lookUpArray, function ($val, $key) use (&$lookUpDetailsAssoc) {

                        list($key, $value) = explode(' : ', $val);

                        $lookUpDetailsAssoc[$key] = $value;
                    });



                    $this->logMessage("Received associative array: ", $lookUpDetailsAssoc);



                    $resultMSR[$count] = $lookUpDetailsAssoc;

                    $count++;
                }



                //format the array

                $finalLookUpArray = array();

                foreach ($resultMSR as $key => $val) {

                    array_push($finalLookUpArray, $val);
                }



                $this->logMessage("Final associative array: ", $finalLookUpArray);



    //			$this->logMessage("Final associative array: ", $finalLookUpArray);

                $sendCurrency = $finalLookUpArray[0]["SEND_CURRENCY"];

                $sendAmount = $finalLookUpArray[0]["SEND_AMOUNT"];

                $recipient = $finalLookUpArray[0]["RECEIPIENT_NAME"];

                $recipientAccount = $finalLookUpArray[0]["RECEIPIENT_ACCOUNT"];

                $totalCharge = $finalLookUpArray[0]["TOTAL_CHARGE"];

                $totalDebit = $finalLookUpArray[0]["TOTAL_AMOUT_TO_DEBIT"];

    //$sendCurrency = $finalLookUpArray[0]["SEND_CURRENCY"];
    //Set the text
    //Actual text: You are sending ^CURRENCY^ ^AMOUNT^ to ^RECIPIENT^ To ^RECIPIENT_ACCOUNTNUMBER^.
    // Charge is ^CURRENCY^ ^TOTAL_CHARGE^, Total Debit is ^CURRENCY^ ^TOTAL_DEBIT^.\nContinue \n1. Yes \n2. No

                $text .= $this->loadText("ValidateIAFTP", array(
                    $sendCurrency, $sendAmount, $recipient, $recipientAccount,
                    $sendCurrency, $totalCharge, $sendCurrency, $totalDebit
                )) . "\n";

                $this->logMessage("FeeAndAmountValidation Text::: " . $text);
            } else {



                //Get the data

                $text = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];

                $this->presentData($text, "FundsTransferPage", null);

                return;
            }

            //Set the text
            //Actual text: Are You Sure You Want To Send ^CURRENCY^ ^AMOUNT^ Worth Of Money, With Account ^ACCOUNT_ALIAS^ To ^RECIPIENT^.\n1. Yes \n2. No
            //$text .= $this->loadText("ValidateFTP", array($this->getSessionVar(self::CURRENCY),
            //      $amount, $selectedAccountAlias,
            //    $this->getSessionVar(self::SELECTED_FT_RECIPIENT))) . "\n";
            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationPageIAFT");
        }

        /*

         * Function to load the supported RTGS Banks

         * */

        function processInterAffiliateEnterCustomAmount($input) {

            //Minimum limit

            $minimumLimit = $this->getSessionVar(self::SERVICES);

            $minimumLimit = $minimumLimit["AIRTIME"]["MinimumLimit"];

            //Maximum limit

            $maximumLimit = $this->getSessionVar(self::SERVICES);

            $maximumLimit = $maximumLimit["AIRTIME"]["MaximumLimit"];



            //Check if the input is zero

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is 99
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyAmount");



                $this->EnterInterAffiliateCustomAmountIAFT($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Please enter a valid number, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("InvalidAmount", array($minimumLimit, $maximumLimit));



                $this->EnterInterAffiliateCustomAmountIAFT($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($minimumLimit > $input || $maximumLimit < $input) {

                //Warning text
                //Actual Text: Please enter a valid amount, should be between ^MIN_AMOUNT^ and ^MAX_AMOUNT^

                $warning = $this->loadText("MinMaxAmount", array($minimumLimit, $maximumLimit));



                $this->EnterInterAffiliateCustomAmountIAFT($warning);

                return;
            }



            //Save the preset

            $this->saveSessionVar(self::SELECTED_AMOUNT, $input);



            //Navigate to DetailsValidation page

            $this->DetailsValidationMoneyPageIAFT(null, "EnterInterAffiliateCustomAmount");
        }

        /*

         * Function to load the transfer reasons

         * */

        function processDetailsValidationPageIAFT($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationMoneyPageIAFT($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationMoneyPageIAFT($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationMoneyPageIAFT($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing IAFT from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing Interaffiliate request...");



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::FUNDS_SERVICES);

            $serviceID = $serviceID["INTERAFFILIATE"]["ServiceID"];



            //Get account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //Get the destination country

            $destinationAffiliateCode = $this->getSessionVar(self::SELECTED_COUNTRY);

            $destinationAffiliateCode = $destinationAffiliateCode["AffiliateCode"];



            //Get the mode of delivery

            $deliveryMode = $this->getSessionVar(self::SELECTED_MODE_OF_DELIVERY);

            $deliveryMode = $deliveryMode["FullName"];



            //extract the details we need for the cash transfer

            $requestDetails = array(
                "AMOUNT" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "DESTINATION_ACCOUNT" => $this->getSessionVar(self::SELECTED_FT_RECIPIENT),
                "BENEFICIARY_NAME" => $this->getSessionVar(self::SELECTED_FT_RECIPIENT_NAME),
                "TRANSFER_REASON" => $this->getSessionVar(self::SELECTED_TRANSFER_REASON),
            );

            //Process the Interaffiliate request

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "MSISDN" => $this->_msisdn,
                "accountID" => $accountID,
                "amount" => $this->getSessionVar(self::SELECTED_AMOUNT),
                "columnA" => $destinationAffiliateCode,
                "columnB" => json_encode($requestDetails),
                "columnC" => $deliveryMode
            );



            //Call wallet and get the response

            $response = $this->synchronousProcessing($payload);



            $this->logMessage("The response received is: ", $response);



            $text = $response[self::DATA][self::WALLET_DATA][self::WALLET_MESSAGE];



            //Display message

            $this->FinalPage($text);
        }

        /*

         * Function to load the supported delivery modes

         * */

        function processForexRatesPage($input) {



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->ForexRatesPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->ForexRatesPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count((array) $this->loadCurrencies())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->ForexRatesPage($warning);

                return;
            }





            //Get the currency

            $currency = $this->loadCurrencies();

            $currency = $currency[$input];



            //Get the service ID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["FOREX"]["ServiceID"];



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][1];



            //Log

            $this->logMessage("The account data is: ", $accountData);



            //Get the account alias
    //		$accountAlias = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);

            $accountAlias = $accountData[self::ACCOUNT_ALIAS]; //$accountAlias[self::ACCOUNT_ALIAS];
            //Get the account ID
    //		$accountID = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);

            $accountID = $accountData[self::CBS_ACCOUNT_ID]; //$accountID[self::CBS_ACCOUNT_ID];
            //Generate the payload to be sent

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "columnA" => $currency
            );



            //Call wallet and get the response

            $response = $this->synchronousProcessing($payload);



            //Check if the response was successful\

            if (empty($response[self::SUCCESS])) {

                //Log, error

                $this->logMessage("Unable to process forex rates, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully got the forex rate, the data received is: ", $response[self::DATA]);



            //Get the wallet data

            $walletData = $response[self::DATA][self::WALLET_DATA];



            //Log, test

            $this->logMessage("The wallet data is: ", $walletData);



            //Log, test

            $this->logMessage("The message is: ", $walletData[self::WALLET_MESSAGE]);



            //Get the data

            $text = $walletData[self::WALLET_MESSAGE];



            if ($walletData["STATUS_CODE"] == 1) {



                $strWithoutLines = str_replace("\n", "|", $walletData[self::WALLET_MESSAGE]);

                $strWithoutLines = trim($strWithoutLines);

                //build an array with the responses

                $forexRatesResults = explode('forexRates: ', $strWithoutLines);



                $resultMSR = array();

                $count = 0;

                //$refId = !isset($walletResponse['DATA']['MESSAGE_DATA']['TRANSACTION_ID'][0]) ?
                //  NULL : $walletResponse['DATA']['MESSAGE_DATA']['TRANSACTION_ID'][0];
                //get the multiple object

                $forexRates = explode("##", $forexRatesResults[1]);



                $this->logMessage("Forex rates array " . json_encode($forexRates));





                //extract the details for each function

                for ($i = 0; $i < (count($forexRates)); $i++) {

                    $activeCardResult = $forexRates[$i];



                    //extract the details element and break it into array elements

                    $activeCardArray = explode('|', $activeCardResult);



                    //Here we get the details and make then an associative array

                    $activeCardsAssoc = array();

                    array_walk($activeCardArray, function ($val, $key) use (&$activeCardsAssoc) {

                        list($key, $value) = explode(' : ', $val);

                        $activeCardsAssoc[$key] = $value;
                    });

                    /**

                     * extract the forex rates params

                     */
                    $forexRatesAssoc = array(
                        "BASE_CURRENCY" => $activeCardsAssoc['baseCurrency'],
                        "QUOTE_CURRENCY" => $activeCardsAssoc['quoteCurrency'],
                        "BUY_RATE" => $activeCardsAssoc['buyRate'],
                        "MID_RATE" => $activeCardsAssoc['midRate'],
                        "SELL_RATE" => $activeCardsAssoc['sellRate'],
                    );



                    $resultMSR[$count] = $forexRatesAssoc;

                    $count++;
                }



                $forexRatesResults = array();

                foreach ($resultMSR as $key => $val) {

                    array_push($forexRatesResults, $val);
                }



                $this->logMessage("Successfully parsed forex rates response");



                $this->logMessage("Formatted forex rates array:  " . json_encode($forexRatesResults));



                $text = "";

                for ($i = 0; $i < (count($forexRatesResults)); $i++) {

                    if ($currency == $forexRatesResults[$i]["QUOTE_CURRENCY"]) {

                        $text .= $forexRatesResults[$i]["BASE_CURRENCY"] . " to " . $forexRatesResults[$i]["QUOTE_CURRENCY"] . "\n";

                        $text .= " Buy Rate: " . $forexRatesResults[$i]["BUY_RATE"] . "\n";

                        $text .= " Mid Rate: " . $forexRatesResults[$i]["MID_RATE"] . "\n";

                        $text .= " Sell Rate: " . $forexRatesResults[$i]["SELL_RATE"];
                    }
                }
            }

            //Display message

            $this->FinalPage($text, null, "ForexRatesPage");
        }

        /*

         * Function to load the affiliate countries

         * */

        function processFullStatementPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->FullStatementPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->FullStatementPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array_keys($customerAccounts))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->FullStatementPage($warning);

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the customer data

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $accountData);



            //Got the customer validation Page

            $this->EnterStartDateMenu();
        }

        /*

         * Function to load the affiliate countries

         * */

        function EnterStartDateMenu($warning = null) {

            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please enter Start Date (ddmmyyyy)

                $text = $this->loadText("EnterStartDate", array($this->lastMonth())) . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "FullStatementPage", "processEnterStartDateMenu");
        }

        /*

         * Function to load the Checkbook services

         * */

        function lastMonth() {

            //Get the current date

            $currentDate = date("dmY");



            //Explode to get the month

            $day = substr($currentDate, 0, 2);

            $month = substr($currentDate, 2, 2);

            $year = substr($currentDate, 4, 4);



            //Deduct one

            $month -= 1;



            //Check if the month is zero

            if ($month == 0) {

                $month = 12;

                $year -= 1;
            }



            //Get the last month's date

            $lastMonthDate = date("dmY", mktime(null, null, null, $month, $day, $year));



            //Log, test

            $this->logMessage("The current date is: " . $currentDate . " and the last month date is: ", $lastMonthDate);



            //Create the date again

            return $lastMonthDate;
        }

        /*

         * Function to fetch all the user accounts and presents in a better format

         * */

        function processEnterStartDateMenu($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterStartDateMenu($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input) || !$this->isValidDate($input) || !$this->isValidStartDate($input)) {

                //Get last month
                //Warning text
                //Actual Text: Please enter valid start date (ddmmyyyy) Eg ^CURRENT_TIME^.The date should not be after today

                $warning = $this->loadText("InvalidStartDate", array($this->lastMonth()));



                $this->EnterStartDateMenu($warning);

                return;
            }








            //Save the end date

            $this->saveSessionVar(self::START_DATE, $input);



            //Proceed to end date menu

            $this->EnterEndDateMenu();
        }

        /*

         * Functions to service panama request

         * */

        function isValidDate($date) {

            //Check if the date is valid

            if (strlen($date) != 8) {

                //Log, test

                $this->logMessage("The date passed in invalid not 8 digits", null, self::LOG_LEVEL_ERROR);



                return false;
            }



            //Get the times

            $day = substr($date, 0, 2);

            $month = substr($date, 2, 2);

            $year = substr($date, 4, 4);



            //Check date

            return checkdate($month, $day, $year);
        }

        /*

         * Function to handle multiple accounts (Panama)

         * */

        function isValidStartDate($date) {

            //Check if the date is valid

            if (!$this->isValidDate($date)) {

                return false;
            }



            //Get the current time

            $today = date('m/d/Y');



            //Get the times

            $day = substr($date, 0, 2);

            $month = substr($date, 2, 2);

            $year = substr($date, 4, 4);



            //Date passed

            $startDate = $month . "/" . $day . "/" . $year;



            //Log

            $this->logMessage("The start date is: {$startDate}, strtime:" . strtotime($startDate) . " and the today's is: {$today} strtime:" . strtotime($today));



            //Return the comparison

            return strtotime($today) > strtotime($startDate);
        }

        function EnterEndDateMenu($warning = null) {

            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please enter Start Date (ddmmyyyy)

                $text = $this->loadText("EnterEndDate", array(date('dmY'))) . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display text

            $this->presentData($text, "FullStatementPage", "processEnterEndDateMenu");
        }

        /*

         * Function to fetch all bills and presents in a better format

         * */

        function processEnterEndDateMenu($input) {

            $this->logMessage("**************************processing end date", $input);
            //Get the start date

            $startDate = $this->getSessionVar(self::START_DATE);
            $this->logMessage("retrieved stored start date for comparison=", $startDate);



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterEndDateMenu($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input) || !$this->isValidEndDate($input, $startDate)) {

                //Warning text
                //Actual Text: Please enter valid end date (ddmmyyyy) Eg ^CURRENT_TIME^.The date should not be before today

                $warning = $this->loadText("InvalidEndDate", array(date('dmY')));



                $this->EnterEndDateMenu($warning);

                return;
            }










            //Save the end date

            $this->saveSessionVar(self::END_DATE, $input);



            //Enter the email address

            $this->EnterEmailAddressMenu();
        }

    //converts date formats. xmass 25122017 becomes 2017-12-25
        function convertDate($dmyFormat) {
            $this->logMessage("###################converting date");
            $day = substr($dmyFormat, 0, 2);

            $month = substr($dmyFormat, 2, 2);

            $year = substr($dmyFormat, 4, 4);
            $input = "$year-$month-$day";
            $this->logMessage("converted Date is ", $input);
            return $input;
        }

        /*

         * Function that fetches customers data from wallet

         * */



        /*

         * Menu to enter the email address

         * */

        private function EnterEmailAddressMenu($warning = null) {

            //Log

            $this->logMessage("In the function: " . __FUNCTION__);



            //Check if any warning was set

            if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Please Enter Your Email Address:

                $text = $this->loadText("EnterEmailAddress") . "\n";
            } else {

                $text = $warning . "\n";
            }



            //Process data

            $this->presentData($text, "EnterEndDateMenu", "processEnterEmailAddressMenu");
        }

        //function that process the input from the EnterEmailAddressMenu

        function processEnterEmailAddressMenu($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterEmailAddressMenu($warning);

                return;
            }



            //Check if the input is not a number
            else if (!$this->isValidEmail($input)) {

                //Warning text
                //Actual Text: Invalid Email Address. Please Enter A Valid Email Address

                $warning = $this->loadText("InvalidEmailAddress");



                $this->EnterEmailAddressMenu($warning);

                return;
            }



            //Save the email address

            $this->saveSessionVar(self::EMAIL_ADDRESS, $input);



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["FULLSTATEMENT"]["ServiceID"];



            //Get the account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            /*

             * Payload

             *

             * <Payload><serviceID>12</serviceID><flavour>noFlavour</flavour><pin>313233343536373831323334353637380e987f37d375c9d85bffee51a3d710d204824b95eb8bdda1b8a7cbcbc65777fe9c670855cd2e854458047533bf</pin><accountAlias>DIRECT CURRENT AC</accountAlias><columnA>2016-05-19</columnA><columnB>2017-02-02</columnB><columnC>nderitumaxwell@gmail.com</columnC><accountID>34368</accountID></Payload>

             * */

            //Create the payload

            $start = $this->convertDate($this->getSessionVar(self::START_DATE));
            $end = $this->convertDate($this->getSessionVar(self::END_DATE));
            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "columnA" => $start,
                "columnB" => $end,
                "columnC" => $this->getSessionVar(self::EMAIL_ADDRESS)
            );



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted full statement request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        function isValidEndDate($endDate, $startDate) {

            //Check if the date is valid

            if (!$this->isValidDate($endDate)) {

                return false;
            }



            //Check if the date is valid

            if (!$this->isValidDate($startDate)) {

                return false;
            }



            //Get the current time

            $today = date('m/d/Y');



            //Get the times

            $day = substr($endDate, 0, 2);

            $month = substr($endDate, 2, 2);

            $year = substr($endDate, 4, 4);



            //Date passed

            $endDate = $month . "/" . $day . "/" . $year;



            //Get the times

            $day = substr($startDate, 0, 2);

            $month = substr($startDate, 2, 2);

            $year = substr($startDate, 4, 4);



            //Date passed

            $startDate = $month . "/" . $day . "/" . $year;



            //Log

            $this->logMessage("The start date is: {$startDate}, strtime:" . strtotime($startDate) . " and the end date is: {$endDate} strtime:" . strtotime($endDate));



            //Return the comparison

            return ((strtotime($endDate) > strtotime($startDate)) && (strtotime($today) >= strtotime($endDate)));
        }

        /*

         * Function that fetches bills from hub

         * */

        function processMiniStatementPage($input) {

            //Get customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->MiniStatementPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->MiniStatementPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->MiniStatementPage($warning);

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the customer data

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $accountData);



            //Got the customer validation Page

            $this->ConfirmMiniStatementPage();
        }

        /*

         * Function that handles displaying of the text setting the next page and the previus page

         * */

        function ConfirmMiniStatementPage($warning = null) {

            //Log

            $this->logMessage("Entered confirm mini statement... ");



            //Get the account number and the alias

            $customerAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $customerAccountAlias = $customerAccountAlias[self::ACCOUNT_ALIAS];



            $customerAccountNumber = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $customerAccountNumber = $customerAccountNumber[self::ACCOUNT_NUMBER];



            //Customer text
            //$customerText = $customerAccountAlias . " " . $customerAccountNumber;

            $customerText = $customerAccountAlias;



            //Set the text

            $text = "";



            if (!empty($warning)) {

                //Set the text

                $text = "\n" . $warning . "\n";
            }



            //Set the text
            //Actual Text: Please note mini statement will display the last five transactions on your account ^ACCOUNT^ only. Do you wish to proceed? ^\n^ 1. Yes ^\n^ 2. No

            $text .= $this->loadText("ConfirmMiniStat", array($customerText)) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Format the large text

            $text = $this->largeTextFormatting($text, ".");



            //Display the text

            $this->presentData($text, "MiniStatementPage", "processConfirmMiniStatementPage");
        }

        /*

         * Function that navigates to the previous function

         * */

        function processConfirmMiniStatementPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input is the next character
            else if ($input === $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {

                //Go to the next page segment

                $this->forwardTextFormatting();

                $this->ConfirmMiniStatementPage();

                return;
            } //Check if the input is previous character
            else if ($input === $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {

                //Go to the previous page segment

                $this->rewindTextFormatting();



                $this->ConfirmMiniStatementPage();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                //Reset the current index

                $this->resetTextFormatting();



                $this->ConfirmMiniStatementPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input.

                $warning = $this->loadText("NonNumericInput");



                //Reset the current index

                $this->resetTextFormatting();



                $this->ConfirmMiniStatementPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                //Reset the current index

                $this->resetTextFormatting();



                $this->ConfirmMiniStatementPage($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Getting the mini statement from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;

                default:

                $this->ConfirmMiniStatementPage();

                return;
            }



            //Set the service ID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["MINISTATEMENT"]["ServiceID"];



            //Get the account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get the account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            //Create the payload to be sent

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID
            );



            //Call wallet and get the response

            $response = $this->synchronousProcessing($payload);



            //Check if the response was successful\

            if (empty($response[self::SUCCESS])) {

                //Log, error

                $this->logMessage("Unable to process forex rates, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully got the mini statement, the data received is: ", $response[self::DATA]);



            //Get the wallet data

            $walletData = $response[self::DATA][self::WALLET_DATA];



            //Log, test

            $this->logMessage("The wallet data is: ", $walletData);



            //Log, test

            $this->logMessage("The message is: ", $walletData[self::WALLET_MESSAGE]);



            //Get the data

            $text = $walletData[self::WALLET_MESSAGE];



            if ($walletData["STATUS_CODE"] == 1) {



                $strWithoutLines = str_replace("\n", "|", $text);

                $strWithoutLines = trim($strWithoutLines);

                $miniStatement = explode('miniStatement: ', $strWithoutLines);

                $resultMSR = array();

                $count = 0;

                $refId = !isset($walletData['TRANSACTION_ID'][0]) ?
                NULL : $walletData['TRANSACTION_ID'][0];

                $miniStmts = explode("##", $miniStatement[1]);

                $this->logMessage("Mini statement response: " . json_encode($miniStmts));

                for ($i = 0; $i < (count($miniStmts)); $i++) {

                    $stmt = $miniStmts[$i];



                    //extract the details element and break it into array elements

                    $miniStmtArray = explode('|', $stmt);



                    //Here we get the details and make then an associative array

                    $miniStmtAssoc = array();

                    array_walk($miniStmtArray, function ($val, $key) use (&$miniStmtAssoc) {

                        list($key, $value) = explode(' : ', $val);

                        $miniStmtAssoc[$key] = $value;
                    });



                    $miniStDetails = array(
                        "TRANSACTION_TYPE" => $miniStmtAssoc['trxType'],
                        "TRANSACTION_CCY" => $miniStmtAssoc['trxCcy'],
                        "TRANSACTION_AMOUNT" => $miniStmtAssoc['trxAmount'],
                        "TRANSACTION_DATE" => $miniStmtAssoc['trxDate'],
                        "TRANSACTION_NARRATION" => $miniStmtAssoc['trxNarration'],
                    );



                    $resultMSR[$count] = $miniStDetails;

                    $count++;
                }



                $miniStmtRs = array();

                foreach ($resultMSR as $key => $val) {

                    array_push($miniStmtRs, $val);
                }



                $text = "";

                $this->logMessage("Formatted mini statement result: " . json_encode($miniStmtRs));

                for ($i = 0; $i < (count($miniStmtRs)); $i++) {

                    $text .= $miniStmtRs[$i]["TRANSACTION_TYPE"] . "," . $miniStmtRs[$i]["TRANSACTION_CCY"];

                    $text .= " " . $miniStmtRs[$i]["TRANSACTION_AMOUNT"] . " on " . $miniStmtRs[$i]["TRANSACTION_DATE"];

                    $text .= " for " . $miniStmtRs[$i]["TRANSACTION_NARRATION"] . "\n";
                }



                //		$text = $this->largeTextFormatting($text, "\n");
    //
    //			$this->presentData($text, "processConfirmMiniStatementPage", null);
                //                       return;
            }



            //Display message

            $this->FinalPage($text);
        }

        /*

         * Function that calls the start page

         * It invalidates the menu data and begins as a new session

         * */

        function processBalanceEnquiryPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->BalanceEnquiryPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->BalanceEnquiryPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->BalanceEnquiryPage($warning);

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Get the service ID

            $serviceID = $this->getSessionVar(self::SERVICES);

            $serviceID = $serviceID["BALANCEENQUIRY"]["ServiceID"];



            //Process the transaction

            $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "self",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountData[self::ACCOUNT_ALIAS],
                "accountID" => $accountData[self::CBS_ACCOUNT_ID]
            );



            //Call wallet and get the response

            $response = $this->synchronousProcessing($payload);



            //Check if the response was successful\

            if (empty($response[self::SUCCESS])) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully got the balance, the data received is: ", $response[self::DATA]);



            //Get the wallet data

            $walletData = $response[self::DATA][self::WALLET_DATA];



            //Log, test

            $this->logMessage("The wallet data is: ", $walletData);



            //Log, test

            $this->logMessage("The message is: ", $walletData[self::WALLET_MESSAGE]);



            //Get the data

            $text = $walletData[self::WALLET_MESSAGE];



            //Display message
            //$this->FinalPage($text);



            $this->saveSessionVar(self::PREVIOUS_PAGE, $previousPage);





            $text .= $this->loadText("GoHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER)));



            //Display message

            $this->presentData($text, $previousPage, "processFinalPage");
        }

        /*

         * Function that loads the configs

         * */

        function processCheckbookPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->CheckbookPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->CheckbookPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($this->loadCheckbookServices())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->CheckbookPage($warning);

                return;
            }



            //Get the Service Number

            $serviceNumber = $this->loadCheckbookServices();

            $serviceNumber = $serviceNumber[$input]["ServiceNumber"];



            //Check

            switch ($serviceNumber) {

                //Request checkbook page

                case 1:

                $this->CheckbookRequestPage();

                break;

                //Stop Checkbook page

                case 2:

                $this->StopCheckbookRequestPage();

                break;

                default:

                    //Load page again

                $this->CheckbookPage();

                break;
            }
        }

        /*

         * Function used for logging data purposes

         * */

        function CheckbookRequestPage($warning = null) {

            //Log

            $this->logMessage("Hit CheckbookRequestPage function.");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "HomePage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "CheckbookPage", "processCheckbookRequestPage");
        }

        /*

         * Customer function for logging data

         * */

        function StopCheckbookRequestPage($warning = null) {

            //Log

            $this->logMessage("Hit StopCheckbookRequestPage function.");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "CheckbookPage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "CheckbookPage", "processStopCheckbookRequestPage");
        }

        function processCheckbookRequestPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->CheckbookRequestPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->CheckbookRequestPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->CheckbookRequestPage($warning);

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the customer data

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $accountData);



            //Got the customer validation Page

            $this->SelectNumberLeaves();
        }

        /*

         * Function that removes records that are marked as inactive and rearranges it

         * */

        function SelectNumberLeaves($warning = null) {

            //Log

            $this->logMessage("Hit SelectNumberLeaves function.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("SelectNumberLeaves") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text:Please select number of leaves

                $text = $this->loadText("SelectNumberLeaves") . "\n";
            }



            //Load the leaves presets

            $leavesPreset = $this->loadLeavesPresets();



            //Create the format string

            foreach ($leavesPreset as $key => $value) {

                //Append the text

                $text .= $key . ". " . $value . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "CheckbookRequestPage", "processSelectNumberLeaves");
        }

        /*

         * Function that re formats the array to set 1 as the start index

         * */

        function loadLeavesPresets() {

            //Get the presets

            $presets = $this->getSessionVar(self::SERVICES);

            $presets = $presets["CHECKBOOK"]["Leaves"];



            //Explode the array and return it

            return $this->formatRecords(explode(",", $presets));
        }

        /*

         * Function for calling wallet synchronously

         *

         * */

        function processSelectNumberLeaves($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->SelectNumberLeaves($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->SelectNumberLeaves($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input != count($this->loadLeavesPresets()) && !in_array(
                $input, array_keys($this->loadLeavesPresets())
            )
        ) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->SelectNumberLeaves($warning);

                return;
            }



            //Get the custom preset

            $leavePresets = $this->loadLeavesPresets();

            $leavePresets = $leavePresets[$input];



            //Save the preset

            $this->saveSessionVar(self::SELECTED_LEAVE, $leavePresets);



            //Navigate to DetailsValidation page

            $this->DetailsValidationCheckbookRequest(null, "SelectNumberLeaves");
        }

        /*

         * Function for calling wallet asynchronously

         *

         * */

        function DetailsValidationCheckbookRequest($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the amount

            $leavePages = $this->getSessionVar(self::SELECTED_LEAVE);



            //Get the account

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Set the text
            //Actual text: Do You Wish To Request For A Cheque Book For Account ^ACCOUNT^ With ^LEAVES^ Leaves. \n1. Yes \n2. No

            $text .= $this->loadText("ConfirmCheckbookReq", array($selectedAccountAlias, $leavePages)) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationCheckbookRequest");
        }

        /*

         * Function used to encrypt the pin for Authentication to be used by wallet

         * */

        function processDetailsValidationCheckbookRequest($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationCheckbookRequest($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationCheckbookRequest($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationCheckbookRequest($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing checkbook request from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing checkbook request...");



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::CHECKBOOK_SERVICES);

            $serviceID = $serviceID["CHECKBOOKREQUEST"]["ServiceID"];



            //Get account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            /*

             * Sample payload

             *

             * "serviceID" => $this->getSessionVar("_SERVICEID"),

              "flavour" => "noFlavour",

              "pin" => $this->getSessionVar("encryptedPin"),

              "accountAlias" => $this->getSessionVar("_accountAlias"),

              "accountID" => $this->getSessionVar("_accountID"),

              "columnA" => "50"

             * */



            //Process the airtime request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "columnA" => $this->getSessionVar(self::SELECTED_LEAVE),
            );



            //Call wallet and get the response

              $response = $this->asynchronousProcessing($payload);



            //Log

              $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

              if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted airtime request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        /*

         * Function used to encrypt the pin for service requests to be used by wallet

         * */

        function processStopCheckbookRequestPage($input) {

            //Get the customer accounts

            $customerAccounts = $this->getCustomerData();

            $customerAccounts = $customerAccounts[self::DATA][self::CUSTOMER_ACCOUNTS];



            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->StopCheckbookRequestPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->StopCheckbookRequestPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->StopCheckbookRequestPage($warning);

                return;
            }



            //Set the chosen account

            $accountData = $this->getCustomerData();

            $accountData = $accountData[self::DATA][self::CUSTOMER_ACCOUNTS][$input];



            //Save the customer data

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $accountData);



            //Go to enter the check number page

            $this->EnterCheckNumberPage();
        }

        /*

         * Function to check if the date passed is a start date

         * */

        function EnterCheckNumberPage($warning = null) {

            //Log

            $this->logMessage("Hit EnterCheckNumberPage function.");



            //The text to displayed

            if (!empty($warning)) {

                //Set the warning

                $text = $warning . "\n" . $this->loadText("EnterCheckNumber") . "\n";
                ;
            } else {

                //Set the text to be empty
                //Actual text: Please enter the cheque number

                $text = $this->loadText("EnterCheckNumber") . "\n";
            }



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "StopCheckbookRequestPage", "processEnterCheckNumberPage");
        }

        /*

         * Check is the date passed is a valid end date

         * */

        function processEnterCheckNumberPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterCheckNumberPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->EnterCheckNumberPage($warning);

                return;
            }



            //Save the cheque number

            $this->saveSessionVar(self::SELECTED_CHEQUE_NUMBER, $input);



            //Navigate to DetailsValidation page

            $this->DetailsValidationStopCheckbookRequest(null, "EnterCheckNumberPage");
        }

        /*

         * Check is the date passed is a valid end date

         * */

        function DetailsValidationStopCheckbookRequest($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE . __FUNCTION__, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE . __FUNCTION__);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the account

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Set the text
            //Actual text: Do You Wish To Stop Cheque Book Request For Account ^ACCOUNT^. \n1. Yes \n2. No

            $text .= $this->loadText("ConfirmCheckbookStopReq", array($selectedAccountAlias)) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processDetailsValidationStopCheckbookRequest");
        }

        /*

         * Get the last month date

         * */

        function processDetailsValidationStopCheckbookRequest($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationStopCheckbookRequest($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationStopCheckbookRequest($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationStopCheckbookRequest($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing stop checkbook request from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Log

            $this->logMessage("Processing stop checkbook request...");



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::CHECKBOOK_SERVICES);

            $serviceID = $serviceID["STOPCHECKBOOK"]["ServiceID"];



            //Get account alias

            $accountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountAlias = $accountAlias[self::ACCOUNT_ALIAS];



            //Get account ID

            $accountID = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $accountID = $accountID[self::CBS_ACCOUNT_ID];



            /*

             * Sample payload

             *

             * "serviceID" => $this->getSessionVar("_SERVICEID"),

              "flavour" => "noFlavour",

              "pin" => $this->getSessionVar("encryptedPin"),

              "accountAlias" => $this->getSessionVar("_accountAlias"),

              "accountID" => $this->getSessionVar("_accountID"),

              "columnA" => "50"

             * */



            //Process the airtime request

              $payload = array(
                "serviceID" => $serviceID,
                "flavour" => "noFlavour",
                "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),
                "accountAlias" => $accountAlias,
                "accountID" => $accountID,
                "columnA" => $this->getSessionVar(self::SELECTED_CHEQUE_NUMBER),
            );



            //Call wallet and get the response

              $response = $this->asynchronousProcessing($payload);



            //Log

              $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

              if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted stop check request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

        /*

         * Function that checks if the number provided is valid

         * */


        /*
          function processFinalPage($input)

          {

          if ($input == $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

          //Go Back

          $this->navigateBack();

          return;

          } else {

          //Set the warning

          $text = $this->loadText("InvalidInput") . "\n";



          //Get the text saved

          $text .= (String)$this->getSessionVar(self::FINAL_TEXT);



          //Get the previous page

          $previousPage = $this->getSessionVar(self::PREVIOUS_PAGE);



          //Load final page

          $this->FinalPage($text, true, $previousPage);

          }

          }

         */

          function processFinalPage($input) {
            //Check if the input is home character
            if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {
                //Reset the text formatting
                $this->resetTextFormatting();

                //Go Home
                $this->GoHome();
                return;
            } //Check if its previous page
            else if ($input == $this->getSessionVar(self::PREV_PAGE_CHARACTER)) {
                //Forward the page
                $this->rewindTextFormatting();

                $this->FinalPage();
                return;
            } //Check if its next page
            else if ($input == $this->getSessionVar(self::NEXT_PAGE_CHARACTER)) {
                //Forward the page
                $this->forwardTextFormatting();

                $this->FinalPage();
                return;
            } else {
                //Load final page. Basically do nothing
                $this->FinalPage();
            }
        }

        /*

         * function to check if the mobile number entered is a valid phone number

         * */

        function BillPaymentsPage($warning = null) {

            //Log

            $this->logMessage("Bill Payments..");



            //Get the customer details

            $response = $this->getCustomerData();



            //Log

            $this->logMessage("The customers details gotten are: ", $response);



            //Check if the response was false

            if (empty($response[self::SUCCESS])) {

                //Log error

                $this->logMessage("Unable to get data from wallet, the exception is: "
                    , $response[self::ERROR], self::LOG_LEVEL_ERROR);



                //Actual Text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error message

                $this->presentData($text, "HomePage", null, self::SESSION_STATE_END);

                return;
            }



            //Get the data and format it

            $customerData = $this->formatRecords($response[self::DATA][self::CUSTOMER_ACCOUNTS]);



            //Save the customer data

            $this->saveSessionVar(self::CUSTOMER_ACCOUNTS, $customerData);



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please select an account:

                $text = $this->loadText("SelectAccount") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Format the data

            foreach ($customerData as $key => $value) {

                //Log, text
    //            $this->logMessage("The individual customer data is: ",$value);
                //Append to text

                /*            $text .= $key . ". " . $value[self::ACCOUNT_ALIAS]

                . ", " . $value[self::ACCOUNT_NUMBER] . "\n"; */



                $text .= $key . ". " . $value[self::ACCOUNT_ALIAS] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER),
                $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the data

            $this->presentData($text, "HomePage", "processBillPaymentsPage");
        }

        function processBillPaymentsPage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->BillPaymentsPage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->BillPaymentsPage($warning);

                return;
            } //Check if the input entered is in the range gotten
            //Get the customer details

            $customerAccounts = $this->getSessionVar(self::CUSTOMER_ACCOUNTS);



            if ($input <= 0 || $input > count($customerAccounts)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->BillPaymentsPage($warning);

                return;
            }



            //Save the customer account

            $this->saveSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT, $customerAccounts[$input]);



            //Proceed to select a service

            $this->BillPayHomePage();
        }

        function processBillPayHomePage($input) {

            //Check if the input is the back character

            if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            } //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            } //Check if the input empty
            else if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->BillPayHomePage($warning);

                return;
            } //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->BillPayHomePage($warning);

                return;
            } //Check if the input entered is in the range gotten
            else if ($input <= 0 || $input > count($this->loadBillers())) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->BillPayHomePage($warning);

                return;
            }



            //Get the Service Number

            $billers = $this->loadBillers();



            //Get the biller

            $biller = $billers[$input];



            $serviceNumber = $biller["ServiceNumber"];

            $serviceID = $biller["ServiceID"];

            $serviceCode = $biller["ServiceCode"];

            $merchantName = $biller["FullName"]["TRANSLATIONS"][$this->getSessionVar(self::DEFAULT_LANGUAGE)];

            $isQueryBill = $biller["AllowQueryBill"];



            //Save the biller code

            $this->saveSessionVar(self::BILLER_CODE, $biller['BillerCode']);

            //Save the biller id

            $this->saveSessionVar(self::BILLER_ID, $biller['BillerID']);

            //Save the product code

            $this->saveSessionVar(self::PRODUCT_CODE, $biller['ProductCode']);

            //Save the biller account type name

            $this->saveSessionVar(self::BILLER_ACCOUNT_TYPE_NAME, $biller['BillerAccountTypeName']);





            //Log

            $this->logMessage("Got the serviceID: {$serviceID} and the Service Number: {$serviceNumber} and the service is: ", $billers[$input]);



            //Save the service ID

            $this->saveSessionVar(self::BILL_SERVICE_ID, $serviceID);

            $this->saveSessionVar(self::BILL_SERVICE_CODE, $serviceCode);

            $this->saveSessionVar(self::MERCHANT_NAME, $merchantName);

            $this->saveSessionVar(self::ALLOW_BILL_QUERY, $isQueryBill);



            //Check

            switch ($serviceNumber) {

                //DStv

                case 1:

                    //Log

                $this->logMessage("DSTV Option selected");



                $this->DSTVMenu();

                break;

                //GOTv

                case 2:

                    //Log

                $this->logMessage("GOTV Option selected");



                $this->GOTVMenu();

                break;

                //Zuku

                case 3:

                $this->ZukuMenu();

                break;

                //KPLC-Pre

                case 4:

                $this->KPLCPrepaidMenu();

                break;

                //Jambojet

                case 5:

                $this->JambojetMenu();

                break;

                //KPLC-Postpaid

                case 6:

                $this->KPLCPostpaidMenu();

                break;

                default:

                    //Go to Bill Payments Home

                $this->BillPayHomePage();

                break;
            }
        }

        function BillPayHomePage($warning = null) {

            //Log

            $this->logMessage("Bills Listing....");



            //Check if the warning is set

            if ($warning == null) {

                //Set the text
                //Actual Text: Please Select An Option:

                $text = $this->loadText("SelectOption") . "\n";
            } else {

                //Set the text

                $text = $warning . "\n";
            }



            //Get all the billers

            $billers = $this->loadBillers();



            //Log, test

            $this->logMessage("The list of Billers are:", $billers);



            //Format the data

            foreach ($billers as $key => $value) {

                //Append to text

                $text .= $key . ". "
                . $value["FullName"]["TRANSLATIONS"][$this->getSessionVar(self::DEFAULT_LANGUAGE)] . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array(
                $this->getSessionVar(self::BACK_OPTION_CHARACTER),
                $this->getSessionVar(self::HOME_OPTION_CHARACTER)
            ));



            //Display the data

            $this->presentData($text, "HomePage", "processBillPayHomePage");
        }

        //function to process billers



        function loadBillers() {

            //Return a list of formatted FT services

            return $this->formatRecords($this->removeInActiveFormatRecords($this->getSessionVar(self::BILLERS)));
        }

        /*

         * Menu for DSTV

         * */

        function DSTVMenu() {

            //Proceed to enter the merchant's account

            $this->EnterMerchantAccountMenu();
        }

        /*

         * Menu for GOTV

         * */

        function GOTVMenu() {

            //Proceed to enter the merchant's account

            $this->EnterMerchantAccountMenu();
        }

        /*

         * Menu for KPLCPrepaidMenu

         * */

        function KPLCPrepaidMenu() {

            //Proceed to enter the merchant's account

            $this->EnterMerchantAccountMenu();
        }

        /*

         * Menu for JambojetMenu

         * */

        function JambojetMenu() {

            //Proceed to enter the merchant's account

            $this->EnterMerchantBookingRefMenu();
        }

        /*

         * Menu for KPLCPostpaidMenu

         * */

        function KPLCPostpaidMenu() {

            //Proceed to enter the merchant's account

            $this->EnterMerchantAccountMenu();
        }

        /*

         * Menu for ZukuMenu

         * */

        function ZukuMenu() {

            //Proceed to enter the merchant's booking ref number

            $this->EnterMerchantAccountMenu();
        }

        private function EnterMerchantBookingRefMenu($warning = null) {

            //Log

            $this->logMessage("In the function: " . __FUNCTION__);



            //Get the merchant name

            $merchantName = $this->getSessionVar(self::MERCHANT_NAME);



            //Check if any warning was set

            if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Please enter your ^MERCHANT^ booking reference number

                $text = $this->loadText("EnterMerchantBookingRefNumber", array($merchantName)) . "\n";
            } else {

                $text = $warning . "\n";
            }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER),
                $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Process data

            $this->presentData($text, "DSTVMenu", "processEnterMerchantBookingRefMenu");
        }

        //function that process the input from the EnterMerchantBookingRefMenu

        function processEnterMerchantBookingRefMenu($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterMerchantBookingRefMenu($warning);

                return;
            } //Check if the input is not a number



            /* else if (!$this->isValidNumber($input)) {

              //Warning text

              //Actual Text: Invalid input. Please enter a valid number:

              $warning = $this->loadText("NonNumericInput");



              $this->EnterMerchantAccountMenu($warning);

              return;

          } */



            //Save the account number

          $this->saveSessionVar(self::BILL_ACCOUNT_NUMBER, $input);



            //Proceed to fetch the bills

          if ($this->getSessionVar(self::ALLOW_BILL_QUERY))
            $this->ChooseBillMenu();
        else
            $this->EnterCustomBillAmountMenu();
    }

    private function EnterMerchantAccountMenu($warning = null) {

            //Log

        $this->logMessage("In the function: " . __FUNCTION__);



            //Get the merchant name

        $merchantName = $this->getSessionVar(self::MERCHANT_NAME);



            //Check if any warning was set

        if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Please enter your ^MERCHANT^ account number

            $text = $this->loadText("EnterMerchantAccountNumber", array($merchantName)) . "\n";
        } else {

            $text = $warning . "\n";
        }



            //Add go back and home functionality
            //Actual Text:\n ^BACK^. Back \n ^HOME^. Go Home

        $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER),
            $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Process data

        $this->presentData($text, "DSTVMenu", "processEnterMerchantAccountMenu");
    }

        //function that process the input from the ChooseBillMenu

    function processEnterMerchantAccountMenu($input) {

            //Check if the input empty

        if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

            $warning = $this->loadText("EmptyInput");



            $this->EnterMerchantAccountMenu($warning);

            return;
            } //Check if the input is not a number



            /* else if (!$this->isValidNumber($input)) {

              //Warning text

              //Actual Text: Invalid input. Please enter a valid number:

              $warning = $this->loadText("NonNumericInput");



              $this->EnterMerchantAccountMenu($warning);

              return;

          } */



            //Save the account number

          $this->saveSessionVar(self::BILL_ACCOUNT_NUMBER, $input);



            //Proceed to fetch the bills

          if ($this->getSessionVar(self::ALLOW_BILL_QUERY))
            $this->ChooseBillMenu();
        else
            $this->EnterCustomBillAmountMenu();
    }

        /*

         * Menu to choose bill

         * */

        private function ChooseBillMenu($warning = null) {

            //Log

            $this->logMessage("In the function: " . __FUNCTION__);



            //Get the service ID

            $serviceID = $this->getSessionVar(self::BILL_SERVICE_ID);

            $serviceCode = $this->getSessionVar(self::BILL_SERVICE_CODE);



            //Check if any warning was set

            if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Please Select An Option:

                $text = $this->loadText("SelectOption") . "\n";
            } else {

                $text = $warning . "\n";
            }



            //Get the response

            $response = $this->getCustomerBills($serviceID, $serviceCode, true);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check success

            if (!$response[self::SUCCESS]) {

                //Get the merchant name

                $merchantName = $this->getSessionVar(self::MERCHANT_NAME);



                //Log

                $this->logMessage("Error while querying {$merchantName} bills. Proceeding to enter custom amount"
                    , null, self::LOG_LEVEL_ERROR);



                //Proceed to enter custom amount

                $this->EnterCustomBillAmountMenu();

                return;
            }

            //Check if there are no bills
            else if ($response[self::NUMBER_OF_BILLS] < 1) {

                //Get the merchant name

                $merchantName = $this->getSessionVar(self::MERCHANT_NAME);



                //Log

                $this->logMessage("No bills were found for {$merchantName}. Proceeding to enter custom amount"
                    , null, self::LOG_LEVEL_ERROR);



                //Proceed to enter custom amount

                $this->EnterCustomBillAmountMenu();

                return;
            }



            //Log

            $this->logMessage("Formatting records...");



            //Get the bills

            $bills = $this->formatRecords($response[self::DATA]);



            //log, test

            $this->logMessage("The new bill array is:", $bills);



            //Save the bills

            $this->saveSessionVar(self::BILLS_FORMATTED_DATA, $bills);

            $this->saveSessionVar(self::BILLS_COUNT, count($bills));



            //Display the bills found

            foreach ($bills as $key => $value) {

                //Log, test

                $this->logMessage("The bill is: ", $value);



                //Actual text: Account ^ACCOUNT_NUMBER^ for ^CURRENCY^ ^AMOUNT^

                $text .= "{$key}. " . $this->loadText("PendingBills", array(
                    $value[self::ACCOUNT_NUMBER],
                    $this->getSessionVar(self::CURRENCY),
                    $value[self::BILL_AMOUNT]
                )) . "\n";
            }



            //Add selecting a custom amount

            $text .= (count($bills) + 1) . ". " . $this->loadText("EnterOtherAmount");



            //Process data

            $this->presentData($text, "ChooseBillMenu", "processChooseBillMenu");
        }

        //function that process the input from the ChooseBillMenu

        function processChooseBillMenu($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->ChooseBillMenu($warning);

                return;
            }



            //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number:

                $warning = $this->loadText("NonNumericInput");



                $this->ChooseBillMenu($warning);

                return;
            }



            //Get the bills

            $bills = $this->getSessionVar(self::BILLS_FORMATTED_DATA);



            if ($input <= 0 || $input > (count($bills) + 1)) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->ChooseBillMenu($warning);

                return;
            }



            //Check if the custom option was selected

            if ($input == (count($bills) + 1)) {

                $this->EnterCustomBillAmountMenu();

                return;
            }



            //Save the amount

            $this->saveSessionVar(self::BILL_AMOUNT, $bills[$input][self::BILL_AMOUNT]);



            //Verify details

            $this->BillDetailsValidationPageBills();
        }

        /*

         * Menu to enter the custom amount

         * */

        private function EnterCustomBillAmountMenu($warning = null) {

            //Log

            $this->logMessage("In the function: " . __FUNCTION__);



            //Check if any warning was set

            if (empty($warning)) {

                //Initialize the text to be used
                //Actual text: Enter Amount

                $text = $this->loadText("EnterAmount") . "\n";
            } else {

                $text = $warning . "\n";
            }



            //Process data

            $this->presentData($text, null, "processEnterCustomBillAmountMenu");
        }

        //function that process the input from the EnterCustomBillAmountMenu

        function processEnterCustomBillAmountMenu($input) {

            //Check if the input empty

            if (empty($input)) {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->EnterCustomBillAmountMenu($warning);

                return;
            }



            //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number:

                $warning = $this->loadText("NonNumericInput");



                $this->EnterCustomBillAmountMenu($warning);

                return;
            }



            //Save the amount

            $this->saveSessionVar(self::BILL_AMOUNT, $input);



            //Confirm the options

            $this->BillDetailsValidationPageBills();
        }

        /*

         * function to verify details of FTP Transaction

         * */

        function BillDetailsValidationPageBills($warning = null, $previous = null) {

            //Get the saved previous page

            if (!empty($previous)) {

                //Save the previous page

                $this->saveSessionVar(self::PREVIOUS_PAGE, $previous);
            } else {

                //Get the previous page

                $previous = $this->getSessionVar(self::PREVIOUS_PAGE);
            }



            //Set the text

            $text = "";



            //Check if the warning system is set

            if (!empty($warning)) {

                //Set text

                $text = $warning . "\n";
            }



            //Get the accountAlias

            $selectedAccountAlias = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);

            $selectedAccountAlias = $selectedAccountAlias[self::ACCOUNT_ALIAS];



            //Get the merchant name

            $merchantName = $this->getSessionVar(self::MERCHANT_NAME);



            //Get the bill amount

            $billAmount = $this->getSessionVar(self::BILL_AMOUNT);



            //Get the DSTV account

            $DSTVAccount = $this->getSessionVar(self::BILL_ACCOUNT_NUMBER);



            //Set the text
            //Actual Text: Are You Sure You Want To Pay ^MERCHANT^ Bill for Amount ^CURRENCY^ ^AMOUNT^ From Account ^ACCOUNT_ALIAS^ For ^MERCHANT^ Account ^MERCHANT_ACCOUNT^. \n1. Yes \n2. No

            $text .= $this->loadText("ValidateMerchantBill", array(
                $merchantName,
                $this->getSessionVar(self::CURRENCY),
                $billAmount,
                $selectedAccountAlias,
                $merchantName,
                $DSTVAccount
            )
        ) . "\n";



            //Add go back and home functionality
            //Actual Text:^\n^ ^BACK^. Back ^\n^ ^HOME^. Go Home

            $text .= $this->loadText("BackAndHome", array($this->getSessionVar(self::BACK_OPTION_CHARACTER), $this->getSessionVar(self::HOME_OPTION_CHARACTER)));



            //Display the text

            $this->presentData($text, $previous, "processBillDetailsValidationPageBills");
        }

        //function to process input from DetailsValidationPageBills

        function processBillDetailsValidationPageBills($input) {

            //Check if the input empty

            if (empty($input) && $input !== "0") {

                //Warning text
                //Actual Text: You have enter empty input. Please enter again:

                $warning = $this->loadText("EmptyInput");



                $this->DetailsValidationPageBills($warning);

                return;
            }



            //Check if the input is the back character
            else if ($input === $this->getSessionVar(self::BACK_OPTION_CHARACTER)) {

                //Navigate back

                $this->navigateBack();

                return;
            }



            //Check if the input is home character
            else if ($input === $this->getSessionVar(self::HOME_OPTION_CHARACTER)) {

                //Go Home

                $this->GoHome();

                return;
            }



            //Check if the input is not a number
            else if (!$this->isValidNumber($input)) {

                //Warning text
                //Actual Text: Invalid input. Please enter a valid number::

                $warning = $this->loadText("NonNumericInput");



                $this->DetailsValidationPageBills($warning);

                return;
            }



            //Check if the input entered is in the range gotten
            else if (!in_array($input, array(1, 2))) {

                //Warning text
                //Actual Text: Invalid input. Please select a valid option:

                $warning = $this->loadText("InvalidInput");



                $this->DetailsValidationPageBills($warning);

                return;
            }



            //Switch the statement

            switch ($input) {

                //Check if the value
                //Yes

                case 1:

                    //Log

                $this->logMessage("Processing bills from wallet");

                break;

                //No

                case 2:

                $this->GoHome();

                return;
            }



            //Process bill transaction

            $this->ProcessBillTransaction();
        }

        function ProcessBillTransaction() {

            $customerAccount = $this->getSessionVar(self::CHOSEN_CUSTOMER_ACCOUNT);



            //Get the saved bill

            $bill = $this->getSessionVar(self::CHOSEN_BILL);

            $billerCode = $this->getSessionVar(self::BILLER_CODE);

            $billerID = $this->getSessionVar(self::BILLER_ID);

            $productCode = $this->getSessionVar(self::PRODUCT_CODE);

            $billAccountNumber = $this->getSessionVar(self::BILL_ACCOUNT_NUMBER);

            $billAccountTypeName = $this->getSessionVar(self::BILLER_ACCOUNT_TYPE_NAME);



            /*

             * <Payload>

             * {"paymentDetails":{"billerCode":"KPLCPostpaid","billerID":741,"billRefNo":"Parameter not required by ESB","productCode":"KPLC Postpaid","amount":20000,"customerName":"CHARLES KIVUTI"},"billFormData":[{"formData":"Account Number","fieldValue":"8484884","dataType":"String"}]}

             * */



            //Get the serviceID

            $serviceID = $this->getSessionVar(self::BILL_SERVICE_ID);



            //Process the transaction

            $payload = array(
                "paymentDetails" => array(
                    "billerCode" => $billerCode,
                    "billerID" => $billerID,
                    "billRefNo" => "Parameter not required by ESB",
                    "productCode" => $productCode,
                    "amount" => $this->getSessionVar(self::BILL_AMOUNT),
                    "customerName" => $this->getSessionVar(self::CUSTOMER_NAMES),
                ),
                "billFormData" => array(
                    array(
                        "formData" => $billAccountTypeName,
                        "fieldValue" => $billAccountNumber,
                        "dataType" => "String"
                    )
                )

                    /* ,

                      "serviceID" => $serviceID,

                      "flavour" => "open",

                      "pin" => $this->getSessionVar(self::ENCRYPTED_PIN),

                      "accountAlias" => $customerAccount[self::ACCOUNT_ALIAS],

                      "accountID" => $customerAccount[self::CBS_ACCOUNT_ID],

                      "amount" => $bill[self::BILL_AMOUNT],

                      "merchantCode" => $bill[self::BILL_SERVICE_CODE],

                      "enroll" => null,

                      "CBSID" => $this->getSessionVar(self::WALLET_CBS_ID),

                      "columnA" => $this->_msisdn,

                      "columnC" => $bill[self::BILL_SERVICE_CODE],

                      "columnD" => null */
                  );



            //Call wallet and get the response

            $response = $this->asynchronousProcessing($payload, true);



            //Log

            $this->logMessage("The response received is: ", $response);



            //Check if the response was successful\

            if ($response[self::DATA][self::WALLET_STAT_CODE] !== 1) {

                //Log, error

                $this->logMessage("Unable to process balance enquiry, the error was:"
                    , $response, self::LOG_LEVEL_ERROR);



                //Load error message
                //Actual text: Unable to process your request at this time. Please try again later

                $text = $this->loadText("ErrorMessage");



                //Display error

                $this->presentData($text, null, null, self::SESSION_STATE_END);

                return;
            }



            //Log

            $this->logMessage("Successfully posted pay bill request, the response received is: ", $response);



            //Set the text

            $text = $this->loadText("SuccessMsg", array(self::ECOBANK_NAME));



            //Display message

            $this->FinalPage($text);
        }

    }

    //Start the menu

    $ecobankGlobal = new EcobankGlobalUSSDMenu();

    echo $ecobankGlobal->navigate();
