<?php
/**
 * AccountFixture
 *
 */
class AccountFixture extends CakeTestFixture {
/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'Account');


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'uid' => 'Lorem ipsum dolor sit amet',
			'provider' => 'Lorem ipsum dolor sit amet',
			'identity' => 'Lorem ipsum dolor sit amet',
			'full_name' => 'Lorem ipsum dolor sit amet',
			'activate_token' => 'Lorem ipsum dolor sit amet',
			'active' => 1,
			'created' => '2012-05-14 00:00:58',
			'user_id' => 1,
			'last_login' => '2012-05-14 00:00:58',
			'agreed' => 1
		),
	);
}
