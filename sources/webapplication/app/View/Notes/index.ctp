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
       echo $this->Html->script('pos/'.Configure::read('Config.language').'/notes', array('block' => 'toFooter'));
       //echo $this->Html->script('pos/'.Configure::read('Config.language').'/messages', array('block' => 'toFooter'));
       echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('templates/note_preview.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('templates/note_create_form.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('notes.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }
?>

<div id="notes-list">
    <div class="row">
              <div class="listTask">
                <div>
                  <?php echo $this->Html->image("reload.". Configure::read('App.version') .".png", array("alt" => "Reload", 'class' => 'reload', 'width' => 19, 'height' => 19)); ?>
                  <h3 class="head-list-info"><?php echo __d('notes', 'Заметки'); ?></h3>
                </div>
                <div class="well form-inline">
                    <textarea class="new-note" id="new-note" rows="5" placeholder="<?php echo __d('notes', '+Добавить заметку'); ?>"></textarea>
                    <button id="add-note" class="btn add-note"><?php echo __d('notes', 'Добавить'); ?></button>    
                </div>
                <?php echo $this->element('empty_lists', array('type' => 'notes', 'hide' => count($result)));?>
              </div>
              <div class="clear"></div>
               <ul id="notes" class="notes">
                   <?php foreach($result as $note):?> 
                        <li class="note-box" data-id="<?php echo h($note->id); ?>">
                            <div class="note">
                                <div class="title-note"><?php echo $this->Text->autoLinkUrls($this->Tag->wrap($note->title, $note->tags), array('escape' => false)); ?> </div>
                            </div>
                            <div class="modified"><?php echo $this->Time->format('Y-m-d H:i', $note->modified, false, $timezone); ?></div>
                            <ul class="buttons">
                                <li><a class="note-fav <?= ($note->fav) ? 'fav-note' : '' ?>" href="#"><i class="icon-star"></i></a></li>
                                <li><a class="note-view" href="#"><i class="icon-zoom-in "></i></a></li>
                                <li><a class="note-edit" href="#"><i class="icon-edit"></i></a></li>
                                <li><a class="note-remove" href="#"><i class="icon-trash"></i></a></li>
                            </ul>
                        </li>
                   <?php endforeach;?>
                </ul>
                
                <div class="clear">
                </div>
                <?php if(count($result) == Configure::read('Notes.Lists.limit')): ?>
                <div class="see-more">
                    <button class="btn btn-large btn-block btn-see-more"><?php echo __d('notes', 'Далее...'); ?></button>
                </div>
                <?php endif; ?>
    </div>
</div>
