<?php
if( Configure::read('App.Minify.css') ){
    echo $this->Html->css('min/notes.' . Configure::read('App.version'), null, array('block' => 'toHead'));
}else{
    echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
    echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    echo $this->Html->css('notes.'. Configure::read('App.version'), null, array('block' => 'toHead'));
    echo $this->Html->css('pinaric.'. Configure::read('App.version'), null, array('block' => 'toHead'));
}

    echo $this->Html->script(array(
        'jquery.jgrowl.min',
        'jquery.inline-confirmation.'.Configure::read('App.version'),
    ), array('block' => 'toFooter'));
    echo $this->Html->script('pos/'.Configure::read('Config.language').'/notes', array('block' => 'toFooter'));
    //echo $this->Html->script('pos/'.Configure::read('Config.language').'/messages', array('block' => 'toFooter'));
    echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter'));
    echo $this->Html->script('templates/note_preview.'.Configure::read('App.version'), array('block' => 'toFooter'));
    echo $this->Html->script('templates/note_create_form.'.Configure::read('App.version'), array('block' => 'toFooter'));
?>

<div class="row col-lg-12 col-md-12 col-xs-12">
    
    <div class="content-pinaric">
        <?= $this->Pinaric->renderYear(2016, $days, Configure::read('User.Normal.FirstDayOfWeek')) ?>
    </div>
</div>