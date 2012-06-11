<?php
class Faqcategory extends AppModel {
    var $name = 'Faqcategory';
    var $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
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
        'order' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
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
        'User' => array(
            'className' => 'User', 
            'foreignKey' => 'user_id', 
            'conditions' => '', 
            'fields' => '', 
            'order' => ''
        )
    );
    var $hasMany = array(
        'Faq' => array(
            'className' => 'Faq', 
            'foreignKey' => 'faqcategory_id', 
            'dependent' => false, 
            'conditions' => '', 
            'fields' => '', 
            'order' => '', 
            'limit' => '', 
            'offset' => '', 
            'exclusive' => '', 
            'finderQuery' => '', 
            'counterQuery' => ''
        )
    );
}
