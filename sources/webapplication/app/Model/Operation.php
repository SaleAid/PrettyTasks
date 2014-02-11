<?php
App::uses('NoteObj', 'Lib');
App::uses('AppModel', 'Model');
/**
 * Operation Model
 *
 * @property User $User
 * @property Sync $Sync
 */
class Operation extends AppModel {

    public function getData($user_id, $sync_id = 0, $count = 100){
        
        $offset = 0*$count;
        $result = $this->query("
            SELECT Operation . * 
            FROM operations as Operation
                INNER JOIN (
                    SELECT obj_id, MAX( sync_id ) AS MaxSync_id
                    FROM operations
                    WHERE operations.user_id = '{$user_id}' and operations.sync_id > {$sync_id}
                    GROUP BY obj_id
                    )as groupedO ON Operation.obj_id = groupedO.obj_id
                AND Operation.sync_id = groupedO.MaxSync_id
            WHERE Operation.user_id = '{$user_id}' and Operation.sync_id > {$sync_id}
            ORDEr BY  Operation.sync_id ASC
            LIMIT {$offset},{$count}
        ");
        if(!$result){
            return array();
        }
        $deletedObjs = array_filter($result, function($operation){
            return $operation['Operation']['action'] == 'delete';
        });
        $lastEL = end($result);  
        $latestPartitionNum = $lastEL['Operation']['sync_id'];
        
        $notes = $this->query("
            SELECT operations . * , Note. * 
            FROM operations
            JOIN notes as Note ON operations.obj_id = Note.id 
            AND operations.model = 'notes'
            AND operations.sync_id = Note.sync_id 
            WHERE operations.sync_id <= {$latestPartitionNum} and operations.sync_id > {$sync_id} and operations.user_id = '{$user_id}'
        ");
        
        $dataNotes = array('updated' => array(), 'new' => array(), 'deleted' => array());
        if($deletedObjs){
            foreach ($deletedObjs as $obj) {
        	    $dataNotes['deleted'][] = array('id' => $obj['Operation']['obj_id']);
            }
        }

        if($notes){
            foreach ($notes as $note) {
        	    if($note['operations']['action'] == 'update')
                    $dataNotes['updated'][] = new NoteObj($note);
                if($note['operations']['action'] == 'insert')
                    $dataNotes['new'][] = new NoteObj($note);
            }
        }
        return array(
            "latestPartitionNum" => $latestPartitionNum,
            "data" => array(
                "Notes" => $dataNotes
            ) 
        );
    }
    
    private function getNotes(){
        
    }

}
