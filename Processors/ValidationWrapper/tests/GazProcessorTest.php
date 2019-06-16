 <?php

include_once './../GazProcessor.php';

class GazProcessorTest extends PHPUnit_Framework_TestCase {

	private $instance = null;
	public function setUp() {

		$instance = new GazProcessor();
		$observer = $this->getMockBuilder(BeepLogger::class)
			->setMethods(['info', 'printArray'])
			->getMock();

		$instance->attachBeepLogger($observer);

		$this->instance = $instance;

	}

	public function tearDown() {
		// your code here
		$this->instance = null;

	}

// testing CARD VALIDATION WITH VALID CARD
	public function testValidationWithCorrectCard() {

		$data = new stdClass;
		$data->beepTransactionID = "2333";
		$data->payerTransactionID = 122;
		$data->accountNumber = "G002";

		$someJSON = '{"cardmask":"false","amount":"7837"}';

		$paymentExtraDat = $someJSON;
		$data->paymentExtraData = $paymentExtraDat;

		$responseData = $this->instance->processRecord($data);

		var_dump($responseData);

		$this->assertEquals(131, $responseData['statusCode']);

	}

// TESTING CARD VALIDATION WITH INVALID CARD
	public function testValidationWithInvalidCard() {

		$data = new stdClass;
		$data->beepTransactionID = "2333";
		$data->payerTransactionID = 122;
		$data->accountNumber = "INVALID";

		$someJSON = '{"cardmask":"false","amount":"7837"}';

		$paymentExtraDat = $someJSON;
		$data->paymentExtraData = $paymentExtraDat;

		$responseData = $this->instance->processRecord($data);

		var_dump($responseData);

		$this->assertEquals(132, $responseData['statusCode']);

	}

}

?>
