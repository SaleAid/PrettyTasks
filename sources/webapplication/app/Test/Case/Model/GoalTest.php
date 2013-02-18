<?php
App::uses('Goal', 'Model');

/**
 * Goal Test Case
 *
 * @property Goal $Goal
 */
class GoalTest extends CakeTestCase {
	
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
			'app.goal',
			'app.user'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Goal = ClassRegistry::init('Goal');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Goal);
		
		parent::tearDown();
	}

	public function testEmpty() {
	}

	public function testGetGoals() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$goals = $this->Goal->getGoals($user_id);
		$expected = array(
				0 => array(
						$this->Goal->alias => array(
								'id' => '51223d84-365c-419b-8705-20a9b43b9fe6',
								'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
								'title' => 'Goal 7',
								'comment' => 'Goal 7 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
								'fromdate' => null,
								'todate' => null,
								'datedone' => null,
								'done' => '0',
								'deleted' => '0'
						)
				)
		);
		$this->assertEqual($goals, $expected);
		//With dates, empty results
		$goals = $this->Goal->getGoals($user_id, '2013-01-01', '2013-01-10');
		$expected = array();
		$this->assertEqual($goals, $expected);
		//With dates, not empty results
		//$goals = $this->Goal->getGoals($user_id, '2013-02-01', '2013-02-30');
		//debug($goals);
		//$expected = array();
		//$this->assertEqual($goals, $expected);
	}
}
