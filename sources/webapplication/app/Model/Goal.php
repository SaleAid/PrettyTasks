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
	/**
	 * Allowed fields
	 *
	 * @var array
	 */
	private $_allowedFields = array(
			'id',
			'title',
			'comment',
			'fromdate',
			'todate',
			'datedone',
			'done',
			'deleted',
			'user_id'
	);
	/**
	 * Get goals
	 * 
	 * @param string $userId
	 * @param string $fromDate
	 * @param string $toDate
	 * @param array $additioanlOptions
	 * @return Ambigous <multitype:, NULL, mixed>
	 * @todo METHOD is not ready YET!!!
	 */
	public function getGoals($userId, $fromDate = null, $toDate = null, $additioanlOptions = array()) {
		$conditions = array(
				$this->alias . '.user_id' => $userId,
				$this->alias . '.fromdate' => null,
				$this->alias . '.todate' => null
		);
		if ($fromDate) {
			unset($conditions[$this->alias . '.fromdate']);
			$conditions[$this->alias . '.fromdate <= '] = $fromDate; // ??
		}
		if ($toDate) {
			unset($conditions[$this->alias . '.todate']);
			$conditions[$this->alias . '.todate <= '] = $toDate; // ??
		}
		$options['conditions'] = $conditions;
		$options['fields'] = $this->_allowedFields;
		$options['order'] = 'todate ASC, fromdate DESC';
		$options = array_merge($options, $additioanlOptions);
		$this->contain();
		//debug($options);
		return $this->find('all', $options);
	}
}
