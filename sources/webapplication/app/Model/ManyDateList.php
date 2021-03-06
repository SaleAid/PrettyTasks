<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('MainList', 'Model');
App::uses('Task', 'Model');
App::uses('TaskObj', 'Lib');
/**
 */
class ManyDateList extends MainList {

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
     * @param unknown_type $beginDate            
     * @param unknown_type $endDate            
     * @param unknown_type $arrayDates            
     * @return multitype:
     */
    public static function arrayDates($beginDate, $endDate, $arrayDates = array()) {
        $dates = array();
        if(!is_array($arrayDates)){
            $arrayDates = array();
        }
        $currentDate = $beginDate;
        while ( $currentDate <= $endDate ) {
            $dates[] = $currentDate;
            $currentDate = date("Y-m-d", strtotime($currentDate . "+1 day"));
        }
        $arrayDates = array_merge($dates, $arrayDates);
        $arrayDates = array_unique($arrayDates);
        sort($arrayDates);
        return $arrayDates;
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
            return new TaskObj($task['Task']);
        }, $tasks);
        return $data;
    }
}
