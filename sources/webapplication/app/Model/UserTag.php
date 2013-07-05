<?php
/**
 *
 */
App::uses('AppModel', 'Model');

/**
 * User_Tag model
 *
 */
class UserTag extends AppModel {

/**
 * Table that is used
 *
 * @var string
 */
	public $useTable = 'users_tags';
/**
 * Validation domain
 *
 * @var string
 */
	public $validationDomain = 'users_tags';
/**
 * belongsTo associations
 *
 * @var string
 */
	public $belongsTo = array(
		'Tag'
   );
   
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array('rule' => 'notEmpty'),
		'tag_id' => array('rule' => 'notEmpty'),
        'user_id' => array('rule' => 'notEmpty'),
        'comment' => array(
					'maxLength' => array(
							'rule' => array(
									'maxLength',
									10000
							),
							'message' => 'Максимальная длина комментария не больше %d символов'
					)
			),
   );
   
   /**
	 * Get comment
	 * 
	 * @param string $user_id
	 * @param string $tag_id
	 * @return  string
	 */
   public function getComment($user_id, $tag_id){
   		$options['conditions'] = array(
   						$this->alias . '.tag_id' => $tag_id,
   						$this->alias . '.user_id' => $user_id						
   		);
   		$options['contain'] = array();
   		$options['fields'] = array('comment');
   		
   		return Set::extract($this->find('first', $options), $this->alias . '.comment');
   }
   
   /**
	 * Set comment
	 * 
	 * @param string $user_id
	 * @param string $tag_id
     * @param string $comment   
	 * @return  
	 */
   public function setComment($user_id, $tag_id, $comment){
   		$this->contain();
        $result = $this->findByUserIdAndTag_id($user_id, $tag_id);
        if ($result) {
            $this->set($result);
        }
   		$saveData['user_id'] = $user_id; 
   		$saveData['tag_id'] = $tag_id;
   		$saveData['comment'] = $comment;
   		return $this->save($saveData);
   }

}
