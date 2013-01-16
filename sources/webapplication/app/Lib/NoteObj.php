<?php 

class NoteObj {
    
    public $id = null;
    public $title = null;
    public $modified = null;
    
    public  function __construct( array $note ){
        $this->id = $note['Note']['id'];
        $this->title = $note['Note']['note'];
        $this->modified = $note['Note']['modified'];
    }
    
    public function makeLinks() {
      return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $this->title);
    }
} 