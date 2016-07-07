<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('AppModel', 'Model');

/**
 * Note Model
 */
class Note extends AppModel {
    public $actsAs = array(
            'Taggable'
    );
    
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
                            'rule' => array(
                                    'maxLength',
                                    36
                            ),
                            'message' => 'Wrong ID'
                    ),
                    'isUnique' => array(
                            'rule' => 'isUnique',
                            'message' => 'ID уже существует'
                    )
            ),
            'user_id' => array(
                    'maxLength' => array(
                            'rule' => array(
                                    'maxLength',
                                    36
                            ),
                            'message' => 'Wrong ID'
                    )
            ),
            'date' => array(
                    'date' => array(
                            'rule' => array(
                                    'date'
                            )
                    )
            ),
            'title' => array(
                    'maxLength' => array(
                            'rule' => array(
                                    'maxLength',
                                    64000
                            ),
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
    
    /**
     *
     * @var unknown_type
     */
    private $_originData = array();
    
    /**
     *
     * @var unknown_type
     */
    private $_fields = array(
            'id',
            'title_excerpt',
            'created',
            'modified',
            'fav'
    );
    
    public $virtualFields = array(
        'title_excerpt' => 'LEFT(Note.title,140)'
    );
    
    /**
     * 
     * @param unknown_type $id
     * @param unknown_type $user_id
     * @return unknown|boolean
     */
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
    
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $count
     * @param unknown_type $page
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function getNotes($user_id, $count, $page) {
        $this->contain('Tag');
        $conditions = array(
                'Note.user_id' => $user_id
        );
        $order = array(
                'Note.modified' => 'DESC'
        );
        return $this->find('all', array(
                'order' => $order,
                'conditions' => $conditions,
                'fields' => $this->_fields,
                'limit' => $count,
                'page' => $page
        ));
    }
    
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $count
     * @param unknown_type $page
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function getNote($id, $user_id) {
        $this->contain('Tag');
        $conditions = array(
                'Note.user_id' => $user_id,
                'Note.id' => $id
        );
        return $this->find('first', array(
                'conditions' => $conditions,
        ));
    }
    
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $query
     * @param unknown_type $count
     * @param unknown_type $page
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function search($user_id, $query, $count, $page) {
        $this->contain('Tag');
        $conditions = array(
                'Note.title LIKE' => '%' . $query . '%',
                'Note.user_id' => $user_id
        );
        $order = array(
                'Note.modified' => 'ASC'
        );
        return $this->find('all', array(
                'order' => $order,
                'conditions' => $conditions,
                // 'fields' => $this->_fields,
                'limit' => $count,
                'page' => $page
        ));
    }
    
    /**
     * 
     * @param unknown_type $title
     * @return Note
     */
    public function update($title) {
        $this->data[$this->alias]['title'] = $title;
        return $this;
    }

    public function favorite() {
        $this->data[$this->alias]['fav'] = !$this->data[$this->alias]['fav'];
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Model::create()
     */
    public function createNote($user_id, $title) {
        $this->data[$this->alias]['user_id'] = $user_id;
        $this->data[$this->alias]['title'] = $title;
        $this->data[$this->alias]['fav'] = 0;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Model::beforeSave()
     */
    public function beforeSave($options = array()) {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        if (isset($this->data[$this->alias]['title'])) {
            $this->_checkTags('title');
        }
    }
}
