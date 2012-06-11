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

    function beforeFilter() {
        $this->Auth->allow($this->_getAllowedActions());
        parent::beforeFilter();
    }

    function add() {
        if (! empty($this->data)) {
            $this->Feedback->create();
            $feed['Feedback']['lang'] = Configure::read('Config.language');
            $feed['Feedback']['email'] = $this->data['Feedback']['email'];
            $feed['Feedback']['name'] = $this->data['Feedback']['name'];
            $feed['Feedback']['status'] = 1;
            $feed['Feedback']['subject'] = $this->data['Feedback']['subject'];
            $feed['Feedback']['message'] = $this->data['Feedback']['message'];
            $feed['Feedback']['processed'] = 0;
            $feed['Feedback']['user_id'] = $this->Auth->user('id');
            if ($this->Feedback->save($feed)) {
                $this->Session->setFlash(sprintf(__('Ваше сообщение было сохранено', true), 'feedback'));
                $this->redirect(array(
                    'action' => 'add'
                ));
            } else {
                $this->Session->setFlash(sprintf(__('Ваше сообщение не удалось сохранить. Попробуйте снова.', true), 'feedback'));
            }
        }
    }

}
