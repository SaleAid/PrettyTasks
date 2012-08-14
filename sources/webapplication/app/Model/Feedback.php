<?php
class Feedback extends AppModel {
    
    public $name = 'Feedback';
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'feedbacks';
    
    public $validate = array(
        'lang' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                )
            )
        ), 
        'category' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Please select a category'
            )
        ), 
        'status' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ), 
        'subject' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Поле должно быть заполнено'
            )
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Поле должно быть заполнено'
            )
        ), 
        'processed' => array(
            'boolean' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ), 
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ), 
    );
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
