<?php
App::uses('AppModel', 'Model');
/**
 * Note Model
 *
 * @property 
 */
class Note extends AppModel {
     
    public $actsAs = array('Taggable');
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'notes';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            ),
            'isUnique' => array(
                'rule' => 'isUnique', 
                'message' => 'ID уже существует'
            )
        ), 
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ), 
		'date' => array(
			'date' => array(
				'rule' => array('date'),
			)
		),
        'title' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', 64000),
                'message' => 'Максимальная длина комментария не больше %d символов'
            ),
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Поле должно быть заполнено' 
            )
        )  
    );

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
	

    private $_originData = array();
    
    private $_fields = array('id', 'title', 'modified');
    
    public function isOwner($id, $user_id) {
        $this->contain();
        $result = $this->findByIdAndUser_id($id, $user_id);
        if ($result) {
            $this->_originData = $result;
            $this->set($result);
            return $result;
        }
        return false;
    }
    
    public function getNotes( $user_id, $count = 50, $page = 1 ){
        $this->contain('Tag');
	    $conditions = array(
                        'Note.user_id' => $user_id, 
                    );
	    $order =  array(
                    'Note.modified' => 'DESC'
                );
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions, 
                            //'fields' => $this->_fields,
			                'limit' => $count,
                            'page' => $page
                        ));
    }
    
   public function search( $user_id, $query, $count = 50, $page = 1 ){
        $this->contain('Tag');
	    $conditions = array(
                        'Note.title LIKE' => '%'.$query.'%', 
                        'Note.user_id' => $user_id
                    );
	    $order =  array(
                    'Note.modified' => 'ASC'
                );
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions, 
                            //'fields' => $this->_fields,
			                'limit' => $count,
                            'page' => $page
                        ));
    }
    
    public function update($title){
        $this->data[$this->alias]['title'] = $title;
        return $this;   
    }
    
    public function create($user_id, $title){
        $this->data[$this->alias]['user_id'] = $user_id;
        $this->data[$this->alias]['title'] = $title;
        return $this;
    }
    
    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        if(isset($this->data[$this->alias]['title'])){
            $this->_checkTags('title');
        }
    }
    
    


}
