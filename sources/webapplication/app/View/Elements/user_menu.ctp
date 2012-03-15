<div class="span3">
  <div class="well sidebar-nav">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header"> Мой профиль </li>
      <li class="<? if($this->params['action'] == "profile") echo 'active'; ?>">
            <?php echo $this->Html->link(__('Управление профилем '). $this->Html->tag('i', '',array('class' => 'icon-chevron-right pull-right')), array('action' => 'profile'),array('escape' => false)); ?>
      </li>
      <li class="<? if($this->params['action'] == "password_change") echo 'active'; ?>">
            <?php echo $this->Html->link(__('Изменить пароль'). $this->Html->tag('i', '',array('class' => 'icon-chevron-right pull-right')), array('action' => 'password_change'),array('escape' => false)); ?>
      </li>
            <li class="<? if($this->params['action'] == "accounts") echo 'active'; ?>">
            <?php echo $this->Html->link(__('Связанные аккаунты'). $this->Html->tag('i', '',array('class' => 'icon-chevron-right pull-right')), array('action' => 'accounts'),array('escape' => false)); ?>
      </li>
      <li><a href="#">Link</a></li>
      
    </ul>
  </div>
</div>