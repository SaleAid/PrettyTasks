<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/tasks.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead')); 
       echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('print.' . Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->html->css('jquery.timepicker-1.2.2', null, array('block' => 'toHead'));
       echo $this->Html->css('notes.'. Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('ui-lightness/jquery-ui-1.8.18.custom', null, array('block' => 'toHead'));
    }
    
    if( Configure::read('App.Minify.js') ){
        echo $this->Html->script('min/tasks.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }else{
       echo $this->Html->script(array(
            'jquery.jgrowl.min',
            //'jquery.jeditable.mini',
            //'jquery.ba-hashchange.min',
            'jquery.timepicker-1.2.2.min',
            //'jquery.inline-confirmation.'.Configure::read('App.version'),
            'jquery-ui-i18n.min',
       ), array('block' => 'toFooter'));
       echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter')); 
       echo $this->Html->script('print.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('notes.' . Configure::read('App.version'), array('block' => 'toFooter'));
       
    }
?>

<div id="notes-list">
    <div class="row">
              <div class="listTask">
                <div class="margin-bottom10">
                   <h3 class="label label-info"><?php echo __d('notes', 'Notes'); ?></h3>
                </div>
                <div class="well form-inline">
                    <input id="new-note" type="text" size="16" class="input-xxlarge new-note" placeholder="<?php echo __d('tasks', '+Add note…'); ?>"/>
                    <button id="add-note" class="btn add-note"><?php echo __d('tasks', 'Добавить'); ?></button>    
                </div>
              </div>
              <div class="clear"></div>
                <div class="create-new-note">
                    <?php echo $this->Html->image("create-new-note-eng.". Configure::read('App.version') .".png", array("alt" => "", 'class' => '', 'width' => 180, 'height' => 178)); ?>
                </div>
                <ul id="notes" class="notes">
                
                </ul>
    </div>
</div>
<!-- tmp -->
<script type="text/template" id="item-template" />
  <div class="note-box">
  <a class="note-remove" href="#"><i class="icon-remove-sign"></i></a>
    <div class="note">
        <p><%= note %></p>
        <a class="destroy"></a>
    </div>
    <div class="modified label label-info"><%= modified %></div>
  </div>
</script>
<!-- modal -->
<script id="modal-edit-note" type="text/template">
    <div id="edit-note" class="modal">
        <div class="modal-header">
            <a class="close close-edit" data-dismiss="modal">×</a>
            <h3><?php echo __d('notes', 'Edit');?></h3>
        </div>
        <div class="modal-body">
            <textarea  class="text-note" id="text-note" rows="9"><%= note %></textarea>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn close-edit"><?php echo __d('tasks', 'Закрыть');?></a>
            <button id="save-note" class="btn btn-success"><?php echo __d('tasks', 'Сохранить');?></button>
        </div>
    </div>
    <div class="modal-backdrop"></div>
</script>
 