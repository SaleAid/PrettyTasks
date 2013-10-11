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
App::uses('ModelBehavior', 'Model');
App::uses('TagEventListener', 'Event');

/**
 * Taggable Behavior
 *
 * @package tags
 * @subpackage tags.models.behaviors
 */
class TaggableBehavior extends ModelBehavior {

/**
 * Settings array
 *
 * @var array
 */
	public $settings = array();

/**
 * Default settings
 *
 * separator             	- separator used to enter a lot of tags, comma by default
 * tagAlias              	- model alias for Tag model
 * tagClass              	- class name of the table storing the tags
 * taggedClass           	- class name of the HABTM association table between tags and models
 * field                 	- the fieldname that contains the raw tags as string
 * foreignKey            	- foreignKey used in the HABTM association
 * associationForeignKey 	- associationForeignKey used in the HABTM association
 * automaticTagging      	- if set to true you don't need to use saveTags() manually
 * language              	- only tags in a certain language, string or array
 * taggedCounter         	- true to update the number of times a particular tag was used for a specific record
 * unsetInAfterFind      	- unset 'Tag' results in afterFind
 * deleteTagsOnEmptyField 	- delete associated Tags if field is empty.
 *
 * @var array
 */
	protected $_defaults = array(
		'separator' => ',',
		'field' => 'tags',
		'tagAlias' => 'Tag',
		'tagClass' => 'Tag',
		'taggedAlias' => 'Tagged',
		'taggedClass' => 'Tagged',
        'userTagAlias' => 'UserTag',
		'userTagClass' => 'UserTag',
		'foreignKey' => 'foreign_key',
		'associationForeignKey' => 'tag_id',
		'cacheOccurrence' => true,
		'automaticTagging' => true,
		'unsetInAfterFind' => false,
		'resetBinding' => false,
		'taggedCounter' => false,
		'deleteTagsOnEmptyField' => true,
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
		$this->settings[$model->alias]['withModel'] = $this->settings[$model->alias]['taggedClass'];
		extract($this->settings[$model->alias]);

		$model->bindModel(array('hasAndBelongsToMany' => array(
			$tagAlias => array(
				'className' => $tagClass,
				'foreignKey' => $foreignKey,
				'associationForeignKey' => $associationForeignKey,
				'unique' => true,
				'conditions' => array(
					'Tagged.model' => $model->name),
				'fields' => '',
				'dependent' => true,
				'with' => $withModel))), $resetBinding);

		$model->$tagAlias->bindModel(array('hasMany' => array(
			$taggedAlias => array(
				'className' => $taggedClass))), $resetBinding);
    
        $model->$tagAlias->bindModel(array('belongsTo' => array(
			$userTagAlias => array(
				'className' => $userTagClass))), $resetBinding);
                
        $model->getEventManager()->attach(new TagEventListener());
	}

/**
 * Disassembles the incoming tag string by its separator and identifiers and trims the tags
 *
 * @param object $model Model instance
 * @param string $string incoming tag string
 * @param string $separator separator character
 * @return array Array of 'tags' and 'identifiers', use extract to get both vars out of the array if needed
 */
	public function disassembleTags(Model $model, $tags = array()) {
		$array = $tags;
        $tags = array();
		foreach ($array as $tag) {
			$tag = trim($tag);
			if (!empty($tag)) {
				$key = $this->multibyteKey($model, $tag);
				if ( !empty($key) ) {
					$tags[] = array('name' => $key);
				}
			}
		}
        return compact('tags');
	}

/**
 * Saves a string of tags
 *
 * @param AppModel $model
 * @param string $string comma separeted list of tags to be saved
 *		Tags can contain special tokens called `identifiers´ to namespace tags or classify them into catageories.
 *		A valid string is "foo, bar, cakephp:special". The token `cakephp´ will end up as the identifier or category for the tag `special´
 * @param mixed $foreignKey the identifier for the record to associate the tags with
 * @param boolean $update true will remove tags that are not in the $string, false wont
 * do this and just add new tags without removing existing tags associated to
 * the current set foreign key
 * @return array
 */
	public function saveTags(Model $model, $tags = array(), $foreignKey = null, $user_id = null, $update = true) {
		if ( !empty($foreignKey) || $foreignKey === false ) {
			$tagAlias = $this->settings[$model->alias]['tagAlias'];
			$taggedAlias = $this->settings[$model->alias]['taggedAlias'];
            $userTagAlias = $this->settings[$model->alias]['userTagAlias'];
			$tagModel = $model->{$tagAlias};
            $userTagModel = $tagModel->{$userTagAlias};

			extract($this->disassembleTags($model, $tags));
            if (!empty($tags)) {
				$existingTags = $tagModel->find('all', array(
					'contain' => array(),
					'conditions' => array(
						$tagAlias . '.name' => Set::extract($tags, '{n}.name')
                    ),
					'fields' => array(
						$tagAlias . '.name',
						$tagAlias . '.id')
                    )
                );
                
                if (!empty($existingTags)) {
					foreach ($existingTags as $existing) {
						$existingTagNames[] = $existing[$tagAlias]['name'];
						$existingTagIds[] = $existing[$tagAlias]['id'];
					}
					$newTags = array();
					foreach($tags as $possibleNewTag) {
						$name = $possibleNewTag['name'];
						if (!in_array($name, $existingTagNames)) {
							array_push($newTags, $possibleNewTag);
						}
					}
				} else {
					$existingTagIds = $alreadyTagged = array();
					$newTags = $tags;
				}
                $newTagIds = array();
                foreach ($newTags as $key => $newTag) {
					$tagModel->create();
					$tagModel->save($newTag);
					$newTagIds[] = $tagModel->id;
                    //$userTagModel->create();
					//$userTagModel->save(array('tag_id' => $tagModel->id, 'user_id' => $user_id));
                }
                
                $allTagIds = array_merge($existingTagIds, $newTagIds);
                
                $existingUserTagsId = $userTagModel->find('all', array(
					'contain' => array(),
					'conditions' => array(
						$userTagAlias . '.tag_id' => $existingTagIds,
                        $userTagAlias . '.user_id' => $user_id
                        ),
					'fields' => array($userTagAlias . '.tag_id')
                ));
                $uNewTagIds = array();    
                if(!empty($existingUserTagsId)){
                    foreach($existingUserTagsId as $uTagId) {
						if (!in_array($uTagId[$userTagAlias]['tag_id'], $existingTagIds)) {
							array_push($uNewTagIds, $uTagId[$userTagAlias]['tag_id']);
						}
					}    
                }else{
                    $uNewTagIds = $existingTagIds;
                }
                
                if (!empty($newTagIds)) {
                    $uNewTagIds = array_merge($uNewTagIds, $newTagIds);
                }
                foreach ($uNewTagIds as $key => $newTagId) {
					$userTagModel->create();
					$userTagModel->save(array('tag_id' => $newTagId, 'user_id' => $user_id));
                }
                
                if ($foreignKey !== false) {
					if (!empty($newTagIds)) {
						$existingTagIds = array_merge($existingTagIds, $newTagIds);
					}
					$tagged = $tagModel->{$taggedAlias}->find('all', array(
						'contain' => array(),
						'conditions' => array(
							$taggedAlias . '.model' => $model->name,
							$taggedAlias . '.foreign_key' => $foreignKey,
							$taggedAlias . '.tag_id' => $existingTagIds,
                            ),
                        'fields' => 'Tagged.tag_id'));

					$deleteAll = array(
						$taggedAlias . '.foreign_key' => $foreignKey,
						$taggedAlias . '.model' => $model->name);

					if (!empty($tagged)) {
						$alreadyTagged = Set::extract($tagged, "{n}.{$taggedAlias}.tag_id");
						$existingTagIds = array_diff($existingTagIds, $alreadyTagged);
						$deleteAll['NOT'] = array($taggedAlias . '.tag_id' => $alreadyTagged);
					}
                    
                    $newTagIds = $oldTagIds = array();

					if ($update == true) {
						$oldTagIds = $tagModel->{$taggedAlias}->find('all', array(
							'contain' => array(),
							'conditions' => array(
								$taggedAlias . '.model' => $model->name,
								$taggedAlias . '.foreign_key' => $foreignKey,
                            ),
							'fields' => 'Tagged.tag_id'));

						$oldTagIds = Set::extract($oldTagIds, '/Tagged/tag_id');
						$tagModel->{$taggedAlias}->deleteAll($deleteAll, false, true);
					}
                    
                    foreach ($existingTagIds as $tagId) {
						$data[$taggedAlias]['tag_id'] = $tagId;
						$data[$taggedAlias]['model'] = $model->name;
						$data[$taggedAlias]['foreign_key'] = $foreignKey;
                        $data[$taggedAlias]['user_id'] = $user_id;
						$tagModel->{$taggedAlias}->create();
						$tagModel->{$taggedAlias}->save($data);
                    }
                    
                    foreach($allTagIds as $tagId){
                        $model->getEventManager()->dispatch(new CakeEvent('Model.Tag.addToList', null, array('tagId' => $tagId, 'userId' => $user_id, 'model' => $model->name, 'foreignKey' => $foreignKey)));
                    }

					//To update occurrence
					/*
                    if ($this->settings[$model->alias]['cacheOccurrence']) {
						$newTagIds = $tagModel->{$taggedAlias}->find('all', array(
							'contain' => array(),
							'conditions' => array(
								$taggedAlias . '.model' => $model->name,
								$taggedAlias . '.foreign_key' => $foreignKey,
							),
							'fields' => 'Tagged.tag_id'));

						if (!empty($newTagIds)) {
							$newTagIds = Set::extract($newTagIds, '{n}.Tagged.tag_id');
						}
                        
						$tagIds = array_merge($oldTagIds, $newTagIds);
                        $tagIds = array_unique($tagIds);
						$this->cacheOccurrence($model, $tagIds, $user_id);
					}
                    */
				}
			}
			return true;
		}
		return false;
	}

/**
 * Cache the weight or occurence of a tag in the tags table
 *
 * @param object $model instance of a model
 * @param string $tagId Tag UUID
 * @param string $userId User UUID
 * @return void
 */
	public function cacheOccurrence(Model $model, $tagIds, $userId) {
		if (is_string($tagIds) || is_int($tagIds)) {
			$tagIds = array($tagIds);
		}
        foreach ($tagIds as $tagId) {
			$fieldName = Inflector::underscore($model->name) . '_occurrence';
			$tagModel = $model->{$this->settings[$model->alias]['tagAlias']};
			$userTagModel = $tagModel->{$this->settings[$model->alias]['userTagAlias']};
            $taggedModel = $tagModel->{$this->settings[$model->alias]['taggedAlias']};
            
            $id = $userTagModel->find('first', 
                        array(
                            'contain' => array(),
                            'conditions' => array(
                                'tag_id' => $tagId,
                                'user_id' => $userId
                             ),
                            'fields' => array('id')
                        )
                    );
			if(!empty($id)){
			     $data = array('id' => $id[$this->settings[$model->alias]['userTagAlias']]['id']);
			}else{
    			 $data = array(
                    'tag_id' => $tagId,
                    'user_id' => $userId
                ); 
			}
            
            if ($userTagModel->hasField($fieldName)) {
				$data[$fieldName] = $taggedModel->find('count', array(
					'conditions' => array(
						'Tagged.tag_id' => $tagId,
						'Tagged.model' => $model->name,
                        'Tagged.user_id' => $userId),
                ));
			}

			$data['occurrence'] = $taggedModel->find('count', array(
				'conditions' => array(
					'Tagged.tag_id' => $tagId,
                    'Tagged.user_id' => $userId)));
            $userTagModel->save($data, array('validate' => false, 'callbacks' => false));
		}
	}

/**
 * Creates a multibyte safe unique key
 *
 * @param object Model instance
 * @param string Tag name string
 * @return string Multibyte safe key string
 */
	public function multibyteKey(Model $model, $string = null) {
		$str = mb_strtolower($string);
		$str = preg_replace('/\xE3\x80\x80/', ' ', $str);
		$str = str_replace(array('_', '-'), '', $str);
		$str = preg_replace( '#[:\#\*"()~$^{}`@+=;,<>!&%\.\]\/\'\\\\|\[]#', "\x20", $str );
		$str = str_replace('?', '', $str);
		$str = trim($str);
		$str = preg_replace('#\x20+#', '', $str);
		$str = String::truncate($str, $model->{$this->settings[$model->alias]['tagAlias']}->maxLengthTag, array('exact' => true, 'ellipsis' =>''));
		return $str;
	}

/**
 * Generates comma-delimited string of tag names from tag array(), needed for
 * initialization of data for text input
 *
 * Example usage (only 'Tag.name' field is needed inside of method):
 * <code>
 * $this->Blog->hasAndBelongsToMany['Tag']['fields'] = array('name', 'keyname');
 * $blog = $this->Blog->read(null, 123);
 * $blog['Blog']['tags'] = $this->Blog->Tag->tagArrayToString($blog['Tag']);
 * </code>
 *
 * @param array $string
 * @return string
 */
	public function tagArrayToString(Model $model, $data = null) {
		if ($data) {
			return join($this->settings[$model->alias]['separator'].' ', Set::extract($data, '{n}.name'));
		}
		return '';
	}
    
    public function tagArray(Model $model, $data = null) {
		if (!empty($data)) {
			//return Set::extract($data, '{n}.name');
            return Set::combine($data, '{n}.id', '{n}.name');
        }
		return '';
	}

/**
 * afterSave callback
 *
 * @param AppModel $model
 */
	public function afterSave(Model $model, $created, $options = array()) {
	    $hasTags = !empty($model->data[$model->alias][$this->settings[$model->alias]['field']]);
        $user_id = $model->data[$model->alias]['user_id'];
		if ($this->settings[$model->alias]['automaticTagging'] == true && $hasTags) {
			$this->saveTags($model, $model->data[$model->alias][$this->settings[$model->alias]['field']], $model->id, $user_id);
		} else if (!$hasTags && $this->settings[$model->alias]['deleteTagsOnEmptyField']) {
			$this->deleteTagged($model, $user_id);
		}
	}
    
    public function afterDelete(Model $model){
        $userId = $model->data[$model->name]['user_id'];
        $tagIds = array_keys($model->data[$model->name]['tags']);
        $this->cacheOccurrence($model, $tagIds, $userId);
    }


/**
 * Delete associated Tags if record has no tags and deleteTagsOnEmptyField is true
 * @param object Model instance
 */
	public function deleteTagged(Model $model, $userId){
		extract($this->settings[$model->alias]);
		$tagModel = $model->{$tagAlias};
		
        $tagIds = $tagModel->{$taggedAlias}->find('all', array(
							'contain' => array(),
							'conditions' => array(
								$taggedAlias . '.model' => $model->name,
								$taggedAlias . '.foreign_key' => $model->id,
							),
							'fields' => 'Tagged.tag_id'));
        
        $tagModel->{$taggedAlias}->deleteAll(
			array(
				$taggedAlias . '.model' => $model->name,
				$taggedAlias . '.foreign_key' => $model->id,
			),
            true,
            true
		);
        if(!empty($tagIds)){
            $tagIds = Set::extract($tagIds, '{n}.Tagged.tag_id');
            $this->cacheOccurrence($model, $tagIds, $userId);
        }
 
	}

/**
 * afterFind Callback
 *
 * @param AppModel $model
 * @param array $results
 * @param boolean $primary
 * @return array
 */
	public function afterFind(Model $model, $results, $primary = false) {
		extract($this->settings[$model->alias]);
        foreach ($results as $key => $row) {
			$row[$model->alias][$field] = '';
            if (isset($row[$tagAlias]) && !empty($row[$tagAlias])) {
				//$row[$model->alias][$field] = $this->tagArrayToString($model, $row[$tagAlias]);
                $row[$model->alias][$field] = $this->tagArray($model, $row[$tagAlias]);
                if ($unsetInAfterFind == true) {
					unset($row[$tagAlias]);
				}
			}
			$results[$key] = $row;
        }
        return $results;
	}
}
