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
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
    public function getValue($key, $userId) {
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
            return unserialize($result['Setting']['value']);
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
    public function setValue($key, $value, $userId) {
        $data = array(
            'key' => $key,
            'value' => serialize($value),
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
}