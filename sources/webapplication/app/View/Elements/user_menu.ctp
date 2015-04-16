<div class="span3">
  <div class="well sidebar-nav um">
    <ul class="nav nav-pills nav-stacked ">
      <li class="nav-header"><?php echo __d('users', 'Мой профиль');?></li>
      <li class="<?php if($this->params['action'] == "profile") echo 'active'; ?>">
            <?php echo $this->Html->link(__d('users', 'Управление профилем'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'users', 'action' => 'profile'), array('escape' => false)); ?>
      </li>
      <?php if($currentUser['provider'] == 'local'):?>
          <li class="<?php if($this->params['action'] == "password_change") echo 'active'; ?>">
                <?php echo $this->Html->link(__d('users', 'Изменить пароль'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'accounts', 'action' => 'password_change'), array('escape' => false)); ?>
          </li>
      <?php endif; ?>
      <li class="<?php if($this->params['action'] == "subscriptions") echo 'active'; ?>">
            <?php echo $this->Html->link(__d('users', 'Управление рассылками'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'users', 'action' => 'subscriptions'), array('escape' => false)); ?>
      </li>
      <li class="<?php if($this->params['action'] == "accounts") echo 'active'; ?>">
            <?php echo $this->Html->link(__d('users', 'Связанные аккаунты'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'users', 'action' => 'accounts'), array('escape' => false)); ?>
      </li>
      <li class="nav-header"><?php echo __d('users', 'Дополнительно');?></li>
      </li>
            <li class="<?php if($this->params['action'] == "add" and $this->params['controller'] == "invitations") echo 'active'; ?>">
            <?php echo $this->Html->link(__d('users', 'Пригласить друзей'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'invitations', 'action' => 'add'), array('escape' => false)); ?>
      </li>
      </li>
            <li class="<?php if($this->params['action'] == "add" and $this->params['controller'] == "feedbacks") echo 'active'; ?>">
            <?php echo $this->Html->link(__d('users', 'Обратная связь'). $this->Html->tag('i', '', array('class' => 'icon-chevron-right pull-right')), array('controller' => 'feedbacks', 'action' => 'add'), array('escape' => false)); ?>
      </li>
      <li class="nav-header"></li>
      <li><?php echo $this->Html->link(__d('accounts', 'Выход'), array('controller' => 'accounts', 'action' => 'logout'));?></li>
    </ul>
  </div>
</div>