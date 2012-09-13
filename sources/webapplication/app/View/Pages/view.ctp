<?php 
if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/pages.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('pages.'.Configure::read('App.version'), null, array('block' => 'toHead'));
    }
?>
<div id="page">
    <?php echo $content; ?>
</div>
