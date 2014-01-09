<?php
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AppController {
    
    public $layout = 'pages';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        
        if ($this->Auth->loggedIn() and in_array($this->params['action'], array(
            '', 
            'index'
        ))) {
            $this->redirect(array(
                'controller' => 'tasks', 
                'action' => 'index', 
            ));
        }
    
    }

    public function index() {
        $this->layout = 'start';
        $this->Seo->title = $this->Seo->title . ' :: ' . Configure::read('SEO.Pages.title.'.Configure::read('Config.langURL'));
        $this->Seo->description = Configure::read('SEO.Pages.description.'.Configure::read('Config.langURL'));
        $this->Seo->keywords = Configure::read('SEO.Pages.keywords.'.Configure::read('Config.langURL'));
        $this->viewPath = $this->viewPath . DS . Configure::read('Config.language');
    }
    public function inew() {
        $this->layout = 'start';
        $this->Seo->title = $this->Seo->title . ' :: ' . Configure::read('SEO.Pages.title.'.Configure::read('Config.langURL'));
        $this->Seo->description = Configure::read('SEO.Pages.description.'.Configure::read('Config.langURL'));
        $this->Seo->keywords = Configure::read('SEO.Pages.keywords.'.Configure::read('Config.langURL'));
        $this->viewPath = $this->viewPath . DS . Configure::read('Config.language');
    }    

    public function view() {
        $pass = $this->request->pass;
        $url = implode("/", $pass);
        if (! $result = $this->Page->view($url, Configure::read('Config.language'))) {
            throw new NotFoundException();
        }
        $this->Seo->title = $this->Seo->title . ' :: ' . $result['Page']['title'];
        $this->Seo->description = $result['Page']['metadescription'];
        $this->Seo->keywords = $result['Page']['metakeywords'];
        $this->set('content', $result['Page']['content']);
    }

}