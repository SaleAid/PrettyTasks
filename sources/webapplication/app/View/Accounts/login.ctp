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
        $.cookie('timezoneOffset', get_timezone_infos(), { path: '/' });
      });
  ", array('block' => 'toFooter'));
?>

<div class="login"> 
<?php echo $this->Session->flash(); ?>
           <?php echo $this->Form->create('Account',array('class' => 'form-horizontal',
                            'inputDefaults' => array(
                            'div' => array('class' => 'control-group'),
                            'label' => array('class' => 'control-label'),
                            'between' => '<div class="controls">',
                            'after' => '</div>',
                            'class' => '')
                        )); ?>
            <fieldset>
            <legend><?php echo __d('accounts', 'Вход'); ?></legend>
                <?php echo $this->Form->input('email', array('label' => array('text' => __d('accounts', 'Логин или Емейл'), 'class' => 'control-label'),'class' => 'input-xlarge', 'placeholder' => __d('users', 'Логин или Емейл'), 'type' => 'text')); ?>
        
                <?php echo $this->Form->input('password' ,array( 'label' => array('text' => __d('accounts', 'Пароль'), 'class' => 'control-label'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Пароль'))); ?>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $this->Form->input('auto_login', array('label' => false, 'type'=>'checkbox', 'div' => false)); ?>
                             <?php echo __d('accounts', 'Оставаться в системе'); ?>
                         </label>
                     </div>
                  </div>     
                 <div class="form-inline form-login">
                 <div class="control-group">
                    <div class="controls">
                      
                      
                      <?php echo $this->Form->submit(__d('accounts', 'Войти'), array('class' => 'btn btn-primary', 'div' => false)); ?>
                    </div>
                  </div>
                </div>
                
                <div class="reg-link">
                    <?php echo $this->Html->link(__d('accounts', 'Регистрация'), array('controller' => 'accounts', 'action' => 'register')); ?>
                    &nbsp;&bull;&nbsp;
                    <?php echo $this->Html->link(__d('accounts', 'Забыли пароль?') , array('controller' => 'accounts', 'action' => 'password_resend')); ?>
                </div>
                
                <?php echo $this->Form->end(); ?>
            </fieldset>
    
    <div class="social-bnts">
        <span class="social-or"><?php echo __d('accounts', 'ИЛИ'); ?></span>
        <ul>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('google'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'google'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('facebook'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'facebook'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('linkedin'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'linkedin'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
            <li><?php echo $this->Form->postLink($this->Loginza->logo('twitter'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'twitter'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('vkontakte'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'vkontakte'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        </ul>
    </div>
</div>
