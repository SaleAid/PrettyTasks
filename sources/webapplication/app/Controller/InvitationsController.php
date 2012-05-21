<?php
App::uses('AppController', 'Controller');
/**
 * Invitations Controller
 *
 * @property Invitation $Invitation
 */
class InvitationsController extends AppController {
    public $layout = 'profile';
    public $components = array(
        'Recaptcha.Recaptcha' => array(
            'actions' => array(
                'add'
            )
        )
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
            $emails = extract_email_address($string);
            if (!$this->Invitation->recaptcha) return;
            if (! empty($emails)) {
                App::uses('CakeEmail', 'Network/Email');
                foreach ( $emails as $address ) {
                    $email = new CakeEmail();
                    $email->template('users_invitation', 'default');
                    $email->emailFormat(Configure::read('Email.global.format'));
                    $email->from(Configure::read('Email.global.from'));
                    $email->to($address);
                    $email->subject(Configure::read('Email.user.invitation.subject'));
                    $email->viewVars(array(
                        'user' => $this->Auth->user()
                    ));
                    $email->send();
                }
                foreach ( $emails as $email ) {
                    $this->Invitation->create();
                    $this->Invitation->save(array(
                        'email' => $email, 
                        'user_id' => $this->Auth->user('id')
                    ));
                }
                $this->Session->setFlash(__('Приглашения разосланы'), 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect(array(
                    'action' => 'add'
                ));
            } else {
                $this->Invitation->invalidate('emails', __('Введите минимум один емейл'));
                $this->Session->setFlash(__('Ошибка при вводе данных, поробуйте ввести еще раз'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }
}

//TODO move to vendors
function extract_email_address($string) {
    $emails = array();
    foreach ( preg_split('/ /', $string) as $token ) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
            $emails[] = $email;
        }
    }
    return $emails;
}
