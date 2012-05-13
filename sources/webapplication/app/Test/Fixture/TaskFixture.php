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
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'comment' => 'primary key'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index', 'comment' => 'reference to user'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'task\'s title', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL, 'key' => 'index', 'comment' => 'data and time for task'),
		'time' => array('type' => 'time', 'null' => true, 'default' => NULL, 'comment' => 'Flag for check time, if not set, task has only date'),
		'timeend' => array('type' => 'time', 'null' => true, 'default' => NULL),
		'datedone' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'order' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'key' => 'index', 'comment' => 'order for sorting tasks'),
		'done' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => 'Flag that task is done'),
		'future' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'comment' => 'flag that task is for future'),
		'repeatid' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'key' => 'index', 'comment' => 'id of repeated task\'s series'),
		'transfer' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'count of transfer of task'),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'priority of task'),
		'day_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'dateremind' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'created date time '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'modified date time '),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'date' => array('column' => 'date', 'unique' => 0), 'order' => array('column' => 'order', 'unique' => 0), 'repeatid' => array('column' => 'repeatid', 'unique' => 0), 'user_date_order' => array('column' => array('user_id', 'date', 'order'), 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'date' => '2012-05-13',
			'time' => '23:38:38',
			'timeend' => '23:38:38',
			'datedone' => '2012-05-13 23:38:38',
			'order' => 1,
			'done' => 1,
			'future' => 1,
			'repeatid' => 1,
			'transfer' => 1,
			'priority' => 1,
			'day_id' => 1,
			'dateremind' => '2012-05-13',
			'created' => '2012-05-13 23:38:38',
			'modified' => '2012-05-13 23:38:38'
		),
		array(
			'id' => 2,
			'user_id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'date' => '2012-05-13',
			'time' => '23:38:38',
			'timeend' => '23:38:38',
			'datedone' => '2012-05-13 23:38:38',
			'order' => 1,
			'done' => 1,
			'future' => 1,
			'repeatid' => 1,
			'transfer' => 1,
			'priority' => 1,
			'day_id' => 1,
			'dateremind' => '2012-05-13',
			'created' => '2012-05-13 23:38:38',
			'modified' => '2012-05-13 23:38:38'
		),
		array(
			'id' => 3,
			'user_id' => 2,
			'title' => 'Lorem ipsum dolor sit amet',
			'date' => '2012-05-13',
			'time' => '23:38:38',
			'timeend' => '23:38:38',
			'datedone' => '2012-05-13 23:38:38',
			'order' => 1,
			'done' => 1,
			'future' => 1,
			'repeatid' => 1,
			'transfer' => 1,
			'priority' => 1,
			'day_id' => 1,
			'dateremind' => '2012-05-13',
			'created' => '2012-05-13 23:38:38',
			'modified' => '2012-05-13 23:38:38'
		),
		array(
			'id' => 4,
			'user_id' => 2,
			'title' => 'Lorem ipsum dolor sit amet',
			'date' => '2012-05-13',
			'time' => '23:38:38',
			'timeend' => '23:38:38',
			'datedone' => '2012-05-13 23:38:38',
			'order' => 1,
			'done' => 0,
			'future' => 1,
			'repeatid' => 1,
			'transfer' => 1,
			'priority' => 1,
			'day_id' => 1,
			'dateremind' => '2012-05-13',
			'created' => '2012-05-13 23:38:38',
			'modified' => '2012-05-13 23:38:38'
		),
	);
}
