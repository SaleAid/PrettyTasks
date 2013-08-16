<?php 

class NoteObj {
    
    public $id = NULL;
    public $title = NULL;
    public $tags = NULL;
    public $modified = NULL;
    public $created = null;
    
    public  function __construct( array $note ){
        $this->id = $note['Note']['id'];
        if(isset($note['Note']['title'])){
            $this->title = $note['Note']['title'];
        }elseif(isset($note['Note']['title_excerpt'])){
            $this->title = $note['Note']['title_excerpt'];
        }else{
            $this->title = '';
        }
        $this->tags = isset($note['Note']['tags']) ? $note['Note']['tags'] : null;
        $this->modified = $note['Note']['modified'];
        $this->created = $note['Note']['created'];
    }
} 