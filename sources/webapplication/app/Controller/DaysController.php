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
    
    public function getComment(){
        $result = $this->_prepareResponse();
        if ($this->_isSetRequestData('date')) {
            $result['success'] = true;
            $result['data'] = $this->Day->getComment($this->Auth->user('id'), $this->request->data['date']); 
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Готово.')
            );   
        }else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
            );
        }
        $result['action'] = 'getCommentDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
    
    public function setComment(){
        $result = $this->_prepareResponse();
        if ($this->_isSetRequestData('date','comment')) {
            $result['success'] = true;
            $result['data'] = $this->Day->setComment($this->Auth->user('id'), $this->request->data['date'],  $this->request->data['comment'])->save(); 
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
        $result['action'] = 'setCommentDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
}
