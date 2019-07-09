 <?php

include_once './paymentPusher.php';

use PHPUnit\Framework\TestCase;

class PaymentPusherTest extends TestCase {

	private $instance = null;
	public function setUp() {

		$instance = new PaymentPusher();
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

	 
	public function testPayment() {

		$data = new stdClass;
		$data->beepTransactionID = "2333";
		$data->payerTransactionID = 122;
		$data->accountNumber = "0779820962";
		$data->amount = 122;

		$someJSON = '{"productid":"7","serviceprovider":"1","duration":"1"}';

		$paymentExtraDat = $someJSON;
		$data->paymentExtraData = $paymentExtraDat;

		$responseData = $this->instance->processRecord($data);

		// var_dump($responseData);

		$this->assertEquals(140, $responseData['statusCode']);

	}

}

?>
