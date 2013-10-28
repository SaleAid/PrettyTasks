<? 
if( strtolower($this->params['controller']) != "notes" ) {
    echo $this->Html->script('pos/'.Configure::read('Config.language').'/notes', array('block' => 'toFooter'));
    echo $this->Html->script('templates/note_create_form.'.Configure::read('App.version'), array('block' => 'toFooter'));
    echo $this->Html->script('notes_create.' . Configure::read('App.version'), array('block' => 'toFooter'));
}
?>
<a class="btn-note btn btn-info btn-small" href="#" rel="tooltip" title="<?php echo __d('tasks', 'Добавить заметку'); ?>">
    <i class="icon-edit"></i>
</a>

