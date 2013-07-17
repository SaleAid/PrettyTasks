<?php
class TaskHelper extends AppHelper {

    public $separator = "' ";
    
    public $helpers = array('Time', 'Tag');
    
    public function taskLi($data){
        //extract($data);
        $liClass = '';
        $repeated = 0;
        if ($data->time)
            $liClass .=' setTime';
        if ($data->done)
            $liClass .=' complete';    
        if ($data->priority)
            $liClass .=' important';
        if ($data->repeatid)
            $repeated = 1;
        $title = $data->title;
        if (!empty($data->tags)){
            $title = $this->Tag->wrap($data->title, $data->tags);
        }
        $pr_time = $data->time ? $this->Time->format('H:i', $data->time, true) : '';
        $pr_timeend = $data->timeend ? $this->Time->format('H:i', $data->timeend, true) : '';
        $pr_checked = $data->done ? ' checked' : '';
        $pr_comment_status = empty($data->comment) ? 'hide': '';
        
        $str = '<li id ="'.$data->id.'" class="'. $liClass .'" date="'.$data->date .'" data-continued="'.$data->continued.'" data-repeated="'.$repeated.'">';
            $str .= '<span class="time">'. $pr_time .'</span>';
            $str .= '<span class="timeEnd">'. $pr_timeend .'</span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" ' .$pr_checked.'/>';
            $str .= '<span class="editable">'. $title .'</span>';
            $str .= '<span class="commentTask">'. $data->comment .'</span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file '. $pr_comment_status.'"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class=" icon-trash"></i></span>';
        $str .= '</li>';

        return $str;
    }
    
    public function addTaskLi(){
        $str =' <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>" data-repeated="<%= repeated %>" >';
            $str .= '<span class="time"><%= time %></span>';
            $str .= '<span class="timeEnd"><%= timeend %></span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" <%= checked %>/>';
            $str .= '<span class="editable"><%= title %></span>';
            $str .= '<span class="commentTask"><%= comment %></span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file <%= comment_status %>"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class=" icon-trash"></i></span>';
        $str .= '</li>';
        
        return $str;
    }
    
    public function taskLiTag(){
        $str =' <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>" data-repeated="<%= repeated %>" >';
            $str .= '<span class="time"><%= time %></span>';
            $str .= '<span class="timeEnd"><%= timeend %></span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" <%= checked %>/>';
            $str .= '<span class="editable"><%= title %></span>';
            $str .= '<span class="tag-date badge badge-info" date="<%= date %>"><% if(date){%><%= date %><% } else { %>'. __d('tasks', 'Планируемые') .'<% } %></span>';
            $str .= '<span class="commentTask"><%= comment %></span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file <%= comment_status %>"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class=" icon-trash"></i></span>';
        $str .= '</li>';
        
        return $str;
    }
    
}
