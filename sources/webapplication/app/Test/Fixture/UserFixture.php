<?php
/* User Fixture generated on: 2012-02-08 17:53:48 : 1328712828 */

/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'cp1251_general_ci', 'comment' => '', 'charset' => 'cp1251'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'cp1251_general_ci', 'comment' => '', 'charset' => 'cp1251'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'collate' => 'cp1251_general_ci', 'comment' => '', 'charset' => 'cp1251'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'cp1251_general_ci', 'comment' => '', 'charset' => 'cp1251'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'cp1251', 'collate' => 'cp1251_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet'
		),
	);
}
