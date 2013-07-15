<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('AppModel', 'Model');

/**
 * Page Model
 */
class Page extends AppModel {
    
    /**
     *
     * @var unknown_type
     */
    public $name = 'Page';
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'pages';

    /**
     *
     * @param unknown_type $url            
     * @param unknown_type $lang            
     * @return Ambigous <multitype:, NULL, mixed>
     */
    public function view($url, $lang) {
        return $this->find('first', array(
                'conditions' => array(
                        'Page.url' => $url,
                        'Page.lang' => $lang,
                        'Page.active' => 1
                ),
                'fields' => array(
                        'title',
                        'metakeywords',
                        'metadescription',
                        'content'
                )
        ));
    }
}
