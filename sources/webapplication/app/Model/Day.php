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
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ), 
		'date' => array(
			'date' => array(
				'rule' => array('date'),
			)
		),
        'comment' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', 5000),
                'message' => 'Максимальная длина комментария не больше %d символов'
            )
        )  
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
    
    private $_dayFields = array('id', 'comment', 'date', 'rating');
    
    public function isDayFound($user_id, $date){
        $this->contain();
        $day = $this->findByUser_idAndDate($user_id, $date, $this->_dayFields);
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
                                ),
                               'fields' => $this->_dayFields 
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
        $day = $this->findByUser_idAndDate($user_id, $date, $this->_dayFields);
        if(isset($day[$this->alias]['comment'])){
            return $day[$this->alias];
        }
        
        return array('date' => $date, 'comment' => '');
    }
    public function getComments($user_id, $count = 10){
        $this->contain();
        $result = $this->find('all', 
                            array(
                                'conditions' => array(
                                    'Day.user_id' => $user_id, 
                                    'Day.comment !=' => '',
                                    'Day.date <=' => date("Y-m-d") 
                                ),
                               'fields' => $this->_dayFields,
                               'order' => array('Day.date DESC'),
                               'limit' => $count, 
        ));
        return $result;
    }
    
    public function setComment($user_id, $date, $comment=null){
        $this->isDayFound($user_id, $date);
        $this->data[$this->alias]['comment'] = $comment;
        return $this;
    }

}
