<?php
App::uses('CakeTime', 'Utility');
App::uses('ApiV2AppController', 'ApiV2.Controller');
App::uses('NoteObj', 'Lib');
App::uses('MessageObj', 'Lib');
/**
 * Notes Controller
 *
 * @property 
 */
class SyncsController extends ApiV2AppController {

    public $uses = array('Sync', 'Operation', 'Note');
    
    public function status(){
        if ( !$this->request->is('get') ) {
            $result['errors'][] = array(
                'message' => __d('api', 'Ошибка при передаче данных')
            );
        }else {
        	    $result['latestServerSync'] = (int)$this->Sync->status($this->OAuth->user('id'));
        }
    	$this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function getChanges(){
        if ( !$this->request->is('get') ) {
            $result['errors'][] = array(
                'message' => __d('api', 'Ошибка при передаче данных')
            );
        }else {
        	    
            $count = !isset($this->request->query['maxCount']) ? 100 : (int)$this->request->query['maxCount'];
            if ( $count > 100 ) 
                $count = 100;
            
            $sync_id = !empty($this->request->query['latestClientNum']) ? (int)$this->request->query['latestClientNum'] : 0;
            $result = $this->Operation->getData($this->OAuth->user('id'), $sync_id, $count);
            $result['latestServerSync'] = (int)$this->Sync->status($this->OAuth->user('id'));
                
        }
        
    	$this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function update(){
        if ( !$this->request->is('post')) {
            $result['errors'][] = array(
                'message' => __d('api', 'Ошибка при передаче данных')
            );
        }else {
            $data = $this->request->input('json_decode');
            
            //update Notes
            if(isset($data->data->Notes)){
                $notes = $data->data->Notes;
                $news = !empty($notes->new) ? $notes->new : array();
                $updateds = !empty($notes->updated) ? $notes->updated : array();
                $deleteds = !empty($notes->deleted) ? $notes->deleted : array();
                $user_id = $this->OAuth->user('id');
                foreach ($news as $new) {
                    $this->Note->create();
                    $note = $this->Note->createNote($user_id, $new->title)->save();
                    $res = array();
                    $res['oldId'] = $new->id;
                    if($note){
                        $res['status'] = 1;
                        $res['id'] = $note['Note']['id'];
                    }else{
                        $res['status'] = 0;    
                        $res['errors'] = new MessageObj('error', __d('notes', 'Заметка не создана'), $this->Note->validationErrors);
                    }
                    $result['data']['Notes']['new'][] = $res;
                }
                foreach ($updateds as $updated) {
                    $res = array();
                    $res['status'] = 0;
                    $originNote = $this->Note->isOwner($updated->id, $user_id);
                    if ($originNote) {
                      $note = $this->Note->update($updated->title)->save();
                      if ( $note ) {
                            $res['status'] = 1;
                      } else {
                            $res['errors'] = new MessageObj('error', __d('notes', 'Заметка не обновлена'), $this->Note->validationErrors);
                      }
                    } else {
                        $res['errors'] = new MessageObj('error', __d('notes', 'Ошибка, Вы не можете делать изменения в этой заметке'));
                    }
                    $result['data']['Notes']['updated'][] = $res;
                }
                foreach ($deleteds as $deleted) {
                    $note = $this->Note->isOwner($deleted->id, $user_id);
                    $res = array();
                    $res['status'] = 0;
                    if ($note) {
                            if ($this->Note->delete()) {
                                $res['status'] = 1;
                            } else {
                                $res['errors'] = new MessageObj('error', __d('notes', 'Ошибка, заметка не удалена'));
                            }             
                    } else {
                        $res['errors'] = new MessageObj('error', __d('notes', 'Ошибка, Вы не можете делать изменения в этой заметке'));
                    }
                    $result['data']['Notes']['deleted'][] = $res;
                }
            }
        }

        //pr($data->data->Notes);die;    
            
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    

    
}
