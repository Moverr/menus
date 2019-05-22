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
                
                 private $hubJSONAPIUrl = "http://10.250.250.29:9000/hub/services/paymentGateway/JSON/index.php";
                // private $hubJSONAPIUrl = "http://localhost:9001/hub/services/paymentGateway/JSON/index.php";
                // private $hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";
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

        
        // private $hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";

        // private $hubJSONAPIUrl = "http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php";
// private $hubJSONAPIUrl = "http://10.250.250.29:9000/hub/services/paymentGateway/JSON/index.php";
// private $hubJSONAPIUrl = "http://10.250.250.29:9000/hub/services/paymentGateway/JSON/index.php";

 


// http://197.159.100.247:9000/hub/services/paymentGateway/JSON/index.php"

                function startPage() {






                    $message = "Select Option. \n1: Verify card   \n2: Topup card \n3: Card balance \n4: Card ministatement \n\n 0) Exit";

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
                    $this->saveSessionVar("CARDAMOUNT", $input);
                    $this->displayText = "1)Confirm Transaction ";
                    $this->sessionState = "CONTRINUE";
                    $this->nextFunction = "finalizePayment";
                    $this->previousPage = "getAmount";
                    }

            }
            function finalizePayment($input){




 $credentials = array(
            "username" => "gazpay",
            "password" => "abcd@12345"
        );


        $packet = array();


        $extraData = json_encode(array(
             
            "authorization"=>"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImdhelRvcFVwLm11bGFAY2VsbHVsYW50LmNvbSIsInBhc3N3b3JkIjoiJDJhJDEwJDJCM2IzY1luWG5yOVRkSlhWbUgwQU8ydXhSSkUvRFY3L0NuSTYzS3RycVNVZWNIQ1R1cEsyIiwidXNlcm5hbWUiOiJNdWxhX0NlbGx1bGFudCIsInJhbmRvbSI6Ik1VTEFfR0FaNDI4NjYxMTIzIiwiaWF0IjoxNTUzNzg0NTAxfQ.WBpkwbMWuRx5sgqjkmAuwgvaG1dFrduoY2bhdmi2EDw",
            "cardmask"=>"G001",
            "transactioncode"=>"CPG_TRANSACTION",
            "amount"=>12345

 

        )

        );


 

        $packet = array( 
            
            'serviceID' => 2114,
            'serviceCode' => "PAY077PAY077",

            'requestExtraData' => null,
            'extraData' => $extraData,
            "payerTransactionID"=> rand(),
            "invoiceNumber"=>"73737",
            "invoiceNumber"=>"123",
            "MSISDN"=>254779820962,
            "amount"=>1000,
            "accountNumber"=> "21140615",
            "narration"=> "Beep.Payment",
               "currencyCode"=>"KES",
                "customerNames"=> "Muyinda Rogers",
                "paymentMode"=> "Online Payment",
                 "datePaymentReceived"=> "2019-05-22 3:03:18"
            // "payerTransactionID"=>0779820962,
        );


        $data[] = $packet;
        $payload = array(
            "credentials" => $credentials,
            "packet" => $data
        );

        $spayload = array(
           // "function"=>"BEEP.validateAccount",
            "function" => "BEEP.postPayment",
            "payload" => json_encode($payload)
        );


            // $respponse = $this->postValidationRequestToHUB($this->$hubJSONAPIUrl, json_encode($spayload));



$payload = array(
    'credentials' => $credentials,
    'packet' => $packet);
//$params=array($function,$payload);
 $response  =  $this->postToCPGPayload($payload, "http://10.250.250.29:9000/hub/services/paymentGateway/JSON/index.php", "BEEP.postPayment");
// return array("SUCCESS"=>true);


 
 $this->displayText = "PASSME";
                $this->sessionState = "END";
                 


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




function postToCPGPayload($params, $url, $method) {
//$method="PlotUpload";
    $payload = array('function' => $method, 'payload' => json_encode($params));
//echo json_encode($payload);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

     $this->logMessage("||||||||||||||||||: ", print_r(json_decode($output),true));



    return $output;
}




         function postValidationRequestToHUB($url, $fields) {
             $fields_string = null;
 $this->logMessage(" .......................: ", "INIT");



        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
      
        $result = curl_exec($ch); 
        curl_close($ch);
         $this->logMessage(" .......................: ", json_decode($result));



          return $result;
        }




}

         



    $ncBankUSSD = new GAZUSSD();
    echo $ncBankUSSD->navigate();

