<?php
/**
 * TaskFixture
 *
 */
class TaskFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'comment' => 'primary key', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'reference to user', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Title of task', 'charset' => 'utf8'),
		'comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => 'data and time for task'),
		'time' => array('type' => 'time', 'null' => true, 'default' => null, 'comment' => 'Flag for check time, if not set, task has only date'),
		'timeend' => array('type' => 'time', 'null' => true, 'default' => null),
		'datedone' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'order' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'key' => 'index', 'comment' => 'order for sorting tasks'),
		'done' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => 'Flag that task is done'),
		'future' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => 'flag that task is for future'),
		'deleted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'repeatid' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'key' => 'index', 'comment' => 'id of repeated task\'s series'),
		'transfer' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'count of transfer of task'),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'priority of task'),
		'day_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dateremind' => array('type' => 'date', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created date time '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified date time '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'date' => array('column' => 'date', 'unique' => 0),
			'order' => array('column' => 'order', 'unique' => 0),
			'repeatid' => array('column' => 'repeatid', 'unique' => 0),
			'user_date_order' => array('column' => array('user_id', 'date', 'order'), 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
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
			'id' => '51228719-0bb4-446c-8319-3259b43b9fe0',
			'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
			'title' => 'Lorem ipsum dolor sit amet',
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'date' => '2013-02-18',
			'time' => '19:55:05',
			'timeend' => '19:55:05',
			'datedone' => '2013-02-18 19:55:05',
			'order' => 1,
			'done' => 1,
			'future' => 1,
			'deleted' => 1,
			'repeatid' => 1,
			'transfer' => 1,
			'priority' => 1,
			'day_id' => 'Lorem ipsum dolor sit amet',
			'dateremind' => '2013-02-18',
			'created' => '2013-02-18 19:55:05',
			'modified' => '2013-02-18 19:55:05'
		),
	);

}
