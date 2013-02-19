<?php
//App::uses('String', 'Utility');
App::uses('Model', 'Model');


class AppModel extends Model {
    
    public $actsAs = array('Containable');
    
    protected function _checkTags( $title, $name ){
        $pattern = '/#(\S+)/';
        
        preg_match_all ($pattern, $title, $matches);
        if( isset($matches[1]) ){
            $tags = array();
            foreach($matches[1] as $key => $tag){
                if( !empty($tag)){
                	
					$tag = $this->multibyteKey($tag);
                    $tags[] = $tag;
                    $title = str_replace($matches[0][$key], '#'.$tag, $title);
                }
            }
            if ( !empty($tags) )
                $this->data[$this->alias]['title'] = $title;
            	$this->data[$this->alias]['tags'] = array_unique($tags);//implode( $separator, $tags );
        }
    }
}
