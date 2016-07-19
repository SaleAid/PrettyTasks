<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
App::uses('Setting', 'Model');
App::uses('DayObj', 'Lib');

class PinaricController extends AppController {
    public $components = array('Paginator');
    public $layout = 'pinaric';
    public $uses = array('Day');
    public $helpers = array('Pinaric');

    public function index() {
        $year = date('Y');

        $user_days = $this->Day->getDays($this->Auth->user('id'), $year.'-1-1', $year.'-12-31');
        $days = [];

        $day_counter = 1;
        $days_in_a_year = $year % 4 == 0 ? 366 : 365;

        while ($day_counter <= $days_in_a_year) {
            $date = date('Y-m-d', mktime(0,0,0,1,$day_counter,$year));
            $days[$date] = new DayObj(['date' => $date]);
            $day_counter++;
        }

        $this->set(['days' => array_merge($days, $user_days)]);
    }

}