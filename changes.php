
<?php 


 function processNwsc($input) {

            $this->saveSessionVar("nwscMeterNumber", $input);

            $text = "Select area \n";
            $areasArray = explode(",", $this->nwscAreas);

            for ($i = 0; $i < sizeof($areasArray); $i++) {
                $text .= $i + 1 . ". " . $areasArray[$i] . "\n";
            }

            $this->displayText = $text;
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "selectAreaNWSC";
            $this->previousPage = "processNwsc";




        }

        function selectAreaNWSC($input) {


            $areasArray = explode(",", $this->nwscAreas);
            $input = (int) $input;

            #check for array index out of bounds
            if ($input > sizeof($areasArray) || $input < 1) {


                $text = "Invalid Input \nSelect area \n";
                $areasArray = explode(",", $this->nwscAreas);

                for ($i = 0; $i < sizeof($areasArray); $i++) {
                    $text .= $i + 1 . ". " . $areasArray[$i] . "\n";
                }

                $this->displayText = $text;
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processNwsc";
                $this->previousPage = "selectAreaNWSC";
            } else {
                #valid index has been selected
                $selectedIndex = $input - 1;
                $selectedArea = trim($areasArray[$selectedIndex]);
                $this->saveSessionVar("selectedArea", $selectedArea);
                $meterNumber = $this->getSessionVar("nwscMeterNumber");

                $accountDetails = $this->validateNWSCCustomerAccount($meterNumber, $selectedArea);


                if ($accountDetails == "" || $accountDetails == null) {
                    $this->displayText = "Invalid account Meter number. Please enter meter number again";
                    $this->sessionState = "CONTINUE";
                    $this->nextFunction = "processNwsc";
                    $this->previousPage = "enterMeterNumber";
                } else {

                    $authStatusCode = $accountDetails['authStatus']['authStatusCode'];
                    $authStatusDesc = $accountDetails['authStatus']['authStatusDescription'];

                    $statusCode = $accountDetails['results'][0]['statusCode'];
                    $responseData = $accountDetails['results'][0]['responseExtraData'];

                    if ($authStatusCode != $this->hubAuthSuccessCode) {
                        $this->logMessage("Authentication Failed !!!!!!!", NULL, 4);

                        $this->displayText = "Account number has failed authentication ";
                        $this->sessionState = "END";
                    } elseif ($statusCode != $this->hubValidationSuccessCode) {

                        $this->logMessage("Invalid Account !!!!!!", NULL, 4);
                        $this->displayText = "Invalid account ";
                        $this->sessionState = "END";
                    } else {

                        $accountDetails = json_decode($accountDetails['results'][0]['responseExtraData'], true);

                        $customerName = $accountDetails['customerName'];
                        $balance = $accountDetails['balance'];
                        $customerType = $accountDetails['customerType'];

                        $this->saveSessionVar("nwscCustomerName", $customerName);
                        $this->saveSessionVar("nwscBalance", $balance);
                        $this->saveSessionVar("nwscCustomerType", $customerType);
                        $this->saveSessionVar("nwscMeterNumber", $meterNumber);

                        if ($balance == 0 || $balance == null) {
                            //$this->displayText = "Enter Amount to pay";
                            $this->displayText = "Dear {$customerName}, Your balance is UGX " . number_format(0) . ". Enter Amount to pay";
                        } else {
                            $this->displayText = "Dear {$customerName}, Your balance is UGX " . number_format($balance) . ". Enter Amount to pay";
                        }

                        $this->sessionState = "CONTINUE";
                        $this->nextFunction = "enterNWSCAmount";
                        $this->previousPage = "processNwsc";
                    }
                }

    
            }
        }

        function enterNWSCAmount(){

             
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

              $ACCOUNTS = $this->getSessionVar('ACCOUNTS');
              $message = "Select Account: \n";
              if ($ACCOUNTS != null) {
              $message = "Choose Account \n";
              $count = 0;
              foreach ($ACCOUNTS as $account) {
              $count = $count + 1;
              $selectedAccount = $account;
              $message .= $count . ")" . $selectedAccount['ACCOUNTNUMBER'] . "\n";
              }
              }

              $this->displayText = "Select account:\n" . $message;
              $this->sessionState = "CONTINUE";
              $this->nextFunction = "finalizeProcessingPayBill";

              break;

              case 2:
              $this->startPage();
              break;

              default:
              $this->nextFunction = "enterAmount";
               
              break;
              }
              
              
        }