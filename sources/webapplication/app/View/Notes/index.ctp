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
            'jquery.timepicker-1.2.2.min',
            'jquery-ui-i18n.min',
            'jquery.inline-confirmation.'.Configure::read('App.version'),
       ), array('block' => 'toFooter'));
       echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter')); 
       echo $this->Html->script('print.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('notes.' . Configure::read('App.version'), array('block' => 'toFooter'));
       
    }
?>

<div id="notes-list">
    <div class="row">
              <div class="listTask">
                <div >
                <h3 class="head-list-info"><?php echo __d('notes', 'Заметки'); ?></h3>
              </div>
                <div class="well form-inline">
                    
                    <?php //echo $this->Html->image("add-note-icon.". Configure::read('App.version') .".png", array("alt" => "", 'class' => 'img-rounded create-new-note')); ?>
                    
                    <textarea class="new-note" id="new-note" rows="5" placeholder="<?php echo __d('notes', '+Add note…'); ?>"></textarea>
                    <button id="add-note" class="btn add-note"><?php echo __d('notes', 'Добавить'); ?></button>    
                </div>
              </div>
              <div class="clear"></div>
               <!-- <div class="create-new-note">
                    <?php //echo $this->Html->image("create-new-note-eng.". Configure::read('App.version') .".png", array("alt" => "", 'class' => '', 'width' => 180, 'height' => 178)); ?>
                </div>-->
                <ul id="notes" class="notes">
                   <?php foreach($result as $note):?> 
                        <li class="note-box" data-id="<?php echo h($note->id); ?>">
                            
                            <div class="note">
                                <textarea readonly><?php echo h($note->title); ?> </textarea>
                            </div>
                            <div class="modified"><?php echo h($note->modified); ?></div>
                            <ul class="buttons">
                                <li><a class="note-view" href="#"><i class="icon-zoom-in "></i></a></li>
                                <li><a class="note-edit" href="#"><i class="icon-edit"></i></a></li>
                                <li><a class="note-remove" href="#"><i class="icon-trash"></i></a></li>
                            </ul>
                        </li>
                   <?php endforeach;?>
                </ul>
    </div>
</div>
<!-- tmp -->
<script type="text/template" id="note-template" />
  <li class="note-box" data-id="<%= id %>">
    <div class="note">
        <textarea readonly><%= title %></textarea>
    </div>
    <div class="modified"><%= modified %></div>
    <ul class="buttons">
        <li><a class="note-edit" href="#"><i class="icon-zoom-in "></i></a></li>
        <li><a class="note-edit" href="#"><i class="icon-edit"></i></a></li>
        <li><a class="note-remove" href="#"><i class="icon-trash"></i></a></li>
    </ul>
  </li>
</script>

<?php echo $this->element('note_create_form', array(), array('cache' => array('key' => 'note_create_form', 'config' => 'elements'))); ?>


 