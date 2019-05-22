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

                private $hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";


                function startPage() {





                    $message = "Select Option. \n1: VERIFY CARD \n2: TOPUP CARD \n3: CARD BALANCE \n4: CARD MINISTATEMET \n\n 0) EXIT";

                    $this->displayText = $message;
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "menuSwiter";
                    $this->previousPage = "startPage";



                }

                function  menuSwiter($input){
                    switch ($input) {
                        case '1':
                            # code...
                         $this->validateCardMenu();
  
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

            function validateCardMenu(){
                $this->displayText = "Under Constrution";
                $this->sessionState = "END";
                        
            }
            function topUpCardMenu(){
                $this->displayText = "Enter Card Number";
                $this->sessionState = "CONTRINUE";
                $this->nextFunction = "getCardNumber";
                $this->previousPage = "topUpCardMenu";
                
            }

            function getCardNumber($input){
                if($input == ""){
                   $this->displayText = "Invalid Input \nEnter Card Number";
                $this->sessionState = "CONTRINUE";
                $this->nextFunction = "getCardNumber";
                $this->previousPage = "getCardNumber";
                }else{
                $this->saveSessionVar("CARDNUMBER", $input);
                $this->displayText = "Enter TopUp Amount ";
                $this->sessionState = "CONTRINUE";
                $this->nextFunction = "getAmount";
                $this->previousPage = "getCardNumber";

                }

            }


            function getAmount($input){
                    if($input == ""){
                       $this->displayText = "Invalid Input \nEnter TopUp Amount";
                    $this->sessionState = "CONTRINUE";
                    $this->nextFunction = "getAmount";
                    $this->previousPage = "getAmount";
                    }else{
                    $this->saveSessionVar("CARDNUMBER", $input);
                    $this->displayText = "Enter TopUp Amount ";
                    $this->sessionState = "CONTRINUE";
                    $this->nextFunction = "finalizePayment";
                    $this->previousPage = "getAmount";
                    }

            }
            function finalizePayment($input){



            }

            function validateCard($input){

            }

            function post(){

            }

            function cardBalanceMenu(){
             $this->displayText = "COMING SOON";
             $this->sessionState = "END";
         }
         function cardMiniStatementMenu(){
             $this->displayText = "COMING SOON";
             $this->sessionState = "END";
         }

         function ehdMenu(){
             $this->displayText = "Thank you for using Gaz";
             $this->sessionState = "END";
         }



         function postValidationRequestToHUB($url, $fields) {
            $fields_string = null;

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            $result = curl_exec($ch); 
            curl_close($ch);
            return $result;
        }




}

         



    $ncBankUSSD = new GAZUSSD();
    echo $ncBankUSSD->navigate();

