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

	}

// testing  topup with invalid card
	public function testTopupWithInvalidCard() {

		$data = new stdClass;
		$data->beepTransactionID = "2333";
		$data->payerTransactionID = 122;

		$someJSON = '{"cardmask":"false","amount":"7837"}';

		$paymentExtraDat = $someJSON;
		$data->paymentExtraData = $paymentExtraDat;

		$responseData = $this->instance->processRecord($data);

		var_dump($responseData);

		$this->assertEquals(141, $responseData['statusCode']);

	}

// testing successful topup with valid card
	public function testTopupWithValidCard() {

		$data = new stdClass;
		$data->beepTransactionID = "2333";
		$data->payerTransactionID = 122;

		$someJSON = '{"cardmask":"G001","amount":"7837"}';

		$paymentExtraDat = $someJSON;
		$data->paymentExtraData = $paymentExtraDat;

		$responseData = $this->instance->processRecord($data);

		var_dump($responseData);

		$this->assertEquals(140, $responseData['statusCode']);

	}

}

?>
