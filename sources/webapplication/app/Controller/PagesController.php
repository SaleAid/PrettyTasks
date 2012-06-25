<?php
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AppController {

    public $currentLang = '';
    
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
        $pass = $this->request->pass;
        if(isset($pass[1]) and in_array($pass[0], Configure::read('Config.lang.list'))){
            $this->currentLang = $pass[0];
            unset($pass[0]);
            $url =  implode("/", $pass);
        }else{
            $this->currentLang = Configure::read('Config.lang.default');
            $url =  implode("/", $pass);
        }    
        if(!$result = $this->Page->view($url, $this->currentLang)){
            throw new NotFoundException();
            //$this->render('/Errors/error404');
        }
        $this->set('page', $result['Page']);
    }
    
    
}