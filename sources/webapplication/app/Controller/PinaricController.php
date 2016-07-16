<?php

class PinaricController extends AppController {

    public $components = array('Paginator');
    public $layout = 'pinaric';
    public $uses = array('Day', 'Setting');
    public $helpers = array('Pinaric');

    public function index() {
        $this->set('title_for_layout', 'Pinaric');
    }

}