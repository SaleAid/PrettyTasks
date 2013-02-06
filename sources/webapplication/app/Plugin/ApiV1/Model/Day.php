<?php
/**
 * Day Model
 *
 * @property 
 */
class Day extends ApiV1AppModel {
     
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'days';

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
        'rating' => array(
            'boolean' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),
        'comment' => array(
                'maxLength' => array(
                    'rule'    => array('maxLength', 10000),
                    'message' => 'Максимальная длина комментария не больше %d символов'
                )
            )    
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
	
	
	public $hasMany = array(
        'Task' => array(
            'className'  => 'Task',
			'foreignKey' => 'day_id',
            'order'      => 'Task.order ASC'
        )
    );
    
    private $_originData = array();
    
    private $_fields = array('id', 'date', 'rating', 'comment', 'created', 'modified');
    
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
    
    public function getByUser_id( $user_id, $count = 50, $page = 1 ){
        $this->contain();
	    $conditions = array(
                        'Day.user_id' => $user_id, 
                    );
	    $order =  array(
                    'Day.modified' => 'ASC',
                    'Day.date' => 'DESC',
                );
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions, 
                            'fields' => $this->_fields,
			                'limit' => $count,
                            'page' => $page
                        ));
    }
    
    
    
    public function update(array $data){
        extract( $data );
        if( isset($rating) )
            $this->data[$this->alias]['rating'] = $rating;
        if( isset($comment) )
            $this->data[$this->alias]['comment'] = $comment;
        return $this;   
    }
    
    public function create($user_id, array $data){
        extract( $data );
        $this->data[$this->alias]['user_id'] = $user_id;
        if( isset($rating) )
            $this->data[$this->alias]['rating'] = $rating;
        if( isset($comment) )
            $this->data[$this->alias]['comment'] = $comment;
        return $this;
    }
    
    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
    }
    
}
