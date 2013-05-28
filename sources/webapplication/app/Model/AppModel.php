<?php
//App::uses('String', 'Utility');
App::uses('Model', 'Model');


class AppModel extends Model {
    
    public $actsAs = array('Containable');
    /**
	 * Check tags
	 * 
	 * @param string $field  the field name that editing
	 * @return  void
	 */
    protected function _checkTags($field ){
        
        if ( !isset($this->data[$this->alias][$field]) ){
            return true;
        }
        $title = $this->data[$this->alias][$field];
        $currentTags = isset($this->data[$this->alias]['tags']) ? $this->data[$this->alias]['tags'] : array();
        $pattern = '/#(\S+)/';
        preg_match_all ($pattern, $title, $matches);
        $tags = array();
        if( isset($matches[1]) ){
            foreach($matches[1] as $key => $tag){
                $tag = $this->multibyteKey($tag);
                if( !empty($tag)){
                	$tags[] = $tag;
                    $title = str_replace($matches[0][$key], '#'.$tag, $title);
                }
            }
        }
        if ( !empty($tags) || !empty($currentTags) ) {
            $this->data[$this->alias][$field] = $title;
        	$this->data[$this->alias]['tags'] = array_unique($tags);
        }
    }
}
