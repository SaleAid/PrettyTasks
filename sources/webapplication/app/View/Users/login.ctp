<?php $this->start ( 'toHead' );?>
<?php echo $this->Html->css($this->Loginza->getCssUrl());?>
<?php $this->end ();?>
<?php $this->start ( 'toFooter' );?>
<?php echo $this->Html->script($this->Loginza->getJs()); ?>
<?php $this->end ();?>
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
                    <legend><?php echo __('Войдите используя Ваш аккаунт'); ?></legend>
                        <?php echo $this->Form->input('email',array('label'=>'Логин или Емейл:','class'=>'input-xlarge', 'placeholder'=>'Логин или емейл')); ?>
                
                        <?php echo $this->Form->input('password',array('label'=>'Пароль:','class'=>'input-xlarge', 'placeholder'=>'Пароль')); ?>
                        <?php echo $this->Form->submit(' Войти ',array('class'=>' btn btn-primary pull-left')); ?>
                         <label class="checkbox pull-left rememb">
                            <?php echo $this->Form->input('auto_login', array('label'=> __('Оставаться в системе'), 'type'=>'checkbox')); ?>
                         </label>
                        
                        <div class="clearfix"></div>
                        
                        <?php echo $this->Html->link(' Забыли пароль? ', array('controller' => 'users', 'action' => 'password_resend')); ?>
                        &nbsp;&bull;&nbsp;
                        <?php echo $this->Html->link(' Регистрация ', array('controller' => 'users', 'action' => 'register')); ?>
                        
                        <?php echo $this->Form->end(); ?>
                    </fieldset>
                            
            </div>
            <div class="span370">
                 <div class="well">
                 <fieldset>
                 <legend><?php echo __('Вы можете войти как'); ?></legend>
                    <?php echo $this->Loginza->iframeWidget(Configure::read('loginza.token_url'))?>

                 </fieldset>   
                 </div>   
            </div>
        </div>

           
            
                            
            
        
        

