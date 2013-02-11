<?php

App::uses('Model', 'Model');


class AppModel extends Model {
    
    public $actsAs = array('Containable');
    
    protected function _checkTags( $title, $name, $separator = ',' ){
        $pattern = '/#(\S+)/';
        
        preg_match_all ($pattern, $title, $matches);
        if( isset($matches[1]) ){
            $tags = array();
            foreach($matches[1] as $tag){
                if( !empty($tag) && $this->multibyteKey($tag)){
                    $tags[] = $tag;
                    
                }
            }
            if ( !empty($tags) )
                $this->data[$this->alias]['tags'] = array_unique($tags);//implode( $separator, $tags );
        }
    }
}
