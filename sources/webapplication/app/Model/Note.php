<?php
App::uses('AppModel', 'Model');
/**
 * Note Model
 *
 * @property 
 */
class Note extends AppModel {
     
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
        'note' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', 1000),
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
    
    private $_fields = array('id', 'note', 'modified');
    
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
    
    public function getNotes($user_id){
        $object = array();
        $this->contain();
        $notes = $this->find('all', 
                        array(
                            'order' => array(
                                'Note.modified' => 'ASC'
                            ), 
                            'conditions' => array(
                                    array(
                                        'Note.user_id' => $user_id
                                    ), 
                              
                            ),
                            'fields' => $this->_fields,
                        ));
        if(isset($notes[0][$this->alias])){
            $object = array_map(create_function('$row', 'return $row[\'Note\'];'), $notes);    
        }
        return $object;
    }
    
    public function getLastOrderByUser($user_id) {
        $lastOrder = $this->find('first', 
                                array(
                                    'fields' => array(
                                        'Note.order'
                                    ), 
                                    'order' => array(
                                        'Note.order' => 'desc'
                                    ), 
                                    'conditions' => array(
                                         'Note.user_id' => $user_id
                                    )
                                ));
        if ($lastOrder) {
            return $lastOrder[$this->alias]['order'];
        }
        return false;
    }
    
    public function createNote($user_id, $note, $order = null){
        $this->data[$this->alias]['user_id'] = $user_id;
        //$this->data[$this->alias]['order'] = $order ? $order : $this->getLastOrderByUser($user_id) + 1;
        $this->data[$this->alias]['note'] = $note;
        return $this;
    }
    
    public function editNote($data = array(), $action){
        
        if( method_exists($this, $action) ){
            return $this->$action($data);
        }
        return $this;    
    }
    
    protected function changeNote($data){
         $this->data[$this->alias]['note'] = $data['note'];
        return $this;
    }
    
    
    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
    }
    
    public function saveNote(){
            $save = $this->save();
            if (is_array($save)){
                foreach($save[$this->alias] as $key => $value){
                    if(!in_array($key, $this->_fields)){
                        unset($save[$this->alias][$key]);
                    }
                }
                return $save;
            }
            else{
                return false;
            }
    }


}
