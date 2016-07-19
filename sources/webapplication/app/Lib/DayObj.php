<?php 

class DayObj {
    
    public $id = null;
    public $date = null;
    public $rating = null;
    public $comment = null;

    public  function __construct( array $day ){
        $this->id = isset($day['id'])?$day['id']:null;
        $this->date = isset($day['date'])?$day['date']:null;
        $this->rating = isset($day['rating'])?$day['rating']:0;
        $this->comment = isset($day['comment'])?$day['comment']:null;
    }
} 