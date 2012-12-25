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
} 