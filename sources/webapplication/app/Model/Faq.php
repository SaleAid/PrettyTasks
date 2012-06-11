<?php
class Faq extends AppModel {
    var $name = 'Faq';
    var $validate = array(
        'faqcategory_id' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
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

    var $belongsTo = array(
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
