<?php 

class DayObj {
    
    public $id = null;
    public $date = null;
    public $rating = null;
    public $comment = null;
    //public $created = null;
    //public $modified = null;

    public  function __construct( array $day ){
        $this->id = $day['id'];
        $this->date = $day['date'];
        $this->rating = $day['rating'];
        $this->comment = $day['comment'];
        //$this->created = $day['created'];
        //$this->modified = $day['modified'];
    }
} 