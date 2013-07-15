<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('MainList', 'Model');
App::uses('Task', 'Model');

/**
 */
class DeletedList extends MainList {

    /**
     *
     * @param unknown_type $userId            
     */
    public function __construct($userId) {
        parent::__construct($userId, 'deleted');
        $this->_model = ClassRegistry::init('Task');
    }

    /**
     *
     * @param unknown_type $count            
     * @param unknown_type $page            
     * @return unknown multitype:
     */
    public function getItems($count = 50, $page = 1) {
        $data = $this->_model->find('all', array(
                'order' => array(
                        $this->_model->alias . '.date' => 'DESC',
                        $this->_model->alias . '.modified' => 'DESC'
                ),
                'conditions' => array(
                        $this->_model->alias . '.user_id' => $this->_userId,
                        $this->_model->alias . '.deleted' => 1
                ),
                'contain' => array(
                        'Tag'
                ),
                'fields' => $this->_model->getFields(),
                'limit' => $count,
                'page' => $page
        ));
        $data = array_map(function ($task) {
            return $task['Task'];
        }, $data);
        return $data;
    }
}
