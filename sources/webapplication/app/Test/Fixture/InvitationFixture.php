<?php
/**
 * InvitationFixture
 *
 */
class InvitationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 400, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'comment' => 'email of invited user', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'comment' => 'user\'s id who invite other user'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Creation time'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'email' => array('column' => 'email', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'created' => '2012-05-20 06:01:27'
		),
	);
}
