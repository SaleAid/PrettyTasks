<?php
/**
 * 
 */
App::uses('AppController', 'Controller');
class MobilesController extends AppController {
    
    public $name = 'Mobiles';
    public $uses = null;
    
    
    public function index(){
        $this->layout = 'mobile';

    }
    
}