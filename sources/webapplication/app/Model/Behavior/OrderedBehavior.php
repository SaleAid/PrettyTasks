<?php

App::uses('ModelBehavior', 'Model');

class OrderedBehavior extends ModelBehavior {
    
/**
 * Settings array
 *
 * @var array
 */
	public $settings = array();
    
    protected $_startOrder = 1;
    
/**
 * Default settings
 *
 * orderedClass           	- class name of the HABTM association table between tags and models
 * field                 	- the fieldname that contains the raw tags as string
 * foreignKey            	- foreignKey used in the HABTM association
 *
 * @var array
 */
	protected $_defaults = array(
		'field' => 'order',
		'orderedAlias' => 'Ordered',
		'orderedClass' => 'Ordered',
        'foreignKey' => 'foreign_key',
        'resetBinding' => false,
	);
    
/**
 * Setup
 *
 * @param AppModel $model
 * @param array $settings
 */
	public function setup(Model $model, $config = array()) {
		if (!isset($this->settings[$model->alias])) {
			$this->settings[$model->alias] = $this->_defaults;
		}

		$this->settings[$model->alias] = array_merge($this->settings[$model->alias], $config);
		$this->settings[$model->alias]['withModel'] = $this->settings[$model->alias]['orderedClass'];
		
        $model->data[$model->alias]['oList'] = null;
		$model->data[$model->alias]['createFirst'] = false;
        
        extract($this->settings[$model->alias]);
        
        $model->bindModel(array('hasOne' => array(
			$orderedAlias => array(
				'className' => $orderedClass,
				'foreignKey' => $foreignKey,
				'unique' => true,
				'conditions' => array(
					'Ordered.model' => $model->name),
				'fields' => '',
                'dependent' => true,
				'with' => $withModel))), $resetBinding);

	}
    
    
    public function afterFind(Model $Model, $results, $primary){
        //pr($results);
    
    }
    
    public function afterSave(Model $Model, $created){
        if( $created ){
            $this->_createOrder($Model);
        } 
    }
    
    protected function _deleteOrder(Model $Model){
        
    }
    
    protected function _createOrder(Model $Model){
        $orderedAlias = $this->settings[$Model->alias]['orderedAlias']; 
        $orderedModel = $Model->{$orderedAlias};
        
        if( !$Model->data[$Model->alias]['oList'] ){
            return false; 
        }
        $oList = $Model->data[$Model->alias]['oList'];
        $order = $this->_startOrder; 
        
        if( !$Model->data[$Model->alias]['createFirst'] ){
            $order = $this->_newOrder($Model, $oList);
        }
        $data = array(
            $this->settings[$Model->alias]['foreignKey'] => $Model->data[$Model->alias][$Model->primaryKey],
            'list' => $oList,
            'model' => $Model->alias,
            'user_id' => $Model->data[$Model->alias]['user_id'], 
            $this->settings[$Model->alias]['field'] => $order
        );
        $orderedModel->create($data);
        $orderedModel->save();
    }
    
    protected function _lastPosition(Model $Model, $oList) {
		$field = $this->settings[$Model->alias]['field'];
        $options = array(
                'conditions' => array(
                                      'list' => $oList, 
                                      'model' => $Model->alias, 
                                      'user_id' => $Model->data[$Model->alias]['user_id']
                ),
				'order' => $field . ' DESC', 
				'fields' => array($field), 
				'recursive' => -1);
		$orderedAlias = $this->settings[$Model->alias]['orderedAlias']; 
        $orderedModel = $Model->{$orderedAlias};
        $last = $orderedModel->find('first', $options);
        
        return (!empty($last)) ? $last[$Model->alias][$field] : 0;
	}
    
    protected function _getPosition(Model $Model, $oList){}

	protected function _newOrder($Model, $oList) {
		$lastPosition = $this->_lastPosition($Model, $oList);
        return $lastPosition + 1;		
	}	
    
    
    

}