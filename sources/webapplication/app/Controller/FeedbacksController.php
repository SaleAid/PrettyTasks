<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('AppController', 'Controller');
/**
 * Feedbacks Controller
 *
 *
 * @property Feedback $Feedback
 * @property User $User
 */
class FeedbacksController extends AppController {
    public $name = 'Feedbacks';
    public $uses = array(
        'Feedback', 
        'User'
    );

    
    public function add() {
        if ($this->request->is('post')) {
            $expectedData = array(
                'category',
                'subject',
                'message'
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__d('feedbacks', 'Ошибка при передачи данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                $feed['Feedback']['lang'] = Configure::read('Config.language');
                $feed['Feedback']['category'] = $this->data['Feedback']['category'];
                $feed['Feedback']['status'] = 1;
                $feed['Feedback']['subject'] = $this->request->data['Feedback']['subject'];
                $feed['Feedback']['message'] = $this->request->data['Feedback']['message'];
                $feed['Feedback']['processed'] = 0;
                $feed['Feedback']['user_id'] = $this->Auth->user('id');
                if ($this->Feedback->save($feed)) {
                    $this->Session->setFlash(__d('feedbacks', 'Ваше сообщение было сохранено', true), 'alert', array(
                                'class' => 'alert-success'
                            ));
                    $this->redirect(array(
                        'action' => 'add'
                    ));
                } else {
                    $this->Session->setFlash(__d('feedbacks', 'Ваше сообщение не удалось сохранить. Попробуйте снова.', true), 'alert', array(
                                            'class' => 'alert-error'
                    ));    
                }
            }
        }
    }
}
