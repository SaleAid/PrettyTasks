<?php
App::uses('AppModel', 'Model');
/**
 * Page Model
 *
 */
class Page extends AppModel {
    
    public $name = 'Page';
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'pages';
    
    public function view($url, $lang){
        return $this->find('first', array(
                'conditions' => array(
                                    'Page.url' => $url,
                                    'Page.lang' => $lang,
                                    'Page.active' => 1,
                            ),
                'fields' => array('title', 'metakeywords', 'metadescription', 'content')
        ));
    }
}
