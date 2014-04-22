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
 * Goal Model
 *
 * @property User $User
 */
class Goal extends AppModel {
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
            'title' => array(
                    'notempty' => array(
                            'rule' => array(
                                    'notempty'
                            )
                    )
            ),
            'user_id' => array(
                'numeric'
            )
    );
    
    /**
     * Allow custom find methods
     */
    public $findMethods = array(
            'current' => true,
            'expired' => true,
            'closed' => true,
            'future' => true,
            'planned' => true,
            'deleted' => true
    );
    
    // The Associations below have been created with all possible keys, those that are not needed can be removed
    
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
     * Allowed fields
     *
     * @var array
     */
    private $_allowedFields = array(
            'id',
            'title',
            'comment',
            'fromdate',
            'todate',
            'datedone',
            'done',
            'deleted',
            'user_id'
    );

    /**
     * Get goals.
     *
     * $UserId is required parameter.
     * $Date is required parameter. Actual goals are shown for this date.
     *
     * $toDate is optional parameter. This is the date after which goals are not selected.
     * $additioanlOptions - options for finder, see http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#find.
     * This array will be merged with inner options array, and it can redefine options.
     *
     * Defaults $Date= today, toDate = date, count = 25 , order goal.todate ASC, goal.fromdate DESC
     *
     * @param string $userId            
     * @param string $date            
     * @param string $todate            
     * @param array $additioanlOptions            
     * @access public
     * @return Ambigous <multitype:, NULL, mixed>
     * @todo METHOD is not ready YET!!!
     */
    // public function getCurrent($userId, $date = null, $toDate = null, $additioanlOptions = array()) {
    protected function _findCurrent($state, $query, $results = array()) {
        if ($state == 'before') {
            // debug($query);
            $fromdate = isset($query['conditions'][$this->alias . '.periodFrom']) ? $query['conditions'][$this->alias . '.periodFrom'] : date("Y-m-d");
            $todate = isset($query['conditions'][$this->alias . '.periodTo']) ? $query['conditions'][$this->alias . '.periodTo'] : $fromdate;
            unset($query['conditions'][$this->alias . '.periodFrom']);
            unset($query['conditions'][$this->alias . '.periodTo']);
            $conditions = array(
                    'OR' => array(
                            array( // Start in period
                                    $this->alias . '.fromdate >=' => $fromdate,
                                    $this->alias . '.fromdate <=' => $todate
                            ),
                            array( // End in period
                                    $this->alias . '.todate >=' => $fromdate,
                                    $this->alias . '.todate <=' => $todate
                            ),
                            array( // Period between start and end
                                    $this->alias . '.fromdate <=' => $fromdate,
                                    $this->alias . '.todate >=' => $todate
                            )
                    )
            );
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            // debug($query);
            return $query;
        }
        return $results;
    }

    /**
     *
     * @param unknown_type $state            
     * @param unknown_type $query            
     * @param unknown_type $results            
     * @return multitype: unknown
     */
    protected function _findExpired($state, $query, $results = array()) {
        if ($state == 'before') {
            $todate = isset($query['conditions'][$this->alias . '.periodTo']) ? $query['conditions'][$this->alias . '.periodTo'] : date("Y-m-d");
            unset($query['conditions'][$this->alias . '.periodTo']);
            $conditions = array(
                    $this->alias . '.todate <' => $todate,
                    $this->alias . '.done' => 0
            );
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            return $query;
        }
        return $results;
    }

    /**
     *
     * @param unknown_type $state            
     * @param unknown_type $query            
     * @param unknown_type $results            
     * @return multitype: unknown
     */
    protected function _findClosed($state, $query, $results = array()) {
        if ($state == 'before') {
            // debug($query);
            $conditions = array(
                    $this->alias . '.done' => 1
            );
            $fromdate = isset($query['conditions'][$this->alias . '.periodFrom']) ? $query['conditions'][$this->alias . '.periodFrom'] : null;
            $todate = isset($query['conditions'][$this->alias . '.periodTo']) ? $query['conditions'][$this->alias . '.periodTo'] : null;
            unset($query['conditions'][$this->alias . '.periodFrom']);
            unset($query['conditions'][$this->alias . '.periodTo']);
            if ($fromdate && $todate) {
                $conditions = array_merge($conditions, array(
                        'OR' => array(
                                array( // Start in period
                                        $this->alias . '.fromdate >=' => $fromdate,
                                        $this->alias . '.fromdate <=' => $todate
                                ),
                                array( // End in period
                                        $this->alias . '.todate >=' => $fromdate,
                                        $this->alias . '.todate <=' => $todate
                                ),
                                array( // Period between start and end
                                        $this->alias . '.fromdate <=' => $fromdate,
                                        $this->alias . '.todate >=' => $todate
                                )
                        )
                ));
            }
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            // debug($query);
            return $query;
        }
        return $results;
    }

    /**
     *
     * @param unknown_type $state            
     * @param unknown_type $query            
     * @param unknown_type $results            
     * @return multitype: unknown
     */
    protected function _findFuture($state, $query, $results = array()) {
        if ($state == 'before') {
            $fromdate = isset($query['conditions'][$this->alias . '.periodFrom']) ? $query['conditions'][$this->alias . '.periodFrom'] : date("Y-m-d");
            unset($query['conditions'][$this->alias . '.periodFrom']);
            unset($query['conditions'][$this->alias . '.periodTo']);
            $conditions = array(
                    $this->alias . '.fromdate >' => $fromdate,
                    $this->alias . '.todate >' => $fromdate
            );
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            return $query;
        }
        return $results;
    }

    /**
     *
     * @param unknown_type $state            
     * @param unknown_type $query            
     * @param unknown_type $results            
     * @return multitype: unknown
     */
    protected function _findPlanned($state, $query, $results = array()) {
        if ($state == 'before') {
            unset($query['conditions'][$this->alias . '.periodFrom']);
            unset($query['conditions'][$this->alias . '.periodTo']);
            $conditions = array(
                    $this->alias . '.fromdate' => null,
                    $this->alias . '.todate' => null
            );
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            return $query;
        }
        return $results;
    }

    /**
     *
     * @param unknown_type $state            
     * @param unknown_type $query            
     * @param unknown_type $results            
     * @return multitype: unknown
     */
    protected function _findDeleted($state, $query, $results = array()) {
        if ($state == 'before') {
            unset($query['conditions'][$this->alias . '.periodFrom']);
            unset($query['conditions'][$this->alias . '.periodTo']);
            $conditions = array(
                    $this->alias . '.deleted' => 1
            );
            $query['fields'] = $query['fields'] ? $query['fields'] : $this->_allowedFields;
            $query['conditions'] = array_merge($conditions, $query['conditions']);
            return $query;
        }
        return $results;
    }
}
