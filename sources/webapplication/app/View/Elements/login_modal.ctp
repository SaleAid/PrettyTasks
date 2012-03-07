<?php 
   $param = array(
                'token_url'=>'https://loginza.ru/api/widget?token_url=',
                'widget_url'=>'http://loginza.ru/js/widget.js',
                'return_url'=>'http://learning-2012.org.ua/users/loginzalogin',
                   
            ); 
   echo $this->Html->script($param['widget_url'],true);
   echo $this->Html->css('loginza',FALSE);
   
?>
<div class="modal hide fade in" id="login1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Log in</h3>
    </div>
    <div class="modal-body">
            <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#1" data-toggle="tab"> Standard </a></li>
            <li><a href="#2" data-toggle="tab"> Loginza </a></li>
            <li><a href="#3" data-toggle="tab"> Registration </a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="1">
            <div id="error_login"></div>
                <?php

                    echo $this->Form->create('User',array('controller'=>'users','action'=>'login'));

                    echo $this->Form->input('username',array('class'=>'input', 'placeholder'=>'login'));

                    echo $this->Form->input('password',array('class'=>'input', 'placeholder'=>'password'));
                    
                    echo $this->Js->submit('login',array(
                            'url' => array('controller' => 'users','action' => 'login'),
                            'before' => $this->Js->get('#sending')->effect('fadeIn'),
                            'success' => $this->Js->get('#sending')->effect('fadeOut'),
                            'update' => '#error_login'));
                ?>
                
                <?php echo $this->Form->end();?>
            </div>
            <div class="tab-pane " id="2">
                <fieldset>
                <legend>Войти как пользователь:</legend>
                <?php
                    echo $this->Html->link(__(''),$param['token_url'].$param['return_url'].'&provider=twitter&providers_set=vkontakte,facebook,twitter,google', array('class' => 'loginza twitter_button'));
                    echo $this->Html->link(__(''),$param['token_url'].$param['return_url'].'&provider=vkontakte&providers_set=vkontakte,facebook,twitter,google', array('class' => 'loginza vkontakte_button'));
                    echo $this->Html->link(__(''),$param['token_url'].$param['return_url'].'&provider=facebook&providers_set=vkontakte,facebook,twitter,google', array('class' => 'loginza facebook_button'));
                    echo $this->Html->link(__(''),$param['token_url'].$param['return_url'].'&provider=google&providers_set=vkontakte,facebook,twitter,google', array('class' => 'loginza google_button'));
                ?> 
                </fieldset>
            </div>   
            <div class="tab-pane " id="3">
                    <h3><?php echo __('Registration'); ?></h3>
                    <ul>
                            <li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'registration')); ?> </li>
                    </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
       <div id="sending" class="hide"> <i class="icon-ok"></i></div>
    </div>
</div>   