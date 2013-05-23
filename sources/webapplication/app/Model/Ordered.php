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
    
    
    protected function _lastPosition($modelAlias, $list, $listId, $userId) {
		$options = array(
                'conditions' => array(
                                      'list' => $list,
                                      'list_id' => $listId, 
                                      'model' => $modelAlias, 
                                      'user_id' => $userId
                ),
				'order' => 'order DESC', 
				'fields' => array('order'), 
				'recursive' => -1);
		$last = $this->find('first', $options);
        
        return (!empty($last)) ? $last[$this->alias]['order'] : 0;
	}
    
    
    public function add($modelAlias, $list, $listId, $foreignKey, $userId, $toFirst = false){
        $order = 1; 
        if( !$toFirst ){
            $order = $this->_lastPosition($modelAlias, $list, $listId, $userId) + 1;
        }
        $data = array(
            'foreign_key' => $foreignKey,
            'list' => $list,
            'list_id' => $listId, 
            'model' => $modelAlias,
            'user_id' => $userId, 
            'order' => $order
        );
        if( $toFirst ){
            $this->__incrementPositionsOnLowerItems(1, $modelAlias, $list, $listId, $userId);
        }
        $this->create($data);
        $this->save();
            
    }
    
    /**
     * Inserts an item on a certain position
     *
     */
    public function insert($modelAlias, $list, $listId, $foreignKey, $userId, $position){
        $data = array(
            'foreign_key' => $foreignKey,
            'list' => $list,
            'list_id' => $listId, 
            'model' => $modelAlias,
            'user_id' => $userId, 
            'order' => $position
        );
        $this->__incrementPositionsOnLowerItems($position, $modelAlias, $list, $listId, $userId);
        $this->create($data);
        $this->save();
    }
    
    /**
     * Moves all lower items one position down
     *
     * @return boolean
     */
	private function __incrementPositionsOnLowerItems($position, $modelAlias, $list, $listId, $userId) {
	   	return $this->updateAll(
			array(
                $this->alias . '.order' => $this->alias . '.order + 1',
                $this->alias . '.modified' => "'" . date("Y-m-d H:i:s") . "'"
                ),
			array(
                $this->alias . '.order >=' => $position,
                $this->alias . '.list' => $list,
                $this->alias . '.list_id' => $listId, 
                $this->alias . '.model' => $modelAlias,
                $this->alias . '.user_id' => $userId,
                )
		  );
	}
    
    /**
     * This has the effect of moving all the lower items up one
     *
     * @return boolean
     */
	private function __decrementPositionsOnLowerItems($position, $modelAlias, $list, $listId, $userId) {
		return $this->updateAll(
			array(
                $this->alias . '.order' => $this->alias . '.order - 1',
                $this->alias . '.modified' => "'" . date("Y-m-d H:i:s") . "'"
            ),
			array(
                $this->alias . '.order >' => $position,
                $this->alias . '.list' => $list,
                $this->alias . '.list_id' => $listId,
                $this->alias . '.model' => $modelAlias,
                $this->alias . '.user_id' => $userId,
            )
		);
    }
    
    public function beforeDelete(){
        $this->__decrementPositionsOnLowerItems(
                                        $this->data[$this->alias]['order'], 
                                        $this->data[$this->alias]['model'],
                                        $this->data[$this->alias]['list'],
                                        $this->data[$this->alias]['list_id'],
                                        $this->data[$this->alias]['user_id']
                                        );
        return true;
    }

}
