<?php
App::uses('AppController', 'Controller');
/**
 * Calendar Controller
 *
 */
class CalendarController extends AppController {

    public function beforeFilter(){
        parent::beforeFilter();
        //$this->Auth->allow('*');

    }
    
    public function index(){
    
    }
}