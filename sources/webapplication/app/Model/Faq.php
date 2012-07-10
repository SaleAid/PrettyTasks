<?php
class Faq extends AppModel {
    public $name = 'Faq';
    public $validate = array(
        'faqcategory_id' => array(
            'maxLength' => array(
                'rule' => array(
                    'maxLength', 
                    36
                ), 
                'message' => 'Wrong ID'
            )
        ), 
        'lang' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
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
        'active' => array(
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
        'Faqcategory' => array(
            'className' => 'Faqcategory', 
            'foreignKey' => 'faqcategory_id', 
            'conditions' => '', 
            'fields' => '', 
            'order' => ''
        ), 
        'User' => array(
            'className' => 'User', 
            'foreignKey' => 'user_id', 
            'conditions' => '', 
            'fields' => '', 
            'order' => ''
        )
    );
}
