<?php
App::uses('AppModel', 'Model');
/**
 * Day Model
 *
 * @property User $User
 */
class Day extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
            'className'  => 'Task',
			'foreignKey' => 'day_id',
            'order'      => 'Task.order ASC'
        )
    );
    
    public function isDayFound($user_id, $date){
        $this->contain();
        $day = $this->findByUser_idAndDate($user_id, $date);
        if ($day) {
            $this->set($day);
            return $day;
        }else{
            $this->set(array(
                        'user_id' => $user_id,
                        'date' => $date
));
        }
        return false;
    }
    
    public function getDaysRating($user_id, $from, $to = null, $arrDays = null){
        $days = array();
        $data = array();
        do {
            $days[] = $from;
            $from = date("Y-m-d", strtotime($from . "+1 day"));
        } while($from < $to);
        if(is_array($arrDays)){
            sort($arrDays);
            $days = array_merge($days, $arrDays);
            $days = array_unique($days);
        }
        $this->contain();
        $result = $this->find('all', 
                            array(
                                'conditions' => array(
                                    'Day.user_id' => $user_id, 
                                    'Day.date' => $days
                                )
                            ));
        foreach($result as $item){
            $data[$item['Day']['date']][] = $item;
        }
        return $data;
    }
    
    public function setRating($user_id, $date, $rating=null) {
        $this->isDayFound($user_id, $date);
        $this->data[$this->alias]['rating'] = $rating;
        return $this;
    }
    
    public function getComment($user_id, $date){
        $this->contain();
        $day = $this->findByUser_idAndDate($user_id, $date);
        if(isset($day[$this->alias]['comment'])){
            return $day[$this->alias];
        }
        
        return array('date' => $date, 'comment' => '');
    }
    
    public function setComment($user_id, $date, $comment=null){
        $this->isDayFound($user_id, $date);
        $this->data[$this->alias]['comment'] = $comment;
        return $this;
    }

}
