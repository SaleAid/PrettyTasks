<?php
App::uses('Acategory', 'Model');

/**
 * Acategory Test Case
 *
 */
class AcategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acategory',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Acategory = ClassRegistry::init('Acategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Acategory);

		parent::tearDown();
	}

}
