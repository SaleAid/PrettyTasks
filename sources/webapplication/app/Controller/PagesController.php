<?php
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AppController {

    public $cacheAction = "1 hour";//TODO time in config

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');

        if( $this->Auth->loggedIn() and in_array($this->params['action'], array('', 'index'))) {
            $this->redirect(array(
                'controller' => 'tasks',
                'action' => 'index',
                'lang' => $this->params['lang'],
            ));
        }

    }
    
    public function index(){
    	$this->response->sharable(true, 3600);//TODO time in config
        $this->layout = 'start';
        $this->Seo->title = $this->Seo->title.' :: '.Configure::read('SEO.Pages.title.ru');
        $this->Seo->description = Configure::read('SEO.Pages.description.ru');
        $this->Seo->keywords = Configure::read('SEO.Pages.keywords.ru');
    }
    
    public function view(){
    	$this->response->sharable(true, 3600);//TODO time in config
        $pass = $this->request->pass;
        $url =  implode("/", $pass);
        if(!$result = $this->Page->view($url, Configure::read('Config.language'))){
            throw new NotFoundException();
            //$this->render('/Errors/error404');
        }
        $this->Seo->title = $this->Seo->title.' :: '.$result['Page']['title'];
        $this->Seo->description = $result['Page']['metadescription'];
        $this->Seo->keywords = $result['Page']['metakeywords'];
        $this->set('content', $result['Page']['content']);
    }
    
    
}