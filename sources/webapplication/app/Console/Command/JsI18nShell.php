<?php

class JsI18nShell extends AppShell {
    
    public $tasks = array('JsI18n');
    
    public function main(){
        $this->hr(1);
        $this->JsI18n->execute();
        $this->hr(1);
    }
    
    /**
     * Get and configure the Option parser
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser() {
    	$parser = parent::getOptionParser();
    	return $parser->description(
    			__d('cake_console', 'I18n Shell generates .pot files(s) with js translations.')
    	);
    }
    

}