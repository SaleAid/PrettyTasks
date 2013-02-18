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
			'id' => array(
					'type' => 'string',
					'null' => false,
					'default' => null,
					'length' => 36,
					'key' => 'primary',
					'collate' => 'utf8_general_ci',
					'comment' => 'primary key',
					'charset' => 'utf8'
			),
			'user_id' => array(
					'type' => 'string',
					'null' => false,
					'default' => null,
					'length' => 36,
					'collate' => 'utf8_general_ci',
					'charset' => 'utf8'
			),
			'title' => array(
					'type' => 'string',
					'null' => false,
					'default' => null,
					'collate' => 'utf8_general_ci',
					'comment' => 'Title of goal',
					'charset' => 'utf8'
			),
			'comment' => array(
					'type' => 'text',
					'null' => true,
					'default' => null,
					'collate' => 'utf8_general_ci',
					'charset' => 'utf8'
			),
			'fromdate' => array(
					'type' => 'date',
					'null' => true,
					'default' => null
			),
			'todate' => array(
					'type' => 'date',
					'null' => true,
					'default' => null
			),
			'datedone' => array(
					'type' => 'datetime',
					'null' => true,
					'default' => null
			),
			'done' => array(
					'type' => 'integer',
					'null' => true,
					'default' => '0',
					'length' => 1,
					'comment' => 'Flag that goal is done'
			),
			'deleted' => array(
					'type' => 'integer',
					'null' => false,
					'default' => '0',
					'length' => 1
			),
			'created' => array(
					'type' => 'datetime',
					'null' => true,
					'default' => null
			),
			'modified' => array(
					'type' => 'datetime',
					'null' => true,
					'default' => null
			),
			'indexes' => array(
					'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
					)
			),
			'tableParameters' => array(
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
	public $records = array(
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe0',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 1',
					'comment' => 'Goal 1 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-01',
					'todate' => '2013-02-10',
					'datedone' => '2013-02-10 14:41:08',
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-01 14:41:08',
					'modified' => '2013-02-01 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe1',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 2',
					'comment' => 'Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-11',
					'todate' => '2013-02-20',
					'datedone' => '2013-02-11 14:41:08',
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-11 14:41:08',
					'modified' => '2013-02-11 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe2',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 3',
					'comment' => 'Goal 3 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-11',
					'todate' => '2013-02-20',
					'datedone' => '2013-02-11 14:41:08',
					'done' => 1,
					'deleted' => 0,
					'created' => '2013-02-11 14:41:08',
					'modified' => '2013-02-11 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe3',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 4',
					'comment' => 'Goal 4 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-11',
					'todate' => '2013-02-20',
					'datedone' => '2013-02-11 14:41:08',
					'done' => 0,
					'deleted' => 1,
					'created' => '2013-02-11 14:41:08',
					'modified' => '2013-02-11 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe4',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 5',
					'comment' => 'Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-01',
					'todate' => '2013-02-20',
					'datedone' => '2013-02-11 14:41:08',
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-11 14:41:08',
					'modified' => '2013-02-11 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe5',
					'user_id' => '510ff8c2-2470-4ded-860a-274db43b9fe0',
					'title' => 'Goal 6',
					'comment' => 'Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => '2013-02-01',
					'todate' => '2013-02-20',
					'datedone' => '2013-02-11 14:41:08',
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-11 14:41:08',
					'modified' => '2013-02-11 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe6',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 7',
					'comment' => 'Goal 7 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => null,
					'todate' => null,
					'datedone' => null,
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-01 14:41:08',
					'modified' => '2013-02-01 14:41:08'
			),
			array(
					'id' => '51223d84-365c-419b-8705-20a9b43b9fe7',
					'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
					'title' => 'Goal 8',
					'comment' => 'Goal 8 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'fromdate' => null,
					'todate' => '2013-02-20',
					'datedone' => null,
					'done' => 0,
					'deleted' => 0,
					'created' => '2013-02-01 14:41:08',
					'modified' => '2013-02-01 14:41:08'
			)
	);
}
