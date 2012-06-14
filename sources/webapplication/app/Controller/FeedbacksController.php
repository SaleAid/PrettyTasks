<?php
class FeedbacksController extends AppController {
    public $name = 'Feedbacks';
    public $uses = array(
        'Feedback', 
        'User'
    );

    public function _getAllowedActions() {
        return array(
            'add_from_application', 
            'add'
        );
    }

    public function beforeFilter() {
        $this->Auth->allow($this->_getAllowedActions());
        parent::beforeFilter();
    }

    public function add() {
        if (! empty($this->request->data)) {
            $feed['Feedback']['lang'] = Configure::read('Config.language');
            $feed['Feedback']['category'] = $this->data['Feedback']['category'];
            $feed['Feedback']['status'] = 1;
            $feed['Feedback']['subject'] = $this->request->data['Feedback']['subject'];
            $feed['Feedback']['message'] = $this->request->data['Feedback']['message'];
            $feed['Feedback']['processed'] = 0;
            $feed['Feedback']['user_id'] = $this->Auth->user('id');
            if ($this->Feedback->save($feed)) {
                $this->Session->setFlash(__('Ваше сообщение было сохранено', true), 'alert', array(
                            'class' => 'alert-success'
                        ));
                $this->redirect(array(
                    'action' => 'add'
                ));
            } else {
                $messages ='';
                foreach($this->Feedback->validationErrors as $items){
                    if(is_array($items)){
                        foreach($items as $item){
                            if(!empty($item)){
                                $messages = $messages.$item.'<br>';
                            }
                        }
                    }
                }
            $this->Session->setFlash(__($messages.'Ваше сообщение не удалось сохранить. Попробуйте снова.', true), 'alert', array(
                                    'class' => 'alert-error'
            ));    
            }
        }
    }

}
