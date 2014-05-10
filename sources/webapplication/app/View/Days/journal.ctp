<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/journal.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead')); 
       echo $this->Html->css('journal.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('print.' . Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
    }
     if( Configure::read('App.Minify.js') ){
        echo $this->Html->script('min/journal.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }else{
       echo $this->Html->script('main.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('journal.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('print.' . Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('jquery.jgrowl.min.' . Configure::read('App.version'), array('block' => 'toFooter'));
       
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
                        <?php echo $this->Html->image("gday.". Configure::read('App.version') .".png", array('title' => __d('users', 'Good day'), 'class' => 'g-day', 'width' => 20, 'height' => 20)); ?>
                    <?php endif; ?>
                </span>
                <p><?php echo h($day['Day']['comment']); ?></p>
            </div>
        <?php endforeach; ?>
        
        <?php
$params = $this->Paginator->params();
if ($params['pageCount'] > 1) {
?>
<div class="pagination pagination-centered">
 <ul>
<?php
    echo $this->Paginator->prev('&larr; '.__d('users','Previous'), array(
        'class' => 'prev',
        'tag' => 'li',
         'escape' => false
    ), '<a onclick="return false;">&larr; ' .__d('users','Previous'). '</a>', array(
        'class' => 'prev disabled',
        'tag' => 'li',
        'escape' => false
    ));

    echo $this->Paginator->numbers(array(
        'first' => 3,
        'last' => 3,
        'modulus' => 4,
        'ellipsis' => '<li><span class="active">...</span></li>',
        'separator' => '',
        'tag' => 'li',
        'currentClass' => 'active',
        'currentTag' => 'a'
    ));
    echo $this->Paginator->next(__d('users','Next'). ' &rarr;', array(
        'class' => 'next',
        'tag' => 'li',
        'escape' => false
    ), '<a onclick="return false;">' .__d('users', 'Next'). ' &rarr;</a>', array(
        'class' => 'next disabled',
        'tag' => 'li',
        'escape' => false
    )); ?>
 </ul>
</div>
<?php } ?>

     <?php else: ?>
         <?php echo $this->element('empty_lists', array('type' => 'journal', 'hide' => false));?>
     <?php endif ?>
    </div>
</div>
