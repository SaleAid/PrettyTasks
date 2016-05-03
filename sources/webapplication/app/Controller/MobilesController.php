<?php
/**
 */
App::uses('AppController', 'Controller');

class MobilesController extends AppController {
    public $name = 'Mobiles';
    public $uses = null;
    
    public function index() {
        $this->layout = 'mobile';
    }

    /**
     * Redirect to desktop version
     */
    public function go2desktop() {
        $this->autoRender = false;
        $this->Cookie->write('desktop', 1, false, '+52 weeks');
        $this->redirect(array(
        		'controller' => 'tasks',
        		'action' => 'index'
        ));
    }
    
    /**
     * Redirect to mobile version
     */
    public function go2mobile() {
        $this->autoRender = false;
        $this->Cookie->write('desktop', 0, false, '+52 weeks');
        $this->redirect(array(
                'controller' => 'mobiles',
                'action' => 'index'
        ));
    }

}