<?php
class Faqcategory extends AppModel {
    
    public $name = 'Faqcategory';
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'faqcategories';
    
    public $validate = array(
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
    public $hasMany = array(
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
