<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('DateList', 'Model');
App::uses('Task', 'Model');
App::uses('TaskObj', 'Lib');
/**
 */
class UncompletedManyDateList extends DateList {

    /**
     *
     * @param unknown_type $userId            
     * @param unknown_type $arrayDates            
     */
    public function __construct($userId, $arrayDates = array()) {
        parent::__construct($userId, $arrayDates);
        $this->_model = ClassRegistry::init('Task');
        $this->_listId = 'DateList';
    }

    /**
     *
     * @return unknown multitype:
     */
    public function getItems($count = 50, $page = 1) {
        $this->_model->bindModel(array(
                'hasOne' => array(
                        'Ordered' => array(
                                'className' => 'Ordered',
                                'foreignKey' => 'foreign_key',
                                'type' => 'inner'
                        )
                )
        ));
        $tasks = $this->_model->find('all', array(
                'order' => array(
                        'Ordered.list' => 'ASC',
                        'Ordered.order' => 'ASC'
                ),
                'conditions' => array(
                        'Ordered.user_id' => $this->_userId,
                        'Ordered.list' => $this->_name,
                        'Ordered.list_id' => $this->_listId,
                        'Ordered.model' => $this->_model->alias,
                        'Task.done' => 0
                ),
                'contain' => array(
                        'Ordered',
                        'Tag'
                ),
                'fields' => $this->_model->getFields(),
                'limit' => $count,
                'page' => $page
        ));
        $data = array_map(function ($task) {
            return new TaskObj($task['Task']);
        }, $tasks);
        return $data;
    }
}
