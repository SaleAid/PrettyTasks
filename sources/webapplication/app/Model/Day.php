<?php
App::uses('AppModel', 'Model');

/**
 * Day Model
 *
 * @property User $User
 */
class Day extends AppModel {
	
	/**
	 * Validation domain
	 *
	 * @var string
	 */
	public $validationDomain = 'days';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			'id' => array(
					'uuid'
			),
			'user_id' => array(
					'maxLength' => array(
							'rule' => array(
									'maxLength',
									36
							),
							'message' => 'Wrong ID'
					)
			),
			'date' => array(
					'date' => array(
							'rule' => array(
									'date'
							)
					)
			),
			'comment' => array(
					'maxLength' => array(
							'rule' => array(
									'maxLength',
									5000
							),
							'message' => 'Максимальная длина комментария не больше %d символов'
					)
			),
            'rating' => array(
                'boolean' => array(
                    'rule' => array(
                        'boolean'
                    )
                )
            )
 	);

	// The Associations below have been created with all possible keys, those
	// that are not needed can be removed
	
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
	public $hasMany = array(
			'Task' => array(
					'className' => 'Task',
					'foreignKey' => 'day_id',
					'order' => 'Task.order ASC'
			)
	);
	private $_dayFields = array(
			'id',
			'comment',
			'date',
			'rating',
			'user_id'
	);

	/**
	 * Check some day for user.
	 * Return day or false, if day is not found.
	 * Set to model->data found day or data to create new day(user_id, date)
	 *
	 * @param string $user_id        	
	 * @param string $date        	
	 * @return array boolean=false
	 */
	public function isDayFound($user_id, $date) {
		$this->contain();
		$day = $this->findByUser_idAndDate($user_id, $date, $this->_dayFields);
		if ($day) {
			$this->set($day);
			return $day;
		} else {
			$this->set(array(
					'user_id' => $user_id,
					'date' => $date,
					'rating' => 0
			));
		}
		return false;
	}

	/**
	 * Returns selected days.
	 *
	 * @param string $user_id        	
	 * @param string $from
	 *        	- Date
	 * @param string $to
	 *        	- Date
	 * @param array $arrDays        	
	 * @return Ambigous <multitype:, unknown>
	 */
	public function getDaysRating($user_id, $from, $to = null, $arrDays = null) { // TODO:
	                                                                              // Remane
	                                                                              // to
	                                                                              // getDays
		$days = array();
		$data = array();
		do {
			$days[] = $from;
			$from = date("Y-m-d", strtotime($from . "+1 day"));
		} while ( $from < $to );
		if (is_array($arrDays)) {
			sort($arrDays);
			$days = array_merge($days, $arrDays);
			$days = array_unique($days);
		}
		$this->contain();
		$result = $this->find('all', array(
				'conditions' => array(
						'Day.user_id' => $user_id,
						'Day.date' => $days
				),
				'fields' => $this->_dayFields
		));
		foreach ( $result as $item ) {
			$data[$item['Day']['date']][] = $item;
		}
		return $data;
	}

	/**
	 * Set rating.
	 * Need call save() function after this setting.
	 *
	 * @param string $user_id        	
	 * @param string $date        	
	 * @param int $rating        	
	 * @return Day
	 */
	public function setRating($user_id, $date, $rating = null) {
		$this->isDayFound($user_id, $date); // TODO remove this
		$this->data[$this->alias]['rating'] = $rating;
		return $this;
	}

	/**
	 * Set comment.
	 * Need call save() function after this setting.
	 *
	 * @param string $user_id        	
	 * @param string $date        	
	 * @param string $comment        	
	 * @return Day
	 */
	public function setComment($user_id, $date, $comment = null) {
		$this->isDayFound($user_id, $date); // TODO remove this
		$this->data[$this->alias]['comment'] = $comment;
		return $this;
	}

	/**
	 * Get comment for some day
	 *
	 * @param string $user_id        	
	 * @param string $date        	
	 * @return unknown multitype:string
	 */
	public function getComment($user_id, $date) { // TODO Rename to get day
		$this->contain();
		$day = $this->findByUser_idAndDate($user_id, $date, $this->_dayFields);
		if (isset($day[$this->alias]['comment'])) {
			return $day[$this->alias];
		}
		
		return array(
				'date' => $date,
				'comment' => '',
				'rating' => 0
		);
	}

	/**
	 * Get latest comments for user
	 *
	 * @param string $user_id        	
	 * @param int $count,
	 *        	default = 10
	 * @return Ambigous <multitype:, NULL, mixed>
	 */
	public function getComments($user_id, $count = 10) {//Rewrite syntax, add $to & $from
		$this->contain();
		$result = $this->find('all', array(
				'conditions' => array(
						'Day.user_id' => $user_id,
						'Day.comment !=' => '',
						'Day.date <=' => date("Y-m-d")
				),
				'fields' => $this->_dayFields,
				'order' => array(
						'Day.date DESC'
				),
				'limit' => $count
		));
		return $result;
	}
}
