<?php
class Feedback extends AppModel {
    
    public $name = 'Feedback';
    
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
                'message' => 'Please enter the subject'
            )
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Please enter the message'
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
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        )
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
