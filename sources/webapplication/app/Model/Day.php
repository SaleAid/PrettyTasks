<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('AppModel', 'Model');
App::uses('DayObj', 'Lib');

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
							),
							'allowEmpty' => true
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
	public function getIdDay($user_id, $date) {
		$this->contain();
		$day = $this->findByUser_idAndDate($user_id, $date, array('id'));
		if ($day) {
			return $day['Day']['id'];
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
	public function getDays($user_id, $from, $to = null, $arrDays = null) { 
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
        
        $data = array_map(function ($day) {
            return new DayObj($day['Day']);
        }, $result);
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
		$id = $this->getIdDay($user_id, $date);
        if($id){
            $this->id = $id;
        } else {
            $this->data[$this->alias]['date'] = $date;
            $this->data[$this->alias]['user_id'] = $user_id;
		} 
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
		$id = $this->getIdDay($user_id, $date);
        if($id){
            $this->id = $id;
        } else {
            $this->data[$this->alias]['date'] = $date;
            $this->data[$this->alias]['user_id'] = $user_id;
		}
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
	public function getDay($user_id, $date) { 
		$this->contain();
		$day = $this->findByUser_idAndDate($user_id, $date, $this->_dayFields);
		if (!empty($day)) {
			return new DayObj($day[$this->alias]); 
		}
		
		return new DayObj(array(
            				'date' => $date,
            				'comment' => '',
            				'rating' => 0,
                            'id' => null
		                  )
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
	public function getComments($user_id, $count = 10, $to = null, $from = null) { 
		if (!$to){
			$to = date("Y-m-d");
		}
		$this->contain();
		$result = $this->find('all', array(
				'conditions' => array(
						'Day.user_id' => $user_id,
						'Day.comment !=' => '',
						'Day.date <=' => $to
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
