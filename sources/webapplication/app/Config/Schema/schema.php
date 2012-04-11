<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'comment' => 'primary key'),
		'uid' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'the unique id of the social network', 'charset' => 'utf8'),
		'provider' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'comment' => 'provider name (google,facebook,twitter,vkontakte)', 'charset' => 'utf8'),
		'identity' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'identity', 'charset' => 'utf8'),
		'full_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'full_name', 'charset' => 'utf8'),
		'activate_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => 'key for activation account', 'charset' => 'utf8'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'flag that account is active'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'created date time'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'comment' => 'reference to user'),
		'last_login' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'agreed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $tasks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'comment' => 'primary key'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'comment' => 'reference to user'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'task\'s title', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL, 'comment' => 'data and time for task'),
		'time' => array('type' => 'time', 'null' => true, 'default' => NULL, 'comment' => 'Flag for check time, if not set, task has only date'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'comment' => 'order for sorting tasks'),
		'done' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'Flag that task is done'),
		'future' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'flag that task is for future'),
		'repeatid' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'id of repeated task\'s series'),
		'transfer' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'count of transfer of task'),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'priority of task'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'created date time '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'modified date time '),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'comment' => 'primary key'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'username', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'comment' => 'password', 'charset' => 'utf8'),
		'password_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => '	password_token', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'user name', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'user last name', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'user email', 'charset' => 'utf8'),
		'activate_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => 'activate_token', 'charset' => 'utf8'),
		'timezone' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'created date time'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'modified date time'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'flag that user is active'),
		'agreed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'is_blocked' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'is_blocked'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'email' => array('column' => 'email', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
