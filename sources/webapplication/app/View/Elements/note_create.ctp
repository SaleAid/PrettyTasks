<? 
if( strtolower($this->params['controller']) != "notes" ) {
    //echo $this->Html->css('notes_create.'. Configure::read('App.version'), null, array('block' => 'toHead'));
    echo $this->Html->script('notes_create.' . Configure::read('App.version'), array('block' => 'toFooter'));
    $this->start('toFooter');
    echo $this->element('note_create_form', array(), array('cache' => array('key' => 'note_create_form', 'config' => 'elements')));
    $this->end();
    //echo 'active';
}
?>

<a class="btn-note btn btn-info btn-small" href="#" rel="tooltip" title="<?php echo __d('tasks', 'Добавить заметку'); ?>">
    <i class="icon-edit"></i>
</a>

