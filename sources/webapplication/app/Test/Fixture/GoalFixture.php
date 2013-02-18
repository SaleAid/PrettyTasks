<?php
/**
 * GoalFixture
 *
 */
class GoalFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'comment' => 'primary key', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Title of goal', 'charset' => 'utf8'),
		'comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fromdate' => array('type' => 'date', 'null' => true, 'default' => null),
		'todate' => array('type' => 'date', 'null' => true, 'default' => null),
		'datedone' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'done' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => 'Flag that goal is done'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '51223d84-365c-419b-8705-20a9b43b9fe0',
			'title' => 'Lorem ipsum dolor sit amet',
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'fromdate' => '2013-02-18',
			'todate' => '2013-02-18',
			'datedone' => '2013-02-18 14:41:08',
			'done' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-02-18 14:41:08',
			'modified' => '2013-02-18 14:41:08'
		),
	);

}
