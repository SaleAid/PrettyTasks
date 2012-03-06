   <div class="btn-group pull-right">
     <?php if(!empty($currentUser)): ?>
      <a class="btn btn-primary"><i class="icon-user icon-white"></i> 
	      <?php echo $currentUser['User']['first_name'].' '.$currentUser['User']['last_name']; ?>
	  </a>
      <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
        <li class="divider"></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-off')).' Logout',array('controller' => 'accounts', 'action' => 'logout'),array('escape' => false));?></li>
      </ul>
    <?php else: ?>
        <?php echo $this->Html->link('Login',array('controller' => 'accounts', 'action' => 'login')); ?>
        <?php //echo $this->Html->link('Login_modal','#login1',array('data-toggle' => 'modal','data-keyboard'=>true)); ?>
        
    <?php endif; ?>
   </div>
  
    
    
    
       
