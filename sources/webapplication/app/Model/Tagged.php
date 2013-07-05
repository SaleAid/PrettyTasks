<?php
/**
 * Copyright 2009-2012, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2012, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppModel', 'Model');
App::uses('TagList', 'Model');
/**
 * Tagged model
 *
 * @package tags
 * @subpackage tags.models
 */
class Tagged extends AppModel {

/**
 * Table that is used
 *
 * @var string
 */
	public $useTable = 'tagged';

/**
 * Find methodes
 *
 * @var array
 */
	public $findMethods = array(
		'cloud' => true,
		'tagged' => true);

/**
 * belongsTo associations
 *
 * @var string
 */
	public $belongsTo = array(
		'Tag' => array(
			'className' => 'Tag'),
   );



/**
 * Find all the Model entries tagged with a given tag
 *
 * The query must contain a Model name, and can contain a 'by' key with the Tag keyname to filter the results
 * <code>
 * $this->Article->Tagged->find('tagged', array(
 *		'by' => 'cakephp',
 *		'model' => 'Article'));
 * </code
 *
 * @TODO Find a way to populate the "magic" field Article.tags
 * @param string $state
 * @param array $query
 * @param array $results
 * @return mixed Query array if state is before, array of results or integer (count) if state is after
 */
	public function _findTagged($state, $query, $results = array()) {
		if ($state == 'before') {
		  
			if (isset($query['model']) && $Model = ClassRegistry::init($query['model'])) {
				$conditions[] = array(
					$this->alias . '.model' => $Model->alias);
				
                if (!empty($query['user_id'])) {
                $conditions[] = array(
						$this->alias . '.user_id' => $query['user_id']);
                }
                $this->bindModel(array(
					'belongsTo' => array(
						$Model->alias => array(
							'className' => $Model->name,
							'foreignKey' => 'foreign_key',
							'type' => 'INNER',
							'conditions' => $conditions))), false);

				if (!isset($query['recursive'])) {
					$query['recursive'] = 0;
				}

				if ($query['recursive'] == -1) {
					throw new InvalidArgumentException(__d('tags', 'Find tagged will not work with a recursive level of -1, you need at least 0.', true), E_USER_ERROR);
				}

				if (isset($query['operation']) && $query['operation'] == 'count') {
					$query['fields'] = "COUNT(DISTINCT $Model->alias.$Model->primaryKey)";
					$this->Behaviors->Containable->setup($this, array('autoFields' => false));
				} else {
				    $query['fields'][] = " DISTINCT " . join(',', $this->getDataSource()->fields($Model));
                }
                
				if (!empty($query['by'])) {
				    $query['by'] = $Model->multibyteKey($query['by']);
					$query['conditions'][] = array(
						$this->Tag->alias . '.name' => $query['by']);
				}
                
            }
            return $query;
		} elseif ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				return array_shift($results[0][0]);
			}
            return $results;
		}
	}
    
    public function beforeDelete($cascade = true) {
         $result = $this->find('first', array(
            'conditions' => array($this->alias . '.id' => $this->id),
            'contain' => array()
         ));
         if(!empty($result)){
            $TagList = new TagList(
                                $result[$this->alias]['user_id'],
                                $result[$this->alias]['tag_id'], 
                                $result[$this->alias]['model']
            );
            $TagList->removeFromList($result[$this->alias]['foreign_key']);    
         }
         return true;
    }

}
