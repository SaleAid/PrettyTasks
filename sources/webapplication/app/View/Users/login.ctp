<?php echo $this->Html->script($this->Loginza->getJs(), array('block' => 'toFooter')); ?>
        <div class="login"> 
            <div class="span370">
                    <?php echo $this->Form->create('User',array('class' => 'well ',
                                    'inputDefaults' => array(
                                    'div' => array('class' => 'control-group'),
                                    'label' => array('class' => 'control-label'),
                                    'between' => '<div class="controls">',
                                    'after' => '</div>',
                                    'class' => '')
                                )); ?>
                    <fieldset>
                    <legend><?php echo __d('users', 'Войдите используя Ваш аккаунт'); ?></legend>
                        <?php echo $this->Form->input('email', array('label' => __d('users', 'Логин или Емейл'),'class' => 'input-xlarge', 'placeholder' => __d('users', 'Логин или Емейл'))); ?>
                
                        <?php echo $this->Form->input('password' ,array('label' => __d('users', 'Пароль'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Пароль'))); ?>
                        <?php echo $this->Form->submit(__d('users', 'Войти'), array('class' => 'btn btn-primary pull-left')); ?>
                         <label class="checkbox pull-left rememb">
                            <?php echo $this->Form->input('auto_login', array('label'=> __d('users', 'Оставаться в системе'), 'type'=>'checkbox')); ?>
                         </label>
                        
                        <div class="clearfix"></div>
                        
                        <?php echo $this->Html->link(__d('users', 'Забыли пароль?') , array('controller' => 'users', 'action' => 'password_resend')); ?>
                        &nbsp;&bull;&nbsp;
                        <?php echo $this->Html->link(__d('users', 'Регистрация'), array('controller' => 'users', 'action' => 'register')); ?>
                        
                        <?php echo $this->Form->end(); ?>
                    </fieldset>
                            
            </div>
            <div class="span370">
                 <div class="well">
                 <fieldset>
                 <legend><?php echo __d('users', 'Вы можете войти как'); ?></legend>
                    <?php echo $this->Loginza->iframeWidget(Configure::read('loginza.token_url'))?>

                 </fieldset>   
                 </div>   
            </div>
        </div>

           
            
                            
            
        
        

