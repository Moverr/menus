 <?php

include_once './GazProccessorCaller.php';

class GazProcessorTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		// your code here
	}

	public function tearDown() {
		// your code here
	}

	//todo: intergration tests instead ::

	public function testValidCardNumber() {
		print_r("Test  if card is valid");

		$instance = new GazProccessorCaller();
		$response = $instance->init("G002");

		$statusCode = $response->results[0]->statusCode;

		var_dump($response->results[0]->statusCode);

		$this->assertEquals(307, $statusCode);

	}

	public function testInvalidCardNumber() {
		print_r("Test  if card is Invalid ");

		$instance = new GazProccessorCaller();
		$response = $instance->init("invalidNumber");

		$statusCode = $response->results[0]->statusCode;

		var_dump($response->results[0]->statusCode);

		$this->assertEquals(174, $statusCode);

	}

}

?>
