 <?php

include_once '../GazProcessor.php';

class GazProcessorTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		// your code here
	}

	public function tearDown() {
		// your code here
	}

	//todo: intergration tests instead ::

	public function testComparesNumbers() {
		$instance = new GazProcessor();
		$this->assertTrue(1 == 1);
	}

}

?>
