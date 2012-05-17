<?php
App::uses('AppController', 'Controller');
/**
 * Days Controller
 *
 * @property Day $Day
 */
class DaysController extends AppController {

    public function getDayRating(){
        $result = $this->_prepareResponse();
        if ($this->_isSetRequestData('date')) {
            $result['success'] = true;
            $result['data'] = $this->Day->getDayRating($this->Auth->user('id'), $this->Auth->user('date'));    
        }else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
            );
        }
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
}
