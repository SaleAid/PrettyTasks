<?php
App::uses('Day', 'Model');

/**
 * Day Test Case
 *
 * @property Day $Day
 *          
 */
class DayTestCase extends CakeTestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
			'app.day',
			'app.user',
			'app.account'
	);

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

	public function testEmpty() {
	}

	/**
	 * Test function isDayFound
	 */
	public function test_isDayFound() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$this->Day->create();
		$day = $this->Day->isDayFound($user_id, '2013-02-04');
		$this->assertTrue(! empty($day[$this->Day->alias]['id']));
		$expected = array(
				'Day' => array(
						'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
						'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
						'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
						'rating' => '1',
						'date' => '2013-02-04'
				)
		);
		$this->assertEqual($day, $expected);
		$this->Day->create();
		$day2 = $this->Day->isDayFound($user_id, '2013-02-03');
		$this->assertFalse($day2);
		
		$expected = array(
				'Day' => array(
						'date' => '2013-02-03',
						'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
						'rating' => 0
				)
		);
		$this->assertEqual($this->Day->data, $expected);
	}

	/**
	 * test function setRating
	 */
	public function test_setRating() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		// Test null value
		$this->Day->create();
		$this->Day->setRating($user_id, '2013-02-04');
		$this->assertTrue($this->Day->data[$this->Day->alias]['rating'] === null, 'Error on NULL value');
		
		// Test 0 value
		$this->Day->create();
		$this->Day->setRating($user_id, '2013-02-04', 0);
		$this->assertTrue($this->Day->data[$this->Day->alias]['rating'] === 0, 'Error on 0 value');
		
		// Test 1 value
		$this->Day->create();
		$this->Day->setRating($user_id, '2013-02-04', 1);
		$this->assertTrue($this->Day->data[$this->Day->alias]['rating'] === 1, 'Error on 1 value');
		
		// Test with saving
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['rating'] == 1);
		// For 0 value
		$this->Day->setRating($user_id, '2013-02-04', 0)->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['rating'] == 0);
		// For NULL value
		$this->Day->setRating($user_id, '2013-02-04')->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['rating'] === null);
		// For 1 value
		$this->Day->setRating($user_id, '2013-02-04', 1)->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['rating'] == 1);
	}

	/**
	 * test function setRating
	 */
	public function test_setComment() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		// Test null value
		$this->Day->create();
		$this->Day->setComment($user_id, '2013-02-04');
		$this->assertTrue($this->Day->data[$this->Day->alias]['comment'] === null, 'Error on NULL value');
		
		// Test 0 value
		$this->Day->create();
		$this->Day->setComment($user_id, '2013-02-04', 0);
		$this->assertTrue($this->Day->data[$this->Day->alias]['comment'] === 0, 'Error on 0 value');
		
		// Test 1 value
		$this->Day->create();
		$this->Day->setComment($user_id, '2013-02-04', 1);
		$this->assertTrue($this->Day->data[$this->Day->alias]['comment'] === 1, 'Error on 1 value');
		
		// Test with saving
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['comment'] == 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.');
		// For 0 value
		$this->Day->setRating($user_id, '2013-02-04', 0)->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['comment'] == 0);
		// For NULL value
		$this->Day->setComment($user_id, '2013-02-04')->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['comment'] === null);
		// For 1 value
		$this->Day->setComment($user_id, '2013-02-04', 1)->save();
		$this->Day->create();
		$this->Day->contain();
		$day = $this->Day->read(null, '510fcd9b-7858-455d-8316-1666b43b9fe0');
		$this->assertTrue($day[$this->Day->alias]['comment'] == 1);
		// echo String::uuid();
	}

	/**
	 * Test for function getDays.
	 */
	public function test_getDays() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$days = $this->Day->getDaysRating($user_id, $from = '2013-01-04'); // TODO function call after rename function in model // Rename
		$expected = array(
				'2013-01-04' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe3',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
										'rating' => '0',
										'date' => '2013-01-04'
								)
						)
				)
		);
		$this->assertEqual($days, $expected);
		
		$days = $this->Day->getDaysRating($user_id, $from = '2013-01-04', $to = '2013-01-15'); // TODO function call after rename function in model // Rename
		$expected = array(
				'2013-01-04' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe3',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
										'rating' => '0',
										'date' => '2013-01-04'
								)
						)
				),
				'2013-01-05' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe4',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => null,
										'rating' => '1',
										'date' => '2013-01-05'
								)
						)
				)
		);
		$this->assertEqual($days, $expected);
		
		$days = $this->Day->getDaysRating($user_id, $from = '2013-01-04', $to = '2013-01-15', array(
				'2013-02-04',
				'2013-02-05'
		)); // TODO function call after rename function in model // Rename
		$expected = array(
				'2013-01-04' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe3',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
										'rating' => '0',
										'date' => '2013-01-04'
								)
						)
				),
				'2013-01-05' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe4',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => null,
										'rating' => '1',
										'date' => '2013-01-05'
								)
						)
				),
				'2013-02-04' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
										'rating' => '1',
										'date' => '2013-02-04'
								)
						)
				),
				'2013-02-05' => array(
						array( // Remove this array after fix
								'Day' => array(
										'id' => '510fcd9b-7858-455d-8316-1666b43b9fe2',
										'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
										'comment' => 'Comment for 2013-02-05. Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
										'rating' => '0',
										'date' => '2013-02-05'
								)
						)
				)
		);
		$this->assertEqual($days, $expected);
	}

	/**
	 * Test for function getComment.//TODO Rename function
	 */
	public function test_getComment() { // TODO Rename function
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$date = '2013-02-04';
		$comment = $this->Day->getComment($user_id, $date); // TODO Rename function
		$expected = array(
				'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
				'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
				'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
				'rating' => '1',
				'date' => '2013-02-04'
		);
		$this->assertEqual($comment, $expected);
		//
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$date = '2013-02-03';
		$comment = $this->Day->getComment($user_id, $date); // TODO Rename function
		$expected = array(
				'comment' => '',
				'rating' => 0,
				'date' => '2013-02-03'
		);
		$this->assertEqual($comment, $expected);
	}

	/**
	 * Test for function getComments.
	 */
	public function test_getComments() {
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$date = '2013-02-04';
		$comments = $this->Day->getComments($user_id, null, '2013-02-04');
		$expected = array(
				array(
						'Day' => array(
								'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
								'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
								'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
								'rating' => '1',
								'date' => '2013-02-04'
						)
				)
				,
				array(
						'Day' => array(
								'id' => '510fcd9b-7858-455d-8316-1666b43b9fe3',
								'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
								'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
								'rating' => '0',
								'date' => '2013-01-04'
						)
				)
				
		);
		$this->assertEqual($comments, $expected);
		//
		$user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
		$date = '2013-02-04';
		$count = 1;
		$comments = $this->Day->getComments($user_id, $count, '2013-02-04');
		$expected = array(
				array(
						'Day' => array(
								'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
								'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
								'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
								'rating' => '1',
								'date' => '2013-02-04'
						)
				)		
		);
		$this->assertEqual($comments, $expected);
	}
}
