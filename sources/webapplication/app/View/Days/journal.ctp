<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/journal.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead')); 
       echo $this->Html->css('journal.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('print.' . Configure::read('App.version'), null, array('block' => 'toHead'));
       
    }
     if( Configure::read('App.Minify.js') ){
        echo $this->Html->script('min/journal.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }else{
       echo $this->Html->script('main.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('journal.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('print.' . Configure::read('App.version'), array('block' => 'toFooter'));
       
    }
?>
<div class="row jl-wrap">
  <div >
    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
    <h3 class="head-list-info"><?php echo __d('days', 'Журнал'); ?></h3>
  </div>
    <div class="jl-content">
    <?php if( !empty($result['data']) ):?>
        <?php foreach($result['data'] as $day):?>
            <div class="jl-day">
                <span class="jl-title">
                    <?php 
                        echo $this->Html->link($day['Day']['date'] .' - '. __d('tasks', $this->Time->format('l', $day['Day']['date'])), array( 
                            'controller' => 'tasks',  
                            'action' => 'index',
                        	'#' => 'day-'.$day['Day']['date']
                        )); 
                    ?>
                    <?php if($day['Day']['rating']): ?>&nbsp;&nbsp;
                        <?php echo $this->Html->image("gday.". Configure::read('App.version') .".png", array('class' => 'g-day', 'width' => 16, 'height' => 16)); ?>
                    <?php endif; ?>
                </span>
                <p><?php echo h($day['Day']['comment']); ?></p>
            </div>
        <?php endforeach; ?>
     <?php else: ?>
         <?php echo $this->element('empty_lists', array('type' => 'journal', 'hide' => false));?>
     <?php endif ?>
    </div>
</div>
