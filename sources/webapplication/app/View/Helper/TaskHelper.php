<?php
class TaskHelper extends AppHelper {

    public $separator = "' ";
    
    public $helpers = array('Time');
    
    public function taskLi($data){
        extract($data);
        $liClass = '';
        if ($time)
            $liClass .=' setTime';
        if ($done)
            $liClass .=' complete';    
        if ($priority)
            $liClass .=' important';
        $title = h($title);
        if (!empty($tags)){
            foreach( $tags as $tag ){
                if (!empty($tag)){
                    $tag = h($tag);
                    $title = str_replace('#'.$tag, '<span class="tags label label-important" data-tag="'.$tag.'">&#x23;'.$tag.'</span>', $title);
                }
            }
        }
        $pr_time = $time ? $this->Time->format('H:i', $time, true) : '';
        $pr_timeend = $timeend ? $this->Time->format('H:i', $timeend,true) : '';
        $pr_checked = $done ? ' checked' : '';
        $pr_comment_status = empty($comment) ? 'hide': '';
        
        $str = '<li id ="'.$id.'" class="'. $liClass .'" date="'.$date .'" data-continued="'.$continued.'">';
            $str .= '<span class="time">'. $pr_time .'</span>';
            $str .= '<span class="timeEnd">'. $pr_timeend .'</span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" ' .$pr_checked.'/>';
            $str .= '<span class="editable">'. $title .'</span>';
            $str .= '<span class="commentTask">'. $comment .'</span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file '. $pr_comment_status.'"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class=" icon-ban-circle"></i></span>';
        $str .= '</li>';

        return $str;
    }
    
    public function addTaskLi(){
        $str =' <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>">';
            $str .= '<span class="time"><%= time %></span>';
            $str .= '<span class="timeEnd"><%= timeend %></span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" <%= checked %>/>';
            $str .= '<span class="editable"><%= title %></span>';
            $str .= '<span class="commentTask"><%= comment %></span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file <%= comment_status %>"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class="icon-ban-circle"></i></span>';
        $str .= '</li>';
        
        return $str;
    }
    
    public function taskLiTag(){
        $str =' <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>">';
            $str .= '<span class="time"><%= time %></span>';
            $str .= '<span class="timeEnd"><%= timeend %></span>';
            $str .= '<span class="move"><i class="icon-move"></i></span>';
            $str .= '<input type="checkbox" class="done" value="1" <%= checked %>/>';
            $str .= '<span class="editable"><%= title %></span>';
            $str .= '<span class="tag-date badge badge-info" date="<%= date %>"><% if(date){%><%= date %><% } else { %>'. __d('tasks', 'Планируемые') .'<% } %></span>';
            $str .= '<span class="commentTask"><%= comment %></span>';
            $str .= '<span class="comment-task-icon"><i class="icon-file <%= comment_status %>"></i></span>';
            $str .= '<span class="editTask"><i class="icon-pencil"></i></span>';
            $str .= '<span class="deleteTask"><i class="icon-ban-circle"></i></span>';
        $str .= '</li>';
        
        return $str;
    }
    
}
