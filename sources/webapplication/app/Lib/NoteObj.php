<?php 

class NoteObj {
    
    public $id = NULL;
    public $title = NULL;
    public $tags = NULL;
    public $modified = NULL;
    
    public  function __construct( array $note ){
        $this->id = $note['Note']['id'];
        $this->title = $note['Note']['title'];
        $this->tags = isset($note['Note']['tags']) ? $note['Note']['tags']: null;
        $this->modified = $note['Note']['modified'];
    }
} 