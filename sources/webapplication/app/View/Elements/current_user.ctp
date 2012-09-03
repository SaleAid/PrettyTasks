<div class="pull-right">
    <?php echo $this->Html->image("ajax-loader.". Configure::read('App.version') .".gif", array("alt" => "Print", 'class' => 'pull-left ajaxLoader hide', 'width' => 24, 'height' => 24)); ?>
    
    <div class="pull-right">
     <?php if(!empty($currentUser)): ?>
     <div class="btn-group">
     <?php echo $this->Html->link($this->Html->tag('i', '',
                 array('class' => 'icon-user icon-white')). '  ' . ' '
                        .$this->Text->truncate($currentUser['first_name'], 15 , array('ending' => '...', 'exact' => true)). ' '
                        .$this->Text->truncate($currentUser['last_name'], 15 , array('ending' => '...', 'exact' => true)). ' '
                        .$this->Loginza->ico($provider),
                 array('controller' => 'users', 'action' => 'profile'),array('escape' => false, 'class'=> 'btn btn-primary'));?>
      
      <a class="btn btn-primary dropdown-toggle " data-toggle="dropdown" href="#"><span class="caret"></span></a>
      
      <ul class="dropdown-menu">
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-edit')) . '&nbsp&nbsp' . __d('users', 'Учётная запись'), array('controller' => 'users', 'action' => 'profile'), array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pencil')) . '&nbsp&nbsp' . __d('users', 'Изменить пароль'), array('controller' => 'users', 'action' => 'password_change'), array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-magnet')) . '&nbsp&nbsp' . __d('users', 'Связанные аккаунты'), array('controller' => 'users', 'action' => 'accounts'), array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-plane')) . '&nbsp&nbsp' . __d('users', 'Пригласить друзей'), array('controller' => 'invitations', 'action' => 'add') ,array('escape' => false));?></li>
        <li class="dropdown-submenu">
            <a tabindex="-1" href="#"><i class="icon-flag"></i>&nbsp&nbsp<?php echo __d('users', 'Language'); ?></a>
            <ul class="dropdown-menu langList">
                <li ><a tabindex="-1" href="#" data="ru"><?php echo __d('users', 'russian'); ?>&nbsp&nbsp<?php if(Configure::read('Config.language') == 'rus') : ;?><i class="icon-ok"></i><?php endif;?></a></li>
                <li class="divider"></li>
                <li ><a tabindex="-1" href="#" data="en"><?php echo __d('users', 'english'); ?>&nbsp&nbsp<?php if(Configure::read('Config.language') == 'eng') : ;?><i class="icon-ok"></i><?php endif;?></a></li>
           </ul>
               
        </li>
        <li class="divider"></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-off')) . '&nbsp&nbsp' . __d('users', 'Выход'), array('controller' => 'users', 'action' => 'logout'), array('escape' => false));?></li>
      </ul>
      </div>
    <?php endif; ?>
    
    </div>
</div>
