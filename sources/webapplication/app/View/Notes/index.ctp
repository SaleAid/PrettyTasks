<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/notes.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('notes.'. Configure::read('App.version'), null, array('block' => 'toHead'));
    }
    
    if( Configure::read('App.Minify.js') ){
        echo $this->Html->script('min/notes.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }else{
       echo $this->Html->script(array(
            'jquery.jgrowl.min',
            'jquery.inline-confirmation.'.Configure::read('App.version'),
       ), array('block' => 'toFooter'));
       echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter')); 
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
                    <textarea class="new-note" id="new-note" rows="5" placeholder="<?php echo __d('notes', '+Add note…'); ?>"></textarea>
                    <button id="add-note" class="btn add-note"><?php echo __d('notes', 'Добавить'); ?></button>    
                </div>
              </div>
              <div class="clear"></div>
               <ul id="notes" class="notes">
                   <?php foreach($result as $note):?> 
                        <li class="note-box" data-id="<?php echo h($note->id); ?>">
                            <div class="note">
                                <div class="title-note"><?php echo $this->Tag->wrap($note->title, $note->tags); ?> </div>
                            </div>
                            <div class="modified"><?php echo $this->Time->format('Y-m-d H:i:s', $note->modified, false, $timezone); ?></div>
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
        <div class="title-note" ><%= title %></div>
    </div>
    <div class="modified"><%= modified %></div>
    <ul class="buttons">
        <li><a class="note-view" href="#"><i class="icon-zoom-in "></i></a></li>
        <li><a class="note-edit" href="#"><i class="icon-edit"></i></a></li>
        <li><a class="note-remove" href="#"><i class="icon-trash"></i></a></li>
    </ul>
  </li>
</script>

<?php echo $this->element('note_create_form', array(), array('cache' => array('key' => 'note_create_form', 'config' => 'elements'))); ?>


 