<?php
App::uses('AppModel', 'Model');
/**
 * Invitation Model
 *
 * @property User $User
 */
class Invitation extends AppModel {
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'invitations';
    
    /**
     * Validation rules
     *
     * @var array
     */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
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
}
