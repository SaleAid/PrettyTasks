<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/tasks.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead')); 
       //echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
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
                    <div class="input-append">
                        <input id="new-note" type="text" size="16" class="input-xxlarge new-note" placeholder="<?php echo __d('tasks', '+Add note…'); ?>"/><span class="add-on">?</span>
                    </div>
                    <button id="add-note" class="btn add-note"><?php echo __d('tasks', 'Добавить'); ?></button>    
                </div>
              </div>
              <div class="clear"></div>
                <ul id="notes" class="sortable connectedSortable ui-helper-reset">
                </ul>
    </div>
</div>
<!-- tmp -->
<script type="text/template" id="item-template" />
  <div class="view">
    <label> Note = <%= note %> || order = <%= order %></label>
    <a class="destroy"></a>
  </div>
  <input class="edit" type="text" value="<%= note %>" />
</script>
 