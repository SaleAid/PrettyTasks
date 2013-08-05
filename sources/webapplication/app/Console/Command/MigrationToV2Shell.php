<?php

class MigrationToV2Shell extends AppShell {
    
    public $tasks = array('MigrationUsers', 'MigrationTasks');
    
    public function main(){
        $prompt = __d('cake_console', "Migration to v2.\n [1]Local user \n [2]tasks\n [Q]uit\nWould you like to do?");
		$result = strtolower($this->in($prompt, array('1', '2', 'q'), 'q'));
		$this->hr(1);
        if ($result === 'q') {
			return $this->_stop();
		}
		if ($result === '1') {
			return $this->migrationUsers();
		}
        if($result === '2'){
		  return $this->migrationTasks();
		}
        
        $this->hr(3);
        //$this->TodayDigest->execute();
        //$this->hr(3);
    }
    
    public function migrationUsers() {
        $this->MigrationUsers->execute();
        $this->out('user done ');
    }
    
    public function migrationTasks(){
        $this->MigrationTasks->execute();
        $this->out('tasks done ');
    }
}