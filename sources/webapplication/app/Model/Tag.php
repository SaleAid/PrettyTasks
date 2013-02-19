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

/**
 * Tag model
 *
 * @package tags
 * @subpackage tags.models
 */
class Tag extends AppModel {

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Tagged' => array(
			'className' => 'Tagged',
			'foreignKey' => 'tag_id'),
		'UserTag' => array(
			'className' => 'UserTag',
			'foreignKey' => 'tag_id')
	);

/**
 * HABTM associations
 *
 * @var array $hasAndBelongsToMany
 */
	public $hasAndBelongsToMany = array();
	

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array('rule' => 'notEmpty'),
	);


/**
 * Pre-populates the tag table with entered tags
 *
 * @param array post data, should be Contoller->data
 * @return boolean
 */
	public function add($tag) {
                if (!empty($tag)) {
                        $tag = $this->multibyteKey($tag);
                        return $this->save(array('name' => $tag));
                }
        }
        
	public function multibyteKey($string = null) {
		$str = mb_strtolower($string);
		$str = preg_replace('/\xE3\x80\x80/', ' ', $str);
		$str = str_replace(array('_', '-'), '', $str);
		$str = preg_replace( '#[:\#\*"()~$^{}`@+=;,<>!&%\.\]\/\'\\\\|\[]#', "\x20", $str );
		$str = str_replace('?', '', $str);
		$str = trim($str);
		$str = preg_replace('#\x20+#', '', $str);
		$str = String::truncate($str, 10, array('exact' => true, 'ellipsis' =>''));
		return $str;
	}

/**
 * Edits an existing tag, allows only to modify upper/lowercased characters
 *
 * @param string tag uuid
 * @param array controller post data usually $this->request->data
 * @return mixed True on successfully save else post data as array
 */
	public function edit($tagId = null, $postData = null) {
		$tag = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $tagId)));

		$this->set($tag);
		if (empty($tag)) {
			throw new CakeException(__d('tags', 'Invalid Tag.'));
		}

		if (!empty($postData[$this->alias]['name'])) {
			if (strcasecmp($tag['Tag']['name'], $postData[$this->alias]['name']) !== 0) {
				return false;
			}
			$this->set($postData);
			$result = $this->save(null, true);
			if ($result) {
				$this->data = $result;
				return true;
			} else {
				return $postData;
			}
		}
	}
}
