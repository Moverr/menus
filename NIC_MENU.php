<?php

/*
 * MTN UG Mula USSD Menu Payments
 *
 * @author jennifer
 *
 */
//error_reporting(0);
include 'DynamicMenuController.php';
include 'ncussduganda/NCUGconfigs.php';

class BINITMENU extends DynamicMenuController {

	// LIVE CONFIGURATION
	private $SERVICE_DESCRIPTION = "BINIT UGANDA";

	private $clientSystemID = 51;

	function startPage() {
		$message = "Welcome to BINIT "
			. "\n1).Pay Bill  "
			. "\n2).Balance Enquiry   "
			. "\n3).Signup   "
			. "\n0).Cancel   ";

		$this->displayText = $message;
		$this->sessionState = "CONTINUE";
		$this->serviceDescription = $this->SERVICE_DESCRIPTION;
		$this->nextFunction = "startPage";
		$this->previousPage = "menuSwitcher";

	}

	function menuSwitcher($input) {

		switch ('' . $input) {
		case '1':
# code...
			$this->payBillMenu();
			break;

		case '2':
# code...
			$this->payBillMenu();

			break;
//                    BILL PAYMENTS
		case '3':
			$this->payBillMenu();
			break;

		case '0': # code...
			$this->displayText = "Thank You for supporting BINIT Uganda   ";
			$this->sessionState = "END";
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
	}

	function payBillMenu($input) {
		$this->saveSessionVar("MENUITEM", "PAYBILL");
		$this->displayText = "Enter Customer Names ";
		$this->sessionState = "CONTINUE";
		$this->serviceDescription = $this->SERVICE_DESCRIPTION;
		$this->nextFunction = "getCustomerName";
		$this->previousPage = "payBillMenu";

	}

	//TODO; Get Customer Names
	function getCustomerName($input) {
		if ($input == null) {
			$this->displayText = "Invalid input ";
			$this->sessionState = "CONTINUE";
			$this->nextFunction = "getCustomerName";
		} else {
			$this->saveSessionVar("CUSTOMERNAME", $input);
			$this->displayText = "Enter Account Number /Reference  ";
			$this->sessionState = "CONTINUE";
			$this->serviceDescription = $this->SERVICE_DESCRIPTION;
			$this->nextFunction = "" . $callback;
			$this->previousPage = "getReferenceNumber";

		}

	}

//TODO; Get Customer Names
	function getReferenceNumber($input) {
		if ($input == null) {
			$this->displayText = "Invalid input ";
			$this->sessionState = "CONTINUE";
			$this->nextFunction = "getReferenceNumber";
		} else {
			$this->saveSessionVar("REFERENCENUMBER", $input);
			$menuitem = $this->getSessionVar("MENUITEM");
			$this->nextStepChooser($menuitem);

		}

	}

	function nextStepChooser($input) {
		switch ($input) {
		case 'PAYBILL':
			//
			break;
		default:
			break;
		}
	}

}

$binitmenu = new BINITMENU;
echo $binitmenu->navigate();
