<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property User $User
 */
class User extends AppModel {
    public $name = 'User';
    public $hasMany = array(
            'Account', 'Setting'
    );
    
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
                            'rule' => array(
                                    'maxLength',
                                    36
                            ),
                            'message' => 'Wrong ID'
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
                            'rule' => array(
                                    'comparison',
                                    'equal to',
                                    1
                            ),
                            'message' => 'Вы должны быть согласны с правилами использования сервиса'
                    )
            ),
            'language' => array(
                    'language' => array(
                            'rule' => array(
                                    'inList',
                                    array(
                                            'rus',
                                            'eng'
                                    )
                            ),
                            'allowEmpty' => true,
                            'message' => 'bad language'
                    )
            )
    );

    /**
     *
     * @param unknown_type $id            
     */
    public function getUser($id) {
        $this->contain();
        return $this->findByIdAndBlocked($id, 0);
    }

    /**
     *
     * @param unknown_type $limit            
     * @param unknown_type $page            
     * @param unknown_type $beta            
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function getActiveUsers($limit = 100, $page = 1, $beta = 0) {
        $this->contain();
        $conditions['User.active'] = 1;
        $conditions['User.is_blocked'] = 0;
        $conditions['User.beta'] = $beta;
        return $this->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                        'id',
                        'email',
                        'full_name',
                        'language'
                ),
                'limit' => $limit,
                'page' => $page
        ));
    }

    /**
     *
     * @param unknown_type $beta            
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function getCountActiveUsers($beta = 0) {
        $this->contain();
        $conditions['User.active'] = 1;
        $conditions['User.is_blocked'] = 0;
        $conditions['User.beta'] = $beta;
        return $this->find('count', array(
                'conditions' => $conditions
        ));
    }

    /**
     * 
     * @param unknown_type $id
     * @param unknown_type $lang
     * @return boolean
     */
    public function changeLanguage($id, $lang) {
        $this->id = $id;
        if (! $this->exists()) {
            return false;
        }
        if ($this->save(array(
                'language' => $lang
        ), true, array(
                'language'
        ))) {
            return true;
        }
    }
}
