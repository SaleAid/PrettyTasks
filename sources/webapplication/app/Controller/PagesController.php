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

    }
    
    public function index(){
    
    }
}