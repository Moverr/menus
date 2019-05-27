<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NCUGconfigs
 *
 * @author Rodgers Muyinda
 */
class NCUGconfigs {

//    const PIN_SERVICE_ID = 206;
	const PIN_SERVICE_ID = 6;
	const QUESTIONNUMBER = 3;
	const DEFAULT_PIN = '1234';
	const ACCOUNT_DETAIL_VAL_SERVICE_ID = 58;
	const LOG_SUCCESS_CODE = "369";
	//Define the log levels
	const LOG_LEVEL_INFO = 4;
	const LOG_LEVEL_ERROR = 1;
	const PIN_EXPIRE_TIME = 86400;
	const BANK_SIGNATURE = "DTB Uganda";
	const PANAMA_REQ_PARAM_NUM = "4";
	const HUB_CLIENT_ID = 186;
	const UG_CODE = 256;
	//PIN STATUSES
	const ONE_TIME_PIN_STATUS = 2;
	const ONE_TIME_PIN_EXPIRED = 6;
	const LOCKED_ACTIVE_PIN = 3;
	const LOCKED_ONETIME_PIN = 4;

	//PayTV configs
	const DEFAULT_PACKAGE_NAME = " ";
	const GOTV_PACKAGES = "GOtv Lite=9500, Mobile Bouquet=11250, Lite Quarterly=22000, GOtv Plus=26000, Max Bouquet=49000, Lite 12mths=60000";
	const DSTV_PACKAGES = "Access=33000, Family=60000, French11=66375, Asia=128000, Compact=115000, Compact Plus=180000, Premium=280000";
	const AZAM_PACKAGES = "Azam 1wk Pure=3500, Azam 2wks Pure=6500, Azam Pure=10000, Azam Plus=25000, Azam Play=37000";
	const STARTIMES_PACKAGES = "Basic=18000, Classic=33000, Unique=60000";
	const ZUKU_PACKAGES = "Smart=10500, Classic=23500, Premium=33500";
	const KWESE_PACKAGES = "3 days=17000, 7 days=32000, 30 days=106000";

	const DSTV_SERVICE_ID = 33;

	const DSTV_SERVICE_CODE = "DSTVUG";
	const DSTVUG_CODE = "DSTV";
	const DSTV_WALLET_MERCHANT_CODE = "DSTVUG";

	const STARTIMES_SERVICE_ID = 1298;
	const STARTIMES_SERVICE_CODE = "STARTIMES";
	const STARTIMES_CODE = "STARTIMES";
	const STARTIMES_WALLET_MERCHANT_CODE = "STARTIMES";

	const ZUKU_SERVICE_ID = 35;
	const ZUKU_SERVICE_CODE = "ZUKU";
	const ZUKU_CODE = "ZUKU";
	const ZUKU_WALLET_MERCHANT_CODE = "ZUKU";

	const GOTV_SERVICE_ID = 34;
	const GOTV_SERVICE_CODE = "GOTVUG";
	const GOTV_CODE = "GOTVUG";
	const GOTV_WALLET_MERCHANT_CODE = "GOTVUG";

	const AZAM_SERVICE_ID = 790;
	const AZAM_SERVICE_CODE = "AZAM";
	const AZAM_CODE = "AZAM";
	const AZAM_WALLET_MERCHANT_CODE = "AZAM";

	const KWESE_SERVICE_ID = 834;
	const KWESE_SERVICE_CODE = "KWESETV";
	const KWESE_CODE = "KWESE";
	const KWESE_WALLET_MERCHANT_CODE = "KWESEUG";

	const BILLPAY_SERVICE = "BILL_PAY";
	const MAX_NARRATION_LENGTH = 50;

	const SAMPLEMSSDN = '256783262929';
	const USERNAME = "system-user";
	const PASSWORD = "lipuka";

	const WALLET_USERNAME = "admin";
	const WALLET_PASSWORD = "admin";

}

?>