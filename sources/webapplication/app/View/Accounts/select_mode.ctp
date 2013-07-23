<?php echo $this->Html->script('jquery.cookie', array('block' => 'toFooter'));?>
<?php $this->Html->scriptBlock("
     function get_timezone_infos() {
        var now = new Date();
        var jan1 = new Date(now.getFullYear(), 0, 1, 0, 0, 0, 0);
        var temp = jan1.toGMTString();
        var jan2 = new Date(temp.substring(0, temp.lastIndexOf(' ') - 1));
        var offset = (jan1 - jan2) / (1000);
    
        var june1 = new Date(now.getFullYear(), 6, 1, 0, 0, 0, 0);
        temp = june1.toGMTString();
        var june2 = new Date(temp.substring(0, temp.lastIndexOf(' ') - 1));
        var dst = offset != ((june1 - june2) / (1000));
    
        return offset;
    }
      jQuery(function($){
        $.cookie('timezoneOffset', get_timezone_infos());
      });
  ", array('block' => 'toFooter'));
?>

<div class="login"> 
<?php echo $this->Session->flash(); ?>
    <fieldset>
            <legend><?php echo __d('accounts', 'Такой пользователь не найден в системе, что нужно сделать?'); ?></legend>
        <?php echo $this->Form->create('Account', array()); ?>
        <?php echo $this->Form->input('newAccount', array(
            'legend' => false,
            'type'=>'radio',
            'value' => 1,
            'before' => '',
            'after' => '',
            'between' => '',
            'separator' => ' ',
            'options' => array( 1 => __d('accounts', 'Я новый пользователь'), 0 => __d('accounts', 'Я имею аккаунт (связать аккаунты)'))
        )); ?>
        <br />
            <label class="checkbox1">
                <?php echo $this->Form->input('agreed', array('label'=> __d('accounts', 'Я согласен с ') . $this->Html->link(__d('accounts', 'условиями использования'), array('controller' => 'pages', 'action' => 'terms-and-conditions'), array('target' => '_blank')), 'type' => 'checkbox', 'format' => array('before', 'label', 'between', 'error', 'after'))); ?>
           </label>
        
        <?php echo $this->Form->submit(__d('accounts', 'Вперед'), array('class' => 'btn btn-primary pull-right', 'div' => false)); ?>
        <?php echo $this->Html->link('Отмена', array('controller' => 'accounts', 'action' => 'cancel'), array('class' => 'social-login-cancel')); ?>
        <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
