<?php

class PrettyTasksShell extends AppShell {
    
    public $tasks = array('TodayDigest');
    
    public function main(){
        $this->hr(3);
        $this->TodayDigest->execute();
        $this->hr(3);
    }
    
    public function test() {
        $this->out('Hey there ' . $this->args[0]);
    }
}