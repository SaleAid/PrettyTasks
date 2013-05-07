<?php 

class DayObj {
    
    public $id = null;
    public $date = null;
    public $rating = null;
    public $comment = null;
    public $created = null;
    public $modified = null;

    public  function __construct( array $day ){
        $this->id = $day['Day']['id'];
        $this->date = $day['Day']['date'];
        $this->rating = $day['Day']['rating'];
        $this->comment = $day['Day']['comment'];
        $this->created = $day['Day']['created'];
        $this->modified = $day['Day']['modified'];
    }
} 