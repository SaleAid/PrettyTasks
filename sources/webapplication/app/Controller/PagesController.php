<?php
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AppController {

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
        if( $this->Auth->loggedIn() ) {
            $this->redirect(array(
                'controller' => 'tasks',
                'action' => 'index'
        ));
        }

    }
    
    public function index(){
    
    }
}