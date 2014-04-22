<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Days Controller
 *
 * @property Day $Day
 */
class DaysController extends AppController {

     public $components = array('Paginator');

    public $layout = 'tasks';
    
    public function setRating(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'rating' 
        );
        if (!$this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('days', 'Ошибка при передачи данных')
            );
        } else {
            $result['success'] = true;
            $result['data'] = $this->Day->setRating($this->Auth->user('id'), $this->request->data['date'],  $this->request->data['rating'])->save(); 
            $result['message'] = array(
                'type' => 'success', 
                'message' => __d('days', 'Изменение успешно сохранено')
            );   
        }
        $result['action'] = 'setRatingDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function getComment(){
        $result = $this->_prepareResponse();
        if (!$this->_isSetRequestData('date')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('days', 'Ошибка при передачи данных')
            );
        } else {
            $result['success'] = true;
            $result['data'] = $this->Day->getDay($this->Auth->user('id'), $this->request->data['date']); 
            $result['message'] = array(
                'type' => 'success', 
                'message' => __d('days', 'Готово')
            );   
        }
        $result['action'] = 'getCommentDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function setComment(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'comment' 
        );
        if (!$this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' =>__d('days', 'Ошибка при передачи данных')
            );
        } else {
            if($day = $this->Day->setComment($this->Auth->user('id'), $this->request->data['date'],  $this->request->data['comment'])->save()){
                $result['success'] = true;
                $result['data'] = $day; 
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __d('days', 'Изменение успешно сохранено')
                );    
            }else{
                $result['errors'] = $this->Day->validationErrors;
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __d('days', 'Ошибка при сохранении комментария'),
                    );
            }
        }
        $result['action'] = 'setCommentDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function journal(){
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $options = array('conditions' => array(
                                'Day.user_id' => $this->Auth->user('id'), 
                                'Day.date <=' => CakeTime::format('Y-m-d', time(), false, $this->_userTimeZone()),
                                'Day.comment !=' => ''

                            ),
                            'fields' => array('date', 'comment', 'rating' ),
                            'order' => array(
                                'Day.date' => 'DESC'
                            ),
                            'limit' => Configure::read('Days.journal.pagination.limit')
                        );
        $this->Paginator->settings = array(
                'Day' => $options
        );
        
        try {
            $result['data'] =  $this->Paginator->paginate('Day');
        } catch (NotFoundException $e) {
            $this->redirect(array('action' => 'journal'));

        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
}
