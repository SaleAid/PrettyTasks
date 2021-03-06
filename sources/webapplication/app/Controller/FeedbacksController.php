<?php
App::uses('AppController', 'Controller');
App::uses('Feedback', 'Model');
App::uses('User', 'Model');
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
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
                    
                    $userInfo = $this->User->find('all', array(
                        'conditions' => array('User.id' => $this->Auth->user('id')),
                        'contain' => array('Account' => array('uid', 'master', 'provider', 'full_name', 'email')),
                        'fields' => array('id')
                    ));
                    App::uses('CakeEmail', 'Network/Email');
                    $email = new CakeEmail('feedback');
                    $str = $email->template('feedbackToSupport', 'default')
                        ->emailFormat(Configure::read('Email.global.format'))
                        ->from(array('feedback@prettytasks.com' => 'Feedback prettytasks'))
                        ->to(Configure::read('App.support.mail'))
                        ->subject('[support] [' .$feed['Feedback']['category'] .'] ' . $feed['Feedback']['subject'])
                        ->viewVars(array(
                            'userInfo' => $userInfo,
                            'feedback' => $feed['Feedback'],
                            'userAuth' => $this->Auth->user()
                            ))
                        ->send();    
                    
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
