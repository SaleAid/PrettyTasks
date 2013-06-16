<?php
App::uses('AppModel', 'Model');
/**
 * Profile Model
 *
 * @property User $User
 */
class User extends AppModel {
    
    public $name = 'User';
    
    public $hasMany = array('Account');
   
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'users';
    
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
            )
        ), 
        'created' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            ), 
            'notempty' => array(
                'rule' => array(
                    'notempty'
                )
            )
        ), 
        'modified' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            )
        ), 
        'agreed' => array(
            'comparison' => array(
                'rule' => array('comparison', 'equal to', 1),
                'message' => 'Вы должны быть согласны с правилами использования сервиса'
            )
        ),
        'language' => array(
            'language' => array(
                'rule' => array('inList', array('rus', 'eng')),
                'allowEmpty' => true,
                'message'  => 'bad language'
            )
        )
    );
    
    public function getUser($id) {
        $this->contain();
        return $this->findByIdAndBlocked($id, 0);
    }
    
    public function getActiveUsers($limit = 100, $page = 1, $beta = 0) {
        $this->contain();
        $conditions['User.active'] = 1;
        $conditions['User.is_blocked'] = 0;
        $conditions['User.beta'] = $beta;
        return $this->find('all', 
                        array(
                            'conditions' => $conditions,
                            'fields' => array('id', 'email', 'full_name', 'language'),
                            'limit' => $limit,
                            'page' => $page
        ));
    }
    
    public function getCountActiveUsers($beta = 0) {
        $this->contain();
        $conditions['User.active'] = 1;
        $conditions['User.is_blocked'] = 0;
        $conditions['User.beta'] = $beta;
        return $this->find('count', array('conditions' => $conditions));
    }

    public function getConfig($id, $field = null) {
        $result = array();
        $this->contain();
        $config = $this->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ), 
            'fields' => array(
                'User.config'
            )
        ));
        if(isset($config['User']['config']) and !empty($config['User']['config'])){
            $result = unserialize($config['User']['config']);    
        }
        if ($field) {
            if (isset($result[$field])) {
                return (array) $result[$field];
            } else {
                return array();
            }
        }
        return $result;
    }

    public function setConfig($id, $config, $field = null) {
        $this->id = $id;
        $this->saveField('config', serialize($config));
        return true;
    }
    
    public function changeLanguage($id, $lang){
        $this->id = $id;
        if (! $this->exists()) {
            return false;
        }
        if ($this->save(array('language' => $lang), true, array('language'))) {
            return true;
        }
        
    }
}
