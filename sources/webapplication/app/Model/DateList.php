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
 *
 * @author vlad
 *        
 */
class DateList extends MainList {

    /**
     *
     * @param unknown_type $userId            
     * @param unknown_type $name            
     */
    public function __construct($userId, $name) {
        parent::__construct($userId, $name);
        $this->_model = ClassRegistry::init('Task');
        $this->_listId = get_class($this);
    }

    /**
     * Return id if item in the list.
     *
     * (non-PHPdoc)
     *
     * @see MainList::isInList()
     */
    public function isInList($foreignKey) {
        $result = $this->_ordered->find('first', array(
                'conditions' => array(
                        'Ordered.user_id' => $this->_userId,
                        'Ordered.list' => $this->_name,
                        'Ordered.list_id' => $this->_listId,
                        'Ordered.model' => $this->_model->alias,
                        'Ordered.foreign_key' => $foreignKey
                )
        ));
        if ($result) {
            $this->_ordered->set($result);
            return $result[$this->_ordered->alias]['id'];
        }
        return false;
    }

    /**
     *
     * @param unknown_type $foreignKey            
     * @param unknown_type $time            
     * @param unknown_type $toFirst            
     */
    public function addToListWithTime($foreignKey, $time, $toFirst = false) {
        $position = $this->getPositionItemWithTime($time);
        if (! $position) {
            $this->addToList($foreignKey, $toFirst);
        } else {
            $this->insert($foreignKey, $position);
        }
    }

    /**
     *
     * @param unknown_type $time            
     * @return boolean number
     */
    protected function getPositionItemWithTime($time) {
        $items = $this->getItemsWithTime();
        if (! $items) {
            return false;
        }
        $position = 0;
        foreach ( $items as $item ) {
            if ($time <= $item[$this->_model->alias]['time']) {
                $position = $item[$this->_ordered->alias]['order'];
                break;
            }
        }
        if (! $position) {
            $item = end($items);
            $position = $item[$this->_ordered->alias]['order'] + 1;
        }
        return $position;
    }

    /**
     *
     * @return unknown
     */
    protected function getItemsWithTime() {
        $this->_model->bindModel(array(
                'hasOne' => array(
                        'Ordered' => array(
                                'className' => 'Ordered',
                                'foreignKey' => 'foreign_key',
                                'type' => 'inner'
                        )
                )
        ));
        $data = $this->_model->find('all', array(
                'order' => array(
                        $this->_model->alias . '.time' => 'ASC'
                ),
                'conditions' => array(
                        'Ordered.user_id' => $this->_userId,
                        'Ordered.list' => $this->_name,
                        'Ordered.list_id' => $this->_listId,
                        'Ordered.model' => $this->_model->alias,
                        'not' => array(
                                $this->_model->alias . '.time' => null
                        )
                ),
                'contain' => array(
                        'Ordered'
                )
        )
        ); // 'fields' => $this->_model->getFields(),
        return $data;
    }

    /**
     *
     * @param unknown_type $count            
     * @param unknown_type $page            
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
        $data = $this->_model->find('all', array(
                'order' => array(
                        'Ordered.order' => 'ASC'
                ),
                'conditions' => array(
                        'Ordered.user_id' => $this->_userId,
                        'Ordered.list' => $this->_name,
                        'Ordered.list_id' => $this->_listId,
                        'Ordered.model' => $this->_model->alias
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
            return $task['Task'];
        }, $data);
        return $data;
    }
}
