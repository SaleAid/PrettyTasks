<?php
class Feedback extends AppModel {
    var $name = 'Feedback';
    var $validate = array(
        'lang' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                )
            )
        ), 
        'email' => array(
            'email' => array(
                'rule' => array(
                    'email'
                )
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
                )
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
    var $belongsTo = array(
        'User' => array(
            'className' => 'User', 
            'foreignKey' => 'user_id', 
            'conditions' => '', 
            'fields' => '', 
            'order' => ''
        )
    );
}
