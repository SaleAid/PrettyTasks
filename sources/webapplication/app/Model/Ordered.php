<?php

App::uses('AppModel', 'Model');

/**
 * Ordered model
 *
 */
class Ordered extends AppModel {

/**
 * Table that is used
 *
 * @var string
 */
	public $useTable = 'ordered';
    
    
    protected function _lastPosition($modelAlias, $list, $userId) {
		$options = array(
                'conditions' => array(
                                      'list' => $list, 
                                      'model' => $modelAlias, 
                                      'user_id' => $userId
                ),
				'order' => 'order DESC', 
				'fields' => array('order'), 
				'recursive' => -1);
		$last = $this->find('first', $options);
        
        return (!empty($last)) ? $last[$this->alias]['order'] : 0;
	}
    
    
    public function add($modelAlias, $list, $foreignKey, $userId, $toFirst = false){
        $order = 1; 
        if( !$toFirst ){
            $order = $this->_lastPosition($modelAlias, $list, $userId) + 1;
        }
        $data = array(
            'foreign_key' => $foreignKey,
            'list' => $list,
            'model' => $modelAlias,
            'user_id' => $userId, 
            'order' => $order
        );
        $this->create($data);
        $this->save();    
    }

}
