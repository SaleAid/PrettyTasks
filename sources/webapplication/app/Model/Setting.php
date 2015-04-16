<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 * @property User $User
 */
class Setting extends AppModel {
	
	
	public $defaultSettings = [
			'subscribe_news' => 1,// Receive news by default
			'subscribe_daily_digest' => 0,// Do not receive daily digest by default
			'subscribe_weekly_digest' => 1,//Receive weekly digest by default
	];

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
            'numeric'
		),
		'user_id' => array(
            'numeric'
		),
		'key' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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


	/**
	 * Return value from DB, or default, or false
	 * 
	 * @param string $key
	 * @param int $user_id
	 * @param string $unserialize
	 * @return multitype:number |boolean
	 */
    public function getValue($key, $user_id, $unserialize = true) {
        $this->contain();
        $result = $this->find('first', array(
                'conditions' => array(
                        'Setting.key' => $key,
                        'Setting.user_id' => $user_id 
                ),
                'fields' => array(
                        'key',
                        'value'
                )
        ));
        
        if (!empty($result)) {
            if($unserialize){
                return unserialize($result['Setting']['value']);
            }
            return $result['Setting']['value'];
        }else{
        	//Check for default value
        	if (isset($this->defaultSettings[$key])){
        		return $this->defaultSettings[$key];
        	}
        }
        
        return false;
    }
    
    //TODO Write function for bulk saving settings
    
    /**
     * 
     * @param unknown_type $key
     * @param unknown_type $value
     * @param unknown_type $user_id
     * @return boolean
     */
    public function setValue($key, $value, $user_id, $serialize = true) {
        $data = array(
            'key' => $key,
            'value' => $serialize ? serialize($value) : $value,
            'user_id' => $user_id
        );
        
        $this->contain();
        $result = $this->find('first', array(
                'conditions' => array(
                        'Setting.key' => $key,
                        'Setting.user_id' => $user_id 
                ),
                'fields' => array(
                        'id'
                )
        ));
        
        if(!empty($result)){
            $data['id'] = $result['Setting']['id'];
        } else {
            $this->create();
        }
        
        if($this->save($data)){
            return true;
        }
        return false;
    }
    
    /**
     *
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function addDay($user_id, $date) {
    	$days = $this->getValue('days', $user_id);
    
    	if (empty($days) or !in_array($date, $days) ) {
    		$days[] = $date;
    		$this->setValue('days', $days, $user_id);
    	}
    }
    
    /**
     *
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function deleteDay($user_id, $date) {
    	$days = (array)$this->getValue('days', $user_id);
    	$key = array_search($date, $days);
    	if($key !== false){
    		unset($days[$key]);
    		return  $this->setValue('days', $days, $user_id);
    	}
    	return true;
    }
}