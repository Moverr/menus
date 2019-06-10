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

	public function testComparesNumbers() {
		$instance = new GazProccessorCaller();
		$this->assertTrue(1 == 1);
	}

}

?>
