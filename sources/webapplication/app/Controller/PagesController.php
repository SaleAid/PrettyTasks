<?php
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AppController {

    public $currentLang = 'ru';
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
        if( $this->Auth->loggedIn() and in_array($this->params['action'], array('', 'index'))) {
            $this->redirect(array(
                'controller' => 'tasks',
                'action' => 'index'
        ));
        }

    }
    
    public function index(){
        $this->layout = 'start';
    }
    
    public function view(){
        if(isset($this->request->pass[1])){
            $this->currentLang = $this->request->pass[0];
            $url = $this->request->pass[1];
        }else{
            $url = $this->request->pass[0];
        }
        if(!$result = $this->Page->view($url, $this->currentLang)){
            throw new NotFoundException();
            //$this->render('/Errors/error404');
        }
        $this->set('page', $result['Page']);
        
    }
}