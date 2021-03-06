<?php
App::uses('AppController', 'Controller');
/**
 * Invitations Controller
 *
 * @property Invitation $Invitation
 */
class InvitationsController extends AppController {
    public $layout = 'profile';
    public $uses = array(
        'Invitation', 
        'User'
    );
    public $components = array(
        'Captcha'
        
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $string = $this->request->data['Invitation']['emails'];
            $emails = $this->_extract_email_addresses($string);
            if ( empty($emails)) {
                $this->Invitation->invalidate('emails', __d('invitations', 'Введите минимум один емейл'));
            }
            
            if (! $this->Captcha->validateCaptcha() || empty($emails) ) {
            //if (! $this->Invitation->recaptcha or empty($emails) ) {
                $this->Session->setFlash(__d('invitations', 'Ошибка при вводе данных, попробуйте ввести еще раз'), 'alert', array(
                    'class' => 'alert-error'
                ));
                return;
            }
            if (! empty($emails)) {
                //Firstly save it to DB
                foreach ( $emails as $email ) {
                    $this->Invitation->create();
                    $this->Invitation->save(array(
                        'email' => $email, 
                        'user_id' => $this->Auth->user('id')
                    ));
                }
                //Find emails of existing users
                //$this->User->contain();
//                $already_users_emails = $this->User->find('list', 
//                                                        array(
//                                                            'conditions' => array(
//                                                                'User.email' => $emails
//                                                            ), 
//                                                            'fields' => array(
//                                                                'id', 
//                                                                'email'
//                                                            )
//                                                        ));
                //$emails2send = array_diff($emails, $already_users_emails);
                $emails2send = $emails;
                //Send emails only non-registered users 
                App::uses('CakeEmail', 'Network/Email');
                foreach ( $emails2send as $address ) {
                    $email = new CakeEmail('invitation');
                    $email->template(Configure::read('Config.language') . DS . 'users_invitation', 'default');
                    $email->emailFormat(Configure::read('Email.global.format'));
                    $email->from(Configure::read('Email.global.from'));
                    $email->to($address);
                    $email->subject(__d('mail', Configure::read('Email.user.invitation.subject'), Configure::read('Site.name')));
                    $email->viewVars(array(
                        'user' => $this->Auth->user()
                    ));
                    $email->send();
                }
                $this->Session->setFlash(__d('invitations', 'Приглашения разосланы'), 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect(array(
                    'action' => 'add'
                ));
            } else {
                $this->Invitation->invalidate('emails', __d('invitations', 'Введите минимум один емейл'));
                $this->Session->setFlash(__d('invitations', 'Ошибка при вводе данных, попробуйте ввести еще раз'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }

    protected function _extract_email_addresses($string) {
        $emails = array();
        foreach ( preg_split('/[\s,;:]+/', $string) as $token ) {
            $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if ($email !== false) {
                $emails[] = $email;
            }
        }
        $emails = array_unique($emails);
        return $emails;
    }
}


