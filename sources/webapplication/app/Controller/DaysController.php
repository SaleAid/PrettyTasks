<?php
App::uses('AppController', 'Controller');
/**
 * Days Controller
 *
 * @property Day $Day
 */
class DaysController extends AppController {


    public function setRating(){
        $result = $this->_prepareResponse();
        if ($this->_isSetRequestData('date','rating')) {
            $result['success'] = true;
            $result['data'] = $this->Day->setRating($this->Auth->user('id'), $this->request->data['date'],  $this->request->data['rating'])->save(); 
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Изменение успешно сохранено.')
            );   
        }else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
            );
        }
        $result['action'] = 'setRatingDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
}
