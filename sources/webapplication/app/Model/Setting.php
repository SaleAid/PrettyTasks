<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 * @property User $User
 */
class Setting extends AppModel {

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
     *
     * @param unknown_type $key            
     * @param unknown_type $userId            
     * @return array multitype: Ambigous
     */
    public function getValue($key, $userId, $unserialize = true) {
        $this->contain();
        $result = $this->find('first', array(
                'conditions' => array(
                        'Setting.key' => $key,
                        'Setting.user_id' => $userId 
                ),
                'fields' => array(
                        'key',
                        'value'
                )
        ));
        
        if (!empty($result)) {
            if($unserialize)
                return unserialize($result['Setting']['value']);
            return $result['Setting']['value'];
        }
        
        return false;
    }
    
    /**
     * 
     * @param unknown_type $key
     * @param unknown_type $value
     * @param unknown_type $userId
     * @return boolean
     */
    public function setValue($key, $value, $userId, $serialize = true) {
        $data = array(
            'key' => $key,
            'value' => $serialize ? serialize($value) : $value,
            'user_id' => $userId
        );
        
        $this->contain();
        $result = $this->find('first', array(
                'conditions' => array(
                        'Setting.key' => $key,
                        'Setting.user_id' => $userId 
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