 <?php 



  function processUmeme($input) {
            $clientAccounts = $this->getSessionVar('clientAccounts');
            $meterNumber = $input;
            $accountDetails = $this->validateUMEMECustomerAccount($meterNumber);


     $this->logMessage("VALIDATE UMEME RESPONSE :  ", print_r($responseDataArray,true), 4);


            if ($accountDetails == "" || $accountDetails == null) {

                $this->displayText = "Invalid account Meter number. Please enter meter number again";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processUmeme";
                $this->previousPage = "enterMeterNumber";
            } else {

                //VALIDATE IF THE ACCOUNT EXISTS, OF IF THE ACCOUNT IS VALID 
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
                    $this->nextFunction = "enterUmemeAmount";
                    $this->previousPage = "processUmeme";
                }
            }
        }

        function enterUmemeAmount($input) {

            if ($input == null) {

                $this->displayText = "Invalid  input , kindly enter amount to pay  ";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "enterUmemeAmount";
                $this->previousPage = "enterUmemeAmount";
            } else {


                $amount = (int) $input;
                $this->saveSessionVar("umemeAmount", $amount);


                $umemeBalance = $this->getSessionVar("umemeBalance") == NULL ? 0 : $this->getSessionVar("umemeBalance");
                $this->logMessage("Comparing balance " . $umemeBalance . " and the entered amount " . $this->getSessionVar("umemeAmount"), NULL, 4);
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
                    $this->nextFunction = "confirmUmemePay";
                    $this->previousPage = "enterUmemeAmount";
                }
            }
        }

        function confirmUmemePay($input) {

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
                    $this->previousPage = "enterAmount";
                    $this->processUmeme($input);
                    break;
            }
        }