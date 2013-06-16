
<div class="pull-right">
    
     
    <ul class="pull-right user-menu-ul">
        <?php echo $this->Html->image("ajax-loader.". Configure::read('App.version') .".gif", array("alt" => "Print", 'class' => 'ajaxLoader hide', 'width' => 24, 'height' => 24)); ?>
        <?php echo $this->element('note_create'); ?>
       
     <?php if(!empty($currentUser)): ?>
     <li class="btn-group">
     <?php echo $this->Html->link($this->Html->tag('i', '',
                 array('class' => 'icon-user icon-white')). '  ' . ' '
                        .$this->Text->truncate($currentUser['full_name'], 15 , array('ending' => '...', 'exact' => true)). ' '
                        .$this->Loginza->ico($currentUser['provider']),
                 array('controller' => 'users', 'action' => 'profile'),array('escape' => false, 'class'=> 'btn btn-primary'));?>
      
          <a class="btn btn-primary dropdown-toggle " data-toggle="dropdown" href="#">
            <b class="caret"></b>
          </a >
          <ul class="dropdown-menu pull-right user-menu">
                <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-edit')) . '&nbsp;&nbsp;' . __d('accounts', 'Учётная запись'), array('controller' => 'users', 'action' => 'profile'), array('escape' => false));?></li>
                <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pencil')) . '&nbsp;&nbsp;' . __d('accounts', 'Изменить пароль'), array('controller' => 'users', 'action' => 'password_change'), array('escape' => false));?></li>
                <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-magnet')) . '&nbsp;&nbsp;' . __d('accounts', 'Связанные аккаунты'), array('controller' => 'users', 'action' => 'accounts'), array('escape' => false));?></li>
                <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-plane')) . '&nbsp;&nbsp;' . __d('accounts', 'Пригласить друзей'), array('controller' => 'invitations', 'action' => 'add') ,array('escape' => false));?></li>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="#"><i class="icon-globe"></i>&nbsp;&nbsp;<?php echo __d('users', 'Language'); ?></a>
                    <ul class="dropdown-menu langList">
                        <?php foreach(Configure::read('Config.lang.available') as $lang) : ?>
                            <li><a tabindex="-1" href="#" data="<?php echo h($lang['lang']); ?>"><?php echo h($lang['name']); ?>&nbsp;&nbsp;<?php if(Configure::read('Config.language') == $lang['lang']) : ;?><i class="icon-ok"></i><?php endif;?></a></li>
                        <?php endforeach; ?>
                        
                   </ul>
                </li>
                <li class="divider"></li>
                <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-off')) . '&nbsp;&nbsp;' . __d('accounts', 'Выход'), array('controller' => 'accounts', 'action' => 'logout'), array('escape' => false));?></li>
          </ul>
      </li>
      </ul>
    <?php endif; ?>
</div>
