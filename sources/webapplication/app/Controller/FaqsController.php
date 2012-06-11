<?php
class FaqsController extends AppController {
    var $name = 'Faqs';
    var $helpers = array(
        'Html', 
        'Form'
    );
    var $uses = array(
        'Faq', 
        'Faqcategory'
    );
    var $cacheAction = array(
        'index' => 3600, 
        'view' => 3600
    );

    public function _getAllowedActions() {
        return array(
            'index', 
            'view', 
            'view_url'
        );
    }

    function beforeFilter() {
        $this->Auth->allow($this->_getAllowedActions());
        parent::beforeFilter();
    }

    function index() {
        $this->Faqcategory->contain('Faq');
        $options = array(
            'conditions' => array(
                'Faqcategory.active' => 1
            )
        );
        $faqcategories = $this->Faqcategory->find('all', $options);
        //debug($faqcategories);
        $this->set('faqcategories', $faqcategories);
    }

    function view($id = null) {
        if (! $id) {
            $this->Session->setFlash(__('Invalid Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->set('faq', $this->Faq->read(null, $id));
    }

    function view_url($url = null) {
        if (! $url) {
            $this->Session->setFlash(__('Invalid Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->set('faq', $this->Faq->find('first', array(
            'conditions' => array(
                'Faq.url' => $url
            )
        )));
        $this->render('view');
    }

    function add() {
        if (! empty($this->data)) {
            $this->Faq->create();
            if ($this->Faq->save($this->data)) {
                $this->Session->setFlash(__('The Faq has been saved', true));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
            }
        }
        $faqcategories = $this->Faq->Faqcategory->find('list');
        $users = $this->Faq->User->find('list');
        $this->set(compact('faqcategories', 'users'));
    }

    function edit($id = null) {
        if (! $id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (! empty($this->data)) {
            if ($this->Faq->save($this->data)) {
                $this->Session->setFlash(__('The Faq has been saved', true));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Faq->read(null, $id);
        }
        $faqcategories = $this->Faq->Faqcategory->find('list');
        $users = $this->Faq->User->find('list');
        $this->set(compact('faqcategories', 'users'));
    }

    function delete($id = null) {
        if (! $id) {
            $this->Session->setFlash(__('Invalid id for Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($this->Faq->del($id)) {
            $this->Session->setFlash(__('Faq deleted', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__('The Faq could not be deleted. Please, try again.', true));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    function admin_index() {
        $this->Faq->recursive = 0;
        $this->set('faqs', $this->paginate());
    }

    function admin_view($id = null) {
        if (! $id) {
            $this->Session->setFlash(__('Invalid Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->set('faq', $this->Faq->read(null, $id));
    }

    function admin_add() {
        if (! empty($this->data)) {
            $this->Faq->create();
            if ($this->Faq->save($this->data)) {
                $this->Session->setFlash(__('The Faq has been saved', true));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                debug($this->Faq->invalidFields());
                $this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
            }
        }
        $faqcategories = $this->Faq->Faqcategory->find('list');
        //$users = $this->Faq->User->find('list');
        $this->set(compact('faqcategories', 'users'));
    }

    function admin_edit($id = null) {
        if (! $id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (! empty($this->data)) {
            if ($this->Faq->save($this->data)) {
                $this->Session->setFlash(__('The Faq has been saved', true));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Faq->read(null, $id);
        }
        $faqcategories = $this->Faq->Faqcategory->find('list');
        //$users = $this->Faq->User->find('list');
        $this->set(compact('faqcategories', 'users'));
    }

    function admin_delete($id = null) {
        if (! $id) {
            $this->Session->setFlash(__('Invalid id for Faq', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($this->Faq->del($id)) {
            $this->Session->setFlash(__('Faq deleted', true));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__('The Faq could not be deleted. Please, try again.', true));
        $this->redirect(array(
            'action' => 'index'
        ));
    }
}
