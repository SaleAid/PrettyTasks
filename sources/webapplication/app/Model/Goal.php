<?php
App::uses('AppModel', 'Model');

/**
 * Goal Model
 *
 * @property User $User
 */
class Goal extends AppModel {
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'title';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			'title' => array(
					'notempty' => array(
							'rule' => array(
									'notempty'
							)
					)
			),
			'user_id' => array(
					'uuid' => array(
							'rule' => array(
									'uuid'
							)
					)
			)
	);
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			)
	);
	
	
}
