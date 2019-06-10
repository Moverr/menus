 <?php

include_once './../GazProcessor.php';

class GazProcessorTest extends PHPUnit_Framework_TestCase {

	private $instance = null;
	public function setUp() {

		$instance = new GazProcessor();
		$observer = $this->getMockBuilder(BeepLogger::class)
			->setMethods(['update'])
			->getMock();

		$instance->attach($observer);

		$this->instance = $instance;

	}

	public function tearDown() {
		// your code here

	}

	public function testPushAndPop() {

		$data = array('mosee', 'meoe');
		$this->instance->processRecord($data);
		$stack = [];
		$this->assertSame(0, count($stack));

		array_push($stack, 'foo');
		$this->assertSame('foo', $stack[count($stack) - 1]);
		$this->assertSame(1, count($stack));

		$this->assertSame('foo', array_pop($stack));
		$this->assertSame(0, count($stack));
	}

}

?>
