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
        //validation configs
        // private $hubJSONAPIUrl = "http://localhost:9001/hub/services/paymentGateway/JSON/index.php";
        private $hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";
        private $hubValidationFunction = "BEEP.validateAccount";
        private $hubAuthSuccessCode = "131";
        private $hubValidationSuccessCode = "307";
        private $beepUsername = "nic_test_api_user";
        private $beepPassword = "nic_t3st_api_us3r";
        private $umemeServiceID = '28';
        private $umemeServiceCode = 'UMEME';
        private $nwscServiceID = '27';
        private $nwscServiceCode = 'NWSC';
        private $kccaServiceID = '233';
        private $kccaServiceCode = 'KCCA';
        private $uraServiceID = '30';
        private $uraServiceCode = 'URA';
        private $nwscAreas = "Kampala,Jinja,Entebbe,Lugazi,Iganga,Kawuku,Kajjansi,Mukono,Others";

        function startPage() {
            

             $this->displayText = "Reached ";
                $this->sessionState = "END";
                

/*
              $message = "Select Option. \n1: VERIFY CARD \n2: TOPUP CARD \n3: CARD BALANCE \n3: CARD MINISTATEMET \n\n 0) EXIT";
                    $message .= "\n\n0. Home \n" . "00. Exit";
                    $this->displayText = $message;
                    $this->sessionState = "END";
                    // $this->nextFunction = "menuSwiter";
                    // $this->previousPage = "utilitySelected";
                     */


        }


    