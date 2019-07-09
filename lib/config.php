<?php

/**
 * This class holds the configuration settings.
 *
 * @category  Core
 * @package   Lib
 * @author    Daniel Mbugua <daniel.mbugua@cellulant.com>
 * @copyright 2013 Cellulant Ltd
 * @license   Proprietory License
 * @version   Release:3.0.0
 * @link      http://www.cellulant.com
 */

class Config {
	/**
	 * Array of special case wrappper classes according to the service
	 *
	 * @var array
	 */
	public static $INTEGRATION_CLASSES = array(
		'OPERABETZM' => 'JSONProcessor',
		'AIRTEL' => 'JSONProcessor',
		'NDASENDACOUNCIL' => 'NdasendaCouncilPaymentProcessor',
		//"NWC" => "NWCMochaProcessor",
		'KEMUZIKI' => 'MusicPaymentProcessor',
		"Azam_TigoPay" => "AzamWrapper",
		"KWESETV" => "KweseProcessor",
		"AZAMTV" => "AzamWrapper",
		"345" => "AzamWrapper",
		"UNILUS" => "UNILUSProcessor",
		"SMILE" => "MobistockProcessor",
		"AIRTELTOPUP" => "MobistockProcessor",
		"VODATOPUP" => "MobistockProcessor",
		"TIGOTOPUP" => "MobistockProcessor",
		"ZANTELTOPUP" => "MobistockProcessor",
		"STARTZ" => "MobistockProcessor",
		"DSTVTZ" => "MobistockProcessor",
		"CFCGHMOMOC2B2" => "CFCGHW2AProcessor",
		"GIZTOKENS" => "GIZPaymentPusher",
		//"STARTIMESKE"=>"StarTimesPaymentPusher",
		"STARTIMESKE" => "CFCPaymentsSimulator",
		"KQ" => "CFCPaymentsSimulator",
		"AIRTEL" => "CFCPaymentsSimulator",
		"ZUKUTV" => "ZukuPaymentPusher",
		"REUDS" => "EcobankProcessor",
		"NWC" => "NWCPaymentPusher",
		//"GOTVKE"=>"NWCPaymentPusher",
		"PDSLPOST" => "CFCPaymentsSimulator",
		"PDSLPRE" => "CFCPaymentsSimulator",
		//"PDSLPOST"=>"NWCPaymentPusher", //not this class has been commented and will always accept payments
		"MTNCraft" => "MTNC2BCraftProcessor",
		"ZESCO" => "AutoAcknowledgement",
//      "ZESCO" => "NecorZescoPaymentWrapper",
		//      "ZESCO" => "KazangZescoPayment",
		"ZAPTVMZ" => "LetshegoMZProcessor",
		"STARTIMESMZ" => "LetshegoMZProcessor",
		"MOVITELTR" => "LetshegoMZProcessor",
		//"ZukuStanbicUg" => "ZukuUgandaPaymentPusher",
		"BPCS" => "SandulelaPrepaidProcessor",
		// "BPCS"=>"BPCPrepaidProcessor",
		"LWZM" => "LWPaymentProcessor",
		'RCD' => 'RancardPaymentProcessor',
		'WAPIGO' => 'WapigoPaymentProcessor',
		'CfCC2B' => 'CfCWalletProcessor', //'WalletProcessor',
		'CfCC2B_TilltoBank' => 'CfCWalletProcessor',
		"ZUKUZM" => "AutoAcknowledgement",
		// "ZUKUZM"=>'ZukuZambiaPaymentPusher',
		"GOVKE" => "EablPaymentProcessor",
		"DTBC2B" => 'WalletProcessor',
		"STORIMOJA" => 'WalletProcessor',
		"DTBTZC2B" => 'WalletProcessor',
		"TIGOTZC2B" => 'WalletProcessor',
		"AMB2C" => 'WalletProcessor',
		"NHC2B" => 'WalletProcessor',
		"NGC2B" => 'WalletProcessor',
		"SBP" => "ejijiPayProcessor",
		"JPN" => 'ejijiPayProcessor',
		"DailyP" => 'ejijiPayProcessor',
		"JamboNwc" => 'ejijiPayProcessor',
		"JPLR" => 'ejijiPayProcessor',
		"JamboHM" => 'ejijiPayProcessor',
		"JWallet" => 'ejijiPayProcessor',
		"JPW" => 'ejijiPayProcessor',
		"SPkg" => 'ejijiPayProcessor',
		"SsnlPk" => 'ejijiPayProcessor',
		"JNHIF" => 'ejijiPayProcessor',
		"MAK" => "PegasusPaymentPusherWrapper",
		"KYU" => "PegasusPaymentPusherWrapper",
		"MUBS" => "PegasusPaymentPusherWrapper",
		"UMEME" => "PegasusPaymentPusherWrapper",
		"NWSC" => "PegasusPaymentPusherWrapper",
		"KCCA" => "PegasusPaymentPusherWrapper",
		"URA" => "PegasusPaymentPusherWrapper",
		"DSTV" => "AutoAcknowledgement", //"PegasusPaymentPusherWrapper",
		"GOTV" => "AutoAcknowledgement", //",PegasusPaymentPusherWrapper",
		"GOTVUG" => "AutoAcknowledgement",
		"BOAC2BAIR" => "PegasusPaymentPusherWrapper",
		"CFC_JAMBOPAY" => "WalletProcessor",
		"ZRACUSPAY" => "fetchAssesmentTPINProcessor",
		"ZRADOMPAY" => "fetchAssesmentPRNProcessor",
		"ZUKUUG" => "ZukuUGPaymentPusher",
		"BBKC2BPRE" => "BarclaysPaymentPusher", //barclays prepaid
		"3GDIRECT" => "GDirectPaymentPusher",
		"3GDirect" => "G3DirectPaymentPusher_UG",
		"MTNUG_CELL" => "MTNUG_CELLPaymentPusher",
		"3GDZM" => "GD3ProcessorZM",
		//"3GDZM"=>"ZMDirectPay",
		"NICC2B" => 'WalletProcessor',
		"REMOBI" => 'RemobiWalletProcessor',
		"ECOZIMC2B" => 'WalletProcessor',
		"NETZIMC2B" => 'SBAZWWalletProcessor',
		//"NETZIMC2B" => 'WalletProcessor',
		"ECGPOSTPAID" => 'ECGPostPaidProcessor',
		//'CFC_JAMBOPAY'=>'CFCJamboPayProcessor',
		"BOAC2B" => "BOAC2BPusher",
		"SCBC2B" => "SCBC2BPusher",
		"MOMOMTNA2W" => "NsanoA2WProcessor",
		"MOMOTIGOA2W" => "NsanoA2WProcessor",
		"MOMOAIRTELA2W" => "NsanoA2WProcessor",
		"SCM" => "marathonPaymentProcessor",
		//"ZIBFS"=> "ZIBFSProcessor",
		"ZIBFS" => "UnilusProcessor",
		"MEXSTTV" => "GroupAPaymentPusher",
		"MEXTELCEL" => "GroupAPaymentPusher",
		"MEXELEC" => "GroupAPaymentPusher",
		"MEXMOVIAIRTIME" => "GroupAPaymentPusher",
		"DTBPAMOJA" => "DTBPamojaPaymentPusher",
		"ZSCKAN" => "KazangZescoPayment",
		"MOBISTOCKBAL" => "MobistockProcessor",
		"MTNUG_NCBANK" => "WalletC2BProcessorNC",
		"AIRTELUG-NCBANK" => "AutoAcknowledgement", //"WalletC2BProcessorNC",
		"DTB_C2B_MTNUG" => "WalletC2BProcessorDTB",
		"DTB_C2B_AIRTEL" => "WalletC2BProcessorDTB",
		"DTBUG_VSLA_C2B" => "WalletC2BProcessorDTB",
		//"PrepaidZIM"=>"NettcashXMLPaymentProcessor",
		//"PrepaidZIM"=>"ZBPaymentProcessor",
		//"NETTCASHZESA"=>"NettcashXMLPaymentProcessor",
		"NIBC2B" => "NIBSOAPProcessor",
		"PrepaidZIM" => "TeloneZESAPaymentProcessor",
		"TELONE" => "TelonePaymentProcessor",
		"AIRTEL_CENT" => "CraftSiliconC2BProcessor",
		"AIRTELUG_PRIDE" => "CraftSiliconC2BProcessor",
		"MTNUG_CENT" => "CraftSiliconC2BProcessor",
		"MTNUG_PRIDE" => "CraftSiliconC2BProcessor",
		"MFAE" => "MallForAfricaProcessor",
		//"YumDel"=>"CheckoutPaymentPusher",
		"UAPPOLICY" => "UapPaymentProcessor",
		"StartimesZM" => "TopStarZMProcessor",
		// "StartimesZM"=>"StarTimesPaymentPusherZM",
		"Fastjet3G" => "FastJetPaymentProcessor",
		"HOTRECHARGE" => "HotRechargeProcessor",
		"NFCP" => "NFCProcessor",
		"B2iB" => "WalletProcessor",
		"EcoCards" => "WalletProcessor",
		"M0001" => "EablPaymentProcessor",
		"DSTVKE" => "AutoAcknowledgement", //Remove this...used to test
		"ORANGE" => "CFCPaymentsSimulator",
		"EABL" => "EablPaymentProcessor",
		//"MPESA" => "EablPaymentProcessor",
		"MPESA" => "CFCPaymentsSimulator",
		"KPLCPRE" => "CFCPaymentsSimulator",
		"KPLCPOST" => "CFCPaymentsSimulator",
		"STANLIBSIFT" => "DreamOvalProcessor",
		"DOSURFLINE" => "DreamOvalProcessor",
		"ALPHABETASCHL" => "DreamOvalProcessor",
		"CHRISTAMB" => "DreamOvalProcessor",
		"SLYDEPAY" => "DreamOvalProcessor",
		"APSU2001" => "DreamOvalProcessor",
		"DOVODAFONEPOSTPAID" => "DreamOvalProcessor",
		"JOYCEABABIO" => "DreamOvalProcessor",
		"STANLIBSCT" => "DreamOvalProcessor",
		"DOGLOAIRTIME" => "DreamOvalProcessor",
		"VODAMPESATZ" => "PaymentRouterProcessor",
		"BRANCHC2B" => "PaymentRouterProcessor",
		"MTNZMWALLETTOBANK" => "PaymentRouterProcessor",
		'ADTPRP' => 'AdtelPrepaidPusher',
		'ADTPSP' => 'AdtelPostpaidPusher',
		'GRDWP' => 'GRDWrapper',
		'ZOL' => 'ZOLPaymentProcessor',
		'DTBNWC' => 'NWSCPaymentPusher',
		'TELONEZESA' => 'TeloneZESAPaymentProcessor',
		"HOTRECHARGEBUNDLES" => "HotRechargeDataBundlesProcessor",
		'Teloneprocess' => 'TelonePaymentProcessor',
		'KITDS254' => 'BulkSMSCPG', //'KitsDemoWrapper',
		'NANYUKI_WATER' => 'NanyukiWaterProcessor',
		'MCHANGA' => 'KCBMchangaPaymentWrapper',
		'TIGORWAIRTIME' => 'PivotJSONProcessor',
		'AIRTELRWAIRTIME' => 'PivotJSONProcessor',
		'MTNRWAIRTIME' => 'PivotJSONProcessor',
		'ELECTRICTYRW' => 'PivotJSONProcessor',
		'STARTTIMESRW' => 'PivotJSONProcessor',
		//'BLKCRDTS' => 'BulkSMSCPG',
		"ECONETTOPUPZIM" => "HotRechargeProcessorBBZW",
		"ECONET" => "HotRechargeProcessor",
		"TELECELL" => "HotRechargeProcessor",
		"NETONE" => "HotRechargeProcessor",
		"ZESA" => "TeloneZESAPaymentProcessor",
		"TELPHONE" => "TelonePaymentProcessor",
		"TELADSL" => "TelonePaymentProcessor",
		"TELWIFI" => "TelonePaymentProcessor",
		"TELADSLVOUCHER" => "TelonePaymentProcessor",
		"BPOST" => "BPostProcessorNew",
		"DSTVZM" => "multichoiceProcessorZM",
		"GOTVZM" => "multichoiceProcessorZM",
		'PowerTel' => 'PowerTelPaymentProcessor',
		'EDGARS' => 'EdgarsPaymentProcessor',
		'JET' => 'EdgarsPaymentProcessor',
		// 'DOVES' => 'DovesProcessor',
		'DOVES' => 'DovesPaymentProcessor',
		'B2C_VSLA' => 'DTBUG_VSLA_processor',
		//Nigeria airtime
		"NGMTNAIRTIME" => "NigeriaGETAirtimeProcessorDirect",
		"NGAIRTELAIRTIME" => "NigeriaGETAirtimeProcessorDirect",
		"NGGLOAIRTIME" => "NigeriaGETAirtimeProcessorDirect",
		"NGETISALATAIRTIME" => "NigeriaGETAirtimeProcessor",
		"NGMONEYTRANSFER" => "NigeriaGETCashRemittances",
		"BBKC2B" => "BarclaysPaybillProcessor",
		"BBKRTS" => "BarclaysRTSProcessor",
		"BBKRP" => "BarclaysRetailProcessor",
		"EmolaTest" => "BarclaysMZProcessor",
		'ETSBOOKTZ' => 'ETSPaymentPusher',
		//Ecobank cranes campaign
		"ECOBANKCAMP" => "EcobankCranesCampaignPusher",
//      "KWESE" => "KweseProcessor",
		"CONSOLATA_SHRINE" => "ConsolataWrapper",
		"VODAFONEZMRECHARGE" => "VodafoneZMValueRechargeProcessor",
		"VODAFONEZMBUNDLE" => "VodafoneZMBundleRechargeProcessor",
		"ECOBANKKEC2B" => "EcobankKEC2BProcessor",
		"AIRTELKEC2BECO" => "EcobankKEC2BProcessor",
		"AIRTELTOPUPZM" => "ZMAirtimeProcessor",
		"ZAMTELTOPUPZM" => "ZMAirtimeProcessor",
		"MTNTOPUPZM" => "ZMAirtimeProcessor",
		"LUAPULAWATERZM" => "AutoAcknowledgement",
		"WUC" => "WUCProcessor",
		"DSTVUG" => "AutoAcknowledgement",
		"AIRTELC2B_EUG" => "EcobankUGC2BProcessor",
		"MTNUG_EUG" => "EcobankUGC2BProcessor",
		"AZAM_PAY_UG" => "AzamUgPaymentPusher",
		"AzamUG" => "AzamUgPaymentPusher",
		//letshego Namibia
		"WALVISBAY" => "MobipayProcessor",
		"BOXOFFICE" => "MobipayProcessor",
		// "GOTV"=>"MobipayProcessor",
		"DSTV" => "MobipayProcessor",
		"JJKE" => "MobipayWalletProcessor",
		"MULACREDIT" => "MulaLoanPaymentPusher",
		"BOAC2BCO" => "BOAC2BWrapper",
		"AIRTELDATA" => "AirtelDataPaymentPusher",
		'NDASENDAZESA' => 'TeloneZESAPaymentProcessor', //'NdasendaZESAPaymentProcessor',
		"UBAZMC2B" => "UMobileC2BProcessor",
		"UMOBILEPULL" => "UMobileB2CProcessor",
		"BOAC2BAIR" => "BOAC2BAirtelPaymentProcessor",
		"AIRTELKEC2BECO" => "EcobankKEC2BProcessor",
		"StartimesTZPayTv" => "StarTimesPaymentPusherTZ",
		"SHPAY" => "SemaTimeProcessor",
		"busygh" => "MOMOGHProcessor",
		"surflinegh" => "MOMOGHProcessor",
		//"surflinegh"=>"EtranzactProcessor",
		/** This is for simulation purposes, simulates failed or succcess
		Confirm with Justun before changing*/
		"YOC2B" => 'YOB2CPaymentProcessor',
		"MTNUGB2C" => 'YOB2CPaymentProcessor',
		"AIRTELUGB2C" => 'YOB2CPaymentProcessor',
		"SAFCOM" => "SimulateMNOResponse",
		"VODATOPUPTZ" => "SimulateMNOResponse",
		"REEDEV1825" => "CheckoutProcessor",
		"JAMDEV3763" => "CheckoutProcessor",
		"TRADEV0809" => "CheckoutProcessor",
		"SETDEV9207" => "CheckoutProcessor",
		"BOODEV1555" => "CheckoutProcessor",
		"AIRDEV7388" => "CheckoutProcessor",
		"REEDEV1825" => "CheckoutProcessor",
		"TICDEV0854" => "CheckoutProcessor",
		"REGDEV4801" => "CheckoutProcessor",
		"TENDEV1989" => "CheckoutProcessor",
		"MYNDEV8731" => "CheckoutProcessor",
		"MULAAIRTIME" => "CheckoutProcessor",
		"SWADEV9830" => "CheckoutProcessor",
		"PESDEV8071" => "CheckoutProcessor",
		"PESDEV6277" => "CheckoutProcessor",
		"FEDDEV9602" => "CheckoutProcessor",
		"SUPDEV6921" => "CheckoutProcessorV2",
		"EDUSBX7697" => "CheckoutProcessorV2",
		"BTA" => "BarclaysTillAutomationProcessor",
		"ALTXCOLL" => "NCMerchantPaymentProcessor", //"NGMTNAIRTIME"=>"SimulateMNOResponse",
		"MULA_NC_COMMISIONS" => "NCMerchantPaymentProcessor",
		"NC_COMMISSIONS" => "NCMerchantPaymentProcessor",
		"NC_EXCISE_DUTY" => "NCMerchantPaymentProcessor",
		//"NGAIRTELAIRTIME"=>"SimulateMNOResponse",
		//"NGGLOAIRTIME"=>"SimulateMNOResponse",
		//"NGETISALATAIRTIME"=>"SimulateMNOResponse",
		"NYRLND" => "NyeriCountyProcessor",
		"NYERIPARK" => "NyeriCountyProcessor",
		"ZRA_tax" => "ZRAPaymentPusher",
		"AUTOTOPUP" => "AutoPayProcessor",
		"BBKLOAN" => "BarclaysLoanProcessor",
		"CEVA" => "CEVAPaymentProcessor",
		"MTNRWC2B" => "MTNPaymentPusher",
		"MTNC2BDEBIT" => "MTNPaymentPusher",
		"MTNRWB2C" => "MTNPaymentPusher",
		'MPESAB2CKE' => 'MPESAB2CSimulationPusher',
		"MTNZMBANKTOWALLET" => "AutoAcknowledgement",
		"AIRTELZMBANKTOWALLET" => "AutoAcknowledgement",
		//"BBZMC2B"=>"AutoAcknowledgement",
		"BBZMC2B" => "BarclaysZMProcessor",
		"HORIZONFEES" => "AutoAcknowledgement",
		"BOAB2B" => "BOAB2BPaymentProcessor",
		"STARTIMESUG" => "AutoAcknowledgement",
		"StartTimesUG" => "AutoAcknowledgement",
		"ZUKUUG" => "AutoAcknowledgement",
		"GOTV" => "AutoAcknowledgement",
		"KWESE" => "AutoAcknowledgement",
		"BOAMERCHANT" => "BOAC2BMerchantProcessor",
		"CECLIQUID" => "CECLiquidPaymentProcessor",
		"GCS" => "MulaWalletC2BProcessor",
		"CREDELEC" => "CredelecProcessor",
		"GOTVKE" => "CFCPaymentsSimulator",
		"AUTOTOPUP" => "AutoPayProcessor",
		"GLOAIRTIME" => "MobipayProcessorGroup",
		"GROUP3" => "Group3PushPaymentWrapper",
		"TELCELAIRTIME" => "MexicoPaymentPusherWrapper",
		"MOVISTARAIRTIME" => "MexicoPaymentPusherWrapper",
		"GOTVMEXICO" => "MexicoPaymentPusherWrapper",
		"DSTVMEXICO" => "MexicoPaymentPusherWrapper",
		"ELECMEXICO" => "MexicoPaymentPusherWrapper",
		"MOVIAIR" => "GroupAPaymentPusher",
		"TELAIR" => "GroupAPaymentPusher",
		"SSTV" => "GroupAPaymentPusher",
		"PREPEL" => "GroupAPaymentPusher",
		"VIRGAIR" => "GroupAPaymentPusher",
		"ATNTAIR" => "GroupAPaymentPusher",
		"BRLR" => "BotswanaTransportProcessor",
		"BTF" => "BotswanaTransportProcessor",
		"CardValidation" => "CardReversalProcessor",
		"TLKMPST" => "TelkomPostPaidProcessor",
		"PINRESET" => "PinResetProcessor",
		//      "DYNAMO" => "KPLCDynamoPaymentPusher",
		"DYNAMO" => "TKashAsyncB2CProcessor",
		"KZNGB2C" => "KazangZambiaMoneyTransfer",
		"MulaZMB2C" => "MulaB2CProcessor",
		"GroupsC2B" => "GroupsC2BProcessor",
		"MulaZMC2B" => "MulaWalletZambiaC2BProcessor",
//      "KZNGB2C"=>"AutoAcknowledgement",
		"1852" => "mulaAgentProcessor",
		"SIMBISA" => "SimbisaPaymentsPusher",
		"SAFTOPUP" => "CFCPaymentsSimulator",
		"MPESAB2C" => "CFCPaymentsSimulator",
		"MUVITV" => "AutoAcknowledgement",
		"CENE" => "CeneMediaWrapper",
		"FLUTTERCOLLECTION" => "UGMomoCheckoutProcessor",
		"POWERGEN" => "PowerGenPaymentPusher",
		//"TZGOVTPAYMENTS"=>"TZGOVTPaymentProcessor",
		"TZGOVTPAYMENTS" => "MobistockProcessor",
		// "MZDSGO"=>"DstvMZProcessor",
		"MZLETSHEGOTOPUP" => "DSTVMZPaymentProcessor",
		"MCALEN" => "MultiChoiceC2BProcessor",
		//"LUKU"=>"LUKUPaymentPusherWrapper",
		"MTN_BENIN" => "DingProcessor",
		"MOOV_BENIN" => "DingProcessor",
		"MALITEL_MALI" => "DingProcessor",
//      "BBI"=>"BBIProcessor",
		"AGUAS" => "Aguas",
//      "idealPrepaid"=>"idealPrepaidProcessor",
		"BBI" => "idealPrepaidProcessor",
		"KE_SIMBISA_CO" => "CombinedWrapper",
		"ECOBANK_C2B" => "EcobankUGC2BMTNProcessor",
		"ORYX_FUEL_PAY" => "ORYXProcessor",
		"MULAASSIST" => "MulaAssistRepaymentProcessor",
		"PAY077PAY077" => "GazProcessor", // gaz pay
	);
	/**
	 * File location for info logs.
	 *
	 * @var string
	 */

	const INFO = "/var/log/applications/ke/hub4/hubServices/PaymentPusherWrappers/info.log";
	/**
	 * File location for error logs.
	 *
	 * @var string
	 */
	const ERROR = "/var/log/applications/ke/hub4/hubServices/PaymentPusherWrappers/error.log";
	/**
	 * File location for fatal logs.
	 *
	 * @var string
	 */
	const FATAL = "/var/log/applications/ke/hub4/hubServices/PaymentPusherWrappers/fatal.log";
	/**
	 * File location for debug logs.
	 *
	 * @var string
	 */
	const DEBUG = "/var/log/applications/ke/hub4/hubServices/PaymentPusherWrappers/debug.log";
	/**
	 * Function to be run in the PostC2BScript Class
	 *
	 * @var string
	 */
	const POST_STATUS_FUNCTION = "processPayment";
	/**
	 * The authentication success code.
	 *
	 * @var int
	 */
	const AUTHENTICATION_SUCCESS = 131;
	/**
	 * The authentication failure code.
	 *
	 * @var int
	 */
	const AUTHENTICATION_FAILED = 132;
	/**
	 * Generic error failure code.
	 *
	 * @var int
	 */
	const GENERIC_FAILURE = 174;
	/**
	 * Push status success code.
	 *
	 * @var int
	 */
	const PUSH_STATUS_SUCESS = 188;
	/**
	 * Push status failed code up for a retry.
	 *
	 * @var int
	 */
	const PUSH_STATUS_FAILED_RETRY = 189;
	/**
	 *Maximum Time for retry
	 *
	 */
	const AllocatedTimeForRetry = 2000;
	/**
	 * Push status payment accepted code
	 *
	 * @var int
	 */
	const PUSH_STATUS_PAYMENT_ACCEPTED = 140;
	/**
	 * Push status payment rejected code
	 *
	 * @var int
	 */
	const TRANSACTION_CLIENT_ACK_OK = 183;
	/**
	 * Payment acknowleged by clinet as received.
	 *
	 * @var int
	 */

	const PUSH_STATUS_PAYMENT_REJECTED = 141;
	/**
	 * Push status payment rejected code
	 *
	 * @var int
	 */
	const PUSH_STATUS_PAYMENT_ESCALTE = 219;
	/**
	 * Encryption Secret Key.
	 *
	 * @var string
	 */
	const SECRET_KEY = "3c6e0b8a9c15224a";

	/**
	 * Encryption initialis ation vector.
	 *
	 * @var string
	 */
	const INITIALISATION_VECTOR = "8228b9a98ca15318";

	/**
	 * Function to be run in the Integration PostC2BScript Class
	 *
	 * @var string
	 */
	const POST_MTN_C2B_CRAFT_FUNCTION = "processRecord";
	/**NETTCASH SETTINGS
		     * Customer Information Merchant ID
		     *
		     * @var int
	*/
	const CUSTOMER_INFORMATION_MERCHANT_ID = 2529689904912194;
	/**
	 * Token Purchase Merchant ID
	 *
	 * @var int
	 */
	const TOKEN_PURCHASE_MERCHANT_ID = 2277420024775776;
	/**
	 * Token Purchase Merchant ID
	 *
	 * @var int
	 */
	const TOKEN_RESEND_MERCHANT_ID = 2079874004940255;
	/**
	 * AGENT ID
	 *
	 * @var int
	 */
	const AGENT_ID = 3166866675820088;
	/**
	 * AGENT ID
	 *
	 * @var string
	 */
	const PASSWORD = 'cellulant1986$32';
	/**
	 * PAYMENT METHOD
	 *
	 * @var string
	 */
	const PAYMENT_METHOD = 'cash';
	/**
	 * TRANSACTION MODE
	 *
	 * @var string
	 */
	const TRANSACTION_MODE = 'transaction';
	/**
	 * TRANSACTION MODE
	 *
	 * @var string
	 */
	const TOKEN_RESEND_AMOUNT = '0';
	/**
	 * NETTCASH ZESA URL
	 *
	 * @var string
	 */
	const NETTCASH_ZESA_URL = 'https://integrationhub.nettcash.co.zw:8444/agenthub/test/api/tpcustomerinformation.php?';
	/**
	 * NETTCASH ZESA TOKEN PURCHASE URL
	 *
	 * @var string
	 */
	const NETTCASH_ZESA_TOKEN_URL = 'https://integrationhub.nettcash.co.zw:8444/agenthub/test/api/tppaybill.php?';
	/**
	 * NETTCASH ZESA TOKEN RESEND PURCHASE URL
	 *
	 * @var string
	 */
	const NETTCASH_ZESA_TOKEN_RESEND_URL = 'https://integrationhub.nettcash.co.zw:8444/agenthub/test/api/tppaybill.php?';
}