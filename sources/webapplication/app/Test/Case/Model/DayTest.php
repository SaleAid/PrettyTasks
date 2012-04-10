<?php
App::uses('Day', 'Model');

/**
 * Day Test Case
 *
 */
class DayTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.day', 'app.user', 'app.account');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Day = ClassRegistry::init('Day');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Day);

		parent::tearDown();
	}

}
