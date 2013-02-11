<?php
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
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'comment' => 'primary key', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'username', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'comment' => 'password', 'charset' => 'utf8'),
		'password_token' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => '      password_token', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'user name', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'user last name', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'user email', 'charset' => 'utf8'),
		'activate_token' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => 'activate_token', 'charset' => 'utf8'),
		'invite_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'token for invitations', 'charset' => 'utf8'),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'language' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'created date time'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'modified date time'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'flag that user is active'),
		'agreed' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'agreed user'),
		'is_blocked' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'blocked users'),
		'pro' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'beta' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'config' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1),
			'invite_token' => array('column' => 'invite_token', 'unique' => 1),
			'username' => array('column' => array('username', 'password'), 'unique' => 0)
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
			'id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
			'username' => 'user',
			'password' => 'Lorem ipsum dolor sit amet',
			'password_token' => 'Lorem ipsum dolor sit amet',
			'first_name' => 'John',
			'last_name' => 'Smith',
			'email' => 'john.smith@prettytasks.com',
			'activate_token' => 'Lorem ipsum dolor sit amet',
			'invite_token' => '2345656314534524524543',
			'timezone' => 'Lorem ipsum dolor sit amet',
			'language' => 'L',
			'created' => '2013-02-04 17:51:19',
			'modified' => '2013-02-04 17:51:19',
			'active' => 1,
			'agreed' => 1,
			'is_blocked' => 1,
			'pro' => 1,
			'beta' => 1,
			'config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		array(
				'id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
				'username' => 'login',
				'password' => 'Lorem ipsum dolor sit amet',
				'password_token' => 'Lorem ipsum dolor sit amet',
				'first_name' => 'Lorem ipsum dolor sit amet',
				'last_name' => 'Lorem ipsum dolor sit amet',
				'email' => 'Lorem ipsum dolor sit amet',
				'activate_token' => 'Lorem ipsum dolor sit amet',
				'invite_token' => '546rtrerqw434qwerwerwer',
				'timezone' => 'Lorem ipsum dolor sit amet',
				'language' => 'L',
				'created' => '2013-02-04 17:51:19',
				'modified' => '2013-02-04 17:51:19',
				'active' => 1,
				'agreed' => 1,
				'is_blocked' => 1,
				'pro' => 1,
				'beta' => 1,
				'config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		
	);

}
