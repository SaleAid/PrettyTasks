
<div class="btn-group pull-right">
     <img class="pull-left ajaxLoader hide" src="/img/ajax-loader.gif"/>
     <?php if(!empty($currentUser)):  ?>
     <?php echo $this->Html->link($this->Html->tag('i', '',
                 //array('class' => 'icon-user icon-white')). ' { '.$provider.' }' .$currentUser['User']['full_name']. ' ',
                 array('class' => 'icon-user icon-white')). '  ' . ' ' .$currentUser['first_name']. ' ' .$currentUser['last_name'].' '.$this->Loginza->ico($provider),
                 array('controller' => 'users', 'action' => 'profile'),array('escape' => false, 'class'=> 'btn btn-primary'));?>
      
      <a class="btn btn-primary dropdown-toggle " data-toggle="dropdown" href="#"><span class="caret"></span></a>
      
      <ul class="dropdown-menu pull-right no-collapse">
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => ' icon-edit')).__('  Учётная запись'),array('controller' => 'users', 'action' => 'profile'),array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pencil')).__('  Изменить пароль'),array('controller' => 'users', 'action' => 'password_change'),array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-magnet')).__('  Связанные аккаунты'),array('controller' => 'users', 'action' => 'accounts'),array('escape' => false));?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-plane')).__('  Пригласить друзей'),array('controller' => 'invitations', 'action' => 'add'),array('escape' => false));?></li>
        
        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
        <li class="divider"></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-off')). __('  Выход'),array('controller' => 'users', 'action' => 'logout'),array('escape' => false));?></li>
      </ul>
    <?php else: ?>
        <?php echo $this->Html->link('Login',array('controller' => 'users', 'action' => 'login'),array('class'=> 'btn btn-primary')); ?>
        
    <?php endif; ?>
    
    
   </div>
   
  
    
    
    
       
