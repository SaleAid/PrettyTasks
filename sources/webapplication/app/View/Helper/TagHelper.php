<?php
class TagHelper extends AppHelper {

    public function wrap($title, $tags = array()){
        $title = h($title);
        if (!empty($tags)){
            foreach( $tags as $tag ){
                if (!empty($tag)){
                    $tag = h($tag);
                    $title = str_replace('#'.$tag, '<span class="tags" data-tag="'.$tag.'">&#x23;'.$tag.'</span>', $title);
                }
            }
        }
        return $title;
    }
}
