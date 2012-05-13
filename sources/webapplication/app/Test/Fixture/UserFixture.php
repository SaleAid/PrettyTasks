<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {
/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'User');


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'username' => 'Username1',
			'password' => 'Lorem ipsum dolor sit amet',
			'password_token' => 'Lorem ipsum dolor sit amet',
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'email' => 'email@email.com',
			'activate_token' => 'Lorem ipsum dolor sit amet',
			'timezone' => 1,
			'created' => '2012-05-13 23:58:57',
			'modified' => '2012-05-13 23:58:57',
			'active' => 1,
			'agreed' => 1,
			'is_blocked' => 1,
			'config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		array(
			'id' => 2,
			'username' => 'Username2',
			'password' => 'Lorem ipsum dolor sit amet',
			'password_token' => 'Lorem ipsum dolor sit amet',
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'email' => 'email2@email.com',
			'activate_token' => 'Lorem ipsum dolor sit amet',
			'timezone' => 1,
			'created' => '2012-05-13 23:58:57',
			'modified' => '2012-05-13 23:58:57',
			'active' => 1,
			'agreed' => 1,
			'is_blocked' => 1,
			'config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
