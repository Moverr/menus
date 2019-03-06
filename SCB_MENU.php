<?php

/*
 * Sample calculator USSD experience
 *
 * sum
 * product
 * difference
 * division
 */
include 'DynamicMenuController.php';

class CalculatorMenu extends DynamicMenuController {

    private $resultSetNull = 102;
    private $acceptedConsent  = 100;
    private $declinedConsent = 103;
    private $unknownError = 104;

    function startPage() {

        // $this->syncClientProfile();
        //$NEW_IMSI = '12345-85948-59409-22223';

        //
        $checkIMSIConsent = $this->checkIMSIConsent();

        if ($checkIMSIConsent['STATCODE'] == $this->resultSetNull) {
            //the person has never registered, so lets ask if we can save the details
            $this->displayText = "Do you wish to track your SIM Card Changes\n1. Yes\n2.No";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "checkResponse";
        } elseif ($checkIMSIConsent['STATCODE'] == $this->acceptedConsent) {
            //the customer has activated the consent request, and the record is active
            $responseStatus = $this->validateIMSI($this->IMSI);
            $this->performValidationChecks($responseStatus);

            if ($responseStatus['SUCCESS']) {
                $this->displayText = "Welcome to calculator service.Please input \n *  for product \n + for sum \n - for difference \n / for division \n";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processOperators";
                $this->serviceDescription = "Calculator";
            } else {
                $this->displayText = "Please visit your branch for assistance.";
                $this->sessionState = "END";
            }
        } elseif ($checkIMSIConsent['STATCODE'] == $this->declinedConsent) {
            //The customer declined the request previously, just proceed to the menu
            $this->displayText = "Welcome to calculator service.Please input \n *  for product \n + for sum \n - for difference \n / for division \n";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processOperators";
            $this->serviceDescription = "Calculator";
        } elseif ($checkIMSIConsent['STATCODE'] == $this->unknownError) {
            $this->displayText = "A problem occurred. Kindly try again";
            $this->sessionState = "END";
        }
//        die;
        CoreUtils::flog4php(4, $this->msisdn, array("MESSAGE" => "INSIDE Function | CalculatorMenu | startPage()| kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk | RESPONSE >>> $responseStatus"), __FILE__, __FUNCTION__, __LINE__, "ussdinfo", USSD_LOG_PROPERTIES);
    }

    /**
     * selection validation when a customer is prompted to choose on the consent
     * @param $input
     */
    function checkResponse($input) {
        switch ($input) {
            case 1:
                $this->saveIMSIConsent($this->acceptedConsent);
                $this->validateIMSI($this->IMSI);
                break;
            case 2:
                //the customer declines
                $this->saveIMSIConsent($this->declinedConsent);
                $this->validateIMSI($this->IMSI);
                break;

            default:
                $this->startPage();
        }
    }

    function performValidationChecks($responseStatus) {
        $IMSI_BLOCKED_STATUS = 3;
        $STATUS_ACCESS_DENIED_BLOCKED_IMSI = 14;
        $IMSI_STATUS_ACTIVE = 1;
        $IMSI_STATUS_UPDATE = 15;
        $IMSI_STATUS_BLOCKED = 13;

        $payload = array();
        $payload['OLDIMSI'] = $responseStatus['DATA']['DATA']['IMSI'];
        $payload['NEWIMSI'] = $this->IMSI;
        $payload['DATEMODIFIED'] = date('jS m, Y');
        $clientProfileID = $responseStatus['DATA']['DATA']['clientProfileID'];
        // CHECK: if we are updating the IMSI i.e. the customer has been told to dial now!
        if (isset($responseStatus['DATA']['DATA']['IMSI_status']) &&
            $responseStatus['DATA']['DATA']['IMSI_status'] == $IMSI_STATUS_ACTIVE &&
            $responseStatus['DATA']['DATA']['IMSI'] == 0) {

            $this->updateIMSI($this->IMSI, $IMSI_STATUS_ACTIVE);
            //$payload = array();

            $this->logChannelRequest($payload, $IMSI_STATUS_UPDATE);

        } else if (!$responseStatus['SUCCESS'] || $responseStatus['SUCCESS'] == false &&
            $responseStatus['DATA']['DATA']['IMSI_status'] == $IMSI_STATUS_ACTIVE) {
            // CHECK: If the customer has changed the  SIM card and is attempting to dial
            // if SO: BLOCK THEM
            $this->updateIMSIStatus($IMSI_BLOCKED_STATUS, $clientProfileID, IMSI_KEY_ID);
            $this->logChannelRequest($payload, $IMSI_STATUS_BLOCKED);

        } else if(isset($responseStatus['DATA']['DATA']['IMSI_status']) &&
            $responseStatus['DATA']['DATA']['IMSI_status'] == $IMSI_BLOCKED_STATUS) {
            // CHECK: If the customer is trying to access the system yet they have been blocked
            // if so: log it & kick-them out
            $this->logChannelRequest($payload, $STATUS_ACCESS_DENIED_BLOCKED_IMSI );
        }



        // 1. validates
        // 2. block
        // 3. updates new IMSI
        // 4. creates a new profile!

        // check if the teller / operator has reset the customers IMSI
//       if ($responseStatus['DATA']['DATA']['IMSI'] == 0 &&  $responseStatus['DATA']['DATA']['IMSI_status'] == 1) {
//           // UPDATE IMSI TO THE NEW VALUE
//           $this->updateIMSI('wueiwueiweuiwueiwwi', 1);
//       }
        //$responseStatus = $this->updateIMSI('dslkddkrioeiroieoiroeo79898989898989898989', 2);
    }
    function processOperators($input) {
        $tempdisplaytext = "";
        $this->serviceDescription = "Calculator";
        //if blank input was given
        if ($input == NULL) {
            $this->displayText = "Wrong Input.Please input \n *  for product \n + for sum \n - for difference \n / for division \n";
            $this->sessionState = "CONTINUE";
            $this->nextFunction = "processOperators";

            return;
        }

        switch ($input) {
            case "+":
                $tempdisplaytext.=' add';
                $this->nextFunction = "sum";

                break;
            case "-":
                $tempdisplaytext.=' subtract';
                $this->nextFunction = "difference";

                break;
            case "/":
                $tempdisplaytext.=' divide';
                $this->nextFunction = "division";

                break;
            case "*":

                $tempdisplaytext.=' multiply';
                $this->nextFunction = "product";
                break;
            default:
                $this->displayText = "Wrong Input.Please input \n *  for product \n + for sum \n - for difference \n / for division \n";
                $this->sessionState = "CONTINUE";
                $this->nextFunction = "processOperators";
                return;
                break;
        }
        $this->displayText = "Please input the number of operands you wish to" . $tempdisplaytext;
        $this->sessionState = "CONTINUE";
    }

    function sum($input) {

        if ($this->previousPage == "sumprocess") {
            //get total number of operands from session
            $maxoperands = $this->getSessionVar('maxOperands');
            $currentoperand = $this->getSessionVar('currentOperand');


            $sumtemp = $this->getSessionVar('totalsum');
            $newsum = $sumtemp + $input;
            //we've reached total number of operands
            if ($maxoperands == $currentoperand) {
                $this->displayText = "Your total sum of $maxoperands operands is $newsum . Bye";
                $this->sessionState = "END";
                return;
            }
            $currentoperand++;

            $this->saveSessionVar('currentOperand', $currentoperand); //save where we are at the moment
            $this->saveSessionVar('totalsum', $newsum);
            $this->displayText = "Please input operand $currentoperand to sum";
            $this->previousPage = "sumprocess";
            $this->nextFunction = "sum";
            $this->sessionState = "CONTINUE";
        } else {
            //we know this is the first time so init current operand to 1
            //save total number of operands expected to session
            $this->saveSessionVar('maxOperands', $input);
            $this->saveSessionVar('currentOperand', 1);

            $this->sessionState = "CONTINUE";

            $this->previousPage = "sumprocess";
            $this->nextFunction = "sum";
            $this->displayText = "Please input operand 1 to sum";
        }
    }

    function product($input) {
        if ($this->previousPage == "productprocess") {
            //get total number of operands from session
            $maxoperands = $this->getSessionVar('maxOperands');
            $currentoperand = $this->getSessionVar('currentOperand');

            $producttemp = $this->getSessionVar('totalproduct');
            if ($producttemp == "") {
                $producttemp = 1;
            }
            $newproduct = $producttemp * $input;
            //we've reached total number of operands
            if ($maxoperands == $currentoperand) {
                $this->displayText = "Your total product of $maxoperands operands is $newproduct . Bye";
                $this->sessionState = "END";
                return;
            }
            $currentoperand++;

            $this->saveSessionVar('currentOperand', $currentoperand); //save where we are at the moment
            $this->saveSessionVar('totalproduct', $newproduct);
            $this->displayText = "Please input operand $currentoperand to multiply";
            $this->sessionState = "CONTINUE";

            $this->previousPage = "productprocess";
            $this->nextFunction = "product";
        } else {
            //we know this is the first time so init current operand to 1
            //save total number of operands expected to session
            $this->saveSessionVar('maxOperands', $input);
            $this->saveSessionVar('currentOperand', 1);

            $this->sessionState = "CONTINUE";

            $this->previousPage = "productprocess";
            $this->nextFunction = "product";
            $this->displayText = "Please input operand 1 to multiply";
        }
    }

    function division($input) {
        if ($this->previousPage == "divisionprocess") {
            //get total number of operands from session
            $maxoperands = $this->getSessionVar('maxOperands');
            $currentoperand = $this->getSessionVar('currentOperand');


            $divisiontemp = $this->getSessionVar('totaldivision');

            if ($divisiontemp == "") {
                $divisiontemp = 1;
            }
            $newdivision = $divisiontemp / $input;

            //we've reached total number of operands
            if ($maxoperands == $currentoperand) {
                $this->displayText = "Total division of $maxoperands operands is $newdivision . Bye";
                $this->sessionState = "END";
                return;
            }
            $currentoperand++;

            $this->saveSessionVar('currentOperand', $currentoperand); //save where we are at the moment
            $this->saveSessionVar('totaldivision', $newdivision);
            $this->displayText = "Please input operand $currentoperand to divide";
            $this->previousPage = "divisionprocess";
            $this->nextFunction = "division";
            $this->sessionState = "CONTINUE";
        } else {
            //we know this is the first time so init current operand to 1
            //save total number of operands expected to session
            $this->saveSessionVar('maxOperands', $input);
            $this->saveSessionVar('currentOperand', 1);


            $this->previousPage = "divisionprocess";
            $this->nextFunction = "division";
            $this->displayText = "Please input operand 1 to divide";
            $this->sessionState = "CONTINUE";
        }
    }

    function difference($input) {
        if ($this->previousPage == "diffprocess") {
            //get total number of operands from session
            $maxoperands = $this->getSessionVar('maxOperands');
            $currentoperand = $this->getSessionVar('currentOperand');


            $difftemp = $this->getSessionVar('totaldiff');
            $newdiff = $difftemp - $input;
            //we've reached total number of operands
            if ($maxoperands == $currentoperand) {
                $this->displayText = "Your total difference of $maxoperands operands is $newdiff . Bye";
                $this->sessionState = "END";
                return;
            }
            $currentoperand++;

            $this->saveSessionVar('currentOperand', $currentoperand); //save where we are at the moment
            $this->saveSessionVar('totaldiff', $newdiff);
            $this->displayText = "Please input operand $currentoperand to subtract";
            $this->previousPage = "diffprocess";
            $this->nextFunction = "difference";
            $this->sessionState = "CONTINUE";
        } else {
            //we know this is the first time so init current operand to 1
            //save total number of operands expected to session
            $this->saveSessionVar('maxOperands', $input);
            $this->saveSessionVar('currentOperand', 1);
            $this->previousPage = "diffprocess";
            $this->nextFunction = "difference";
            $this->displayText = "Please input operand 1 to subtract";
            $this->sessionState = "CONTINUE";
        }
    }

}

$calc = new CalculatorMenu;
echo $calc->navigate();
?>
