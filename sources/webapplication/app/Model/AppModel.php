<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('Model', 'Model');

/**
 */
class AppModel extends Model {

    //Don't delete this default property value
    public $recursive = -1;
    
    /**
     *
     * @var unknown_type
     */
    public $actsAs = array(
            'Containable'
    );

    /**
     * Check tags
     *
     * @param string $field
     *            the field name that editing
     * @return void
     */
    protected function _checkTags($field) {
        if (! isset($this->data[$this->alias][$field])) {
            return true;
        }
        $title = $this->data[$this->alias][$field];
        $currentTags = isset($this->data[$this->alias]['tags']) ? $this->data[$this->alias]['tags'] : array();
        $pattern = '/#(\S+)/';
        preg_match_all($pattern, $title, $matches);
        $tags = array();
        if (isset($matches[1])) {
            foreach ( $matches[1] as $key => $tag ) {
                $tag = $this->multibyteKey($tag);
                if (! empty($tag)) {
                    $tags[] = $tag;
                    $title = str_replace($matches[0][$key], '#' . $tag, $title);
                }
            }
        }
        if (! empty($tags) || ! empty($currentTags)) {
            $this->data[$this->alias][$field] = $title;
            $this->data[$this->alias]['tags'] = array_unique($tags);
        }
    }
}
