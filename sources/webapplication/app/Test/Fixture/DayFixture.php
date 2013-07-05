<?php
/**
 * DayFixture
 *
 */
class DayFixture extends CakeTestFixture {
	
	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = array (
			'id' => array (
					'type' => 'string',
					'null' => false,
					'default' => null,
					'length' => 36,
					'key' => 'primary',
					'collate' => 'utf8_general_ci',
					'comment' => 'primary key',
					'charset' => 'utf8' 
			),
			'user_id' => array (
					'type' => 'string',
					'null' => false,
					'default' => null,
					'length' => 36,
					'key' => 'index',
					'collate' => 'utf8_general_ci',
					'comment' => 'reference to user',
					'charset' => 'utf8' 
			),
			'comment' => array (
					'type' => 'text',
					'null' => true,
					'default' => null,
					'collate' => 'utf8_general_ci',
					'comment' => 'comment for day',
					'charset' => 'utf8' 
			),
			'rating' => array (
					'type' => 'integer',
					'null' => true,
					'default' => '0',
					'comment' => 'reference to rating' 
			),
			'date' => array (
					'type' => 'date',
					'null' => false,
					'default' => null,
					'comment' => 'date of the day' 
			),
			'created' => array (
					'type' => 'datetime',
					'null' => true,
					'default' => null 
			),
			'modified' => array (
					'type' => 'datetime',
					'null' => true,
					'default' => null 
			),
			'indexes' => array (
					'PRIMARY' => array (
							'column' => 'id',
							'unique' => 1 
					),
					'user_id' => array (
							'column' => array (
									'user_id',
									'date' 
							),
							'unique' => 0 
					) 
			),
			'tableParameters' => array (
					'charset' => 'utf8',
					'collate' => 'utf8_general_ci',
					'engine' => 'InnoDB' 
			) 
	);
	
	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = array (
			// For user =1
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fe0',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 1,
					'date' => '2013-02-04',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fe2',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'comment' => 'Comment for 2013-02-05. Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 0,
					'date' => '2013-02-05',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fe3',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 0,
					'date' => '2013-01-04',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fe4',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'comment' => null,
					'rating' => 1,
					'date' => '2013-01-05',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			
			// For user =2
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fd0',
					'user_id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
					'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 1,
					'date' => '2013-02-04',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fd2',
					'user_id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
					'comment' => 'Commet for 2013-02-05. Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 0,
					'date' => '2013-02-05',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fd3',
					'user_id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
					'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'rating' => 0,
					'date' => '2013-01-04',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			),
			array (
					'id' => '510fcd9b-7858-455d-8316-1666b43b9fd4',
					'user_id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
					'comment' => null,
					'rating' => 1,
					'date' => '2013-01-05',
					'created' => '2013-02-04 15:02:51',
					'modified' => '2013-02-04 15:02:51' 
			) 
	);
}
