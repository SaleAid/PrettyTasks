<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target="nav-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
        </a>
        <?php if ($currentUser): ?>
        <?php echo $this->Html->image("brand.". Configure::read('App.version') .".png", 
                                        array("alt" => "Pretty Tasks",
                                              'class' => 'brand',
                                              'width' => 156, 
                                              'height' => 30, 
                                              'url' => array('controller' => 'tasks', 'action' => 'index','#' => 'day-'.$this->Time->format('Y-m-d', time())))
            );?>
        <?php else: ?>
        <?php echo $this->Html->image("brand.". Configure::read('App.version') .".png", 
                                        array("alt" => "Pretty Tasks",
                                              'class' => 'brand',
                                              'width' => 156, 
                                              'height' => 30, 
                                              'url' => array('controller' => 'pages', 'action' => 'index'))
            );?>
        <?php endif;?>

      <div class="nav-collapse">
        <ul class="nav">
          <li class="<? if( isset($this->params['pass'][0]) and $this->params['pass'][0] == "contact" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'Contact'),
                    array('controller' => 'pages', 'action' => 'contact')
                );?>
          </li>
          <li class="<? if(isset($this->params['pass'][0]) and $this->params['pass'][0] == "about" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'About'),
                    array('controller' => 'pages', 'action' => 'about')
                );?>
          </li>
        </ul>
        <div class="pull-right">
            <span class="btn-group">
                <span class="dropdown-toggle" data-toggle="dropdown" data-target="#">
                    <span class="lang-top"><?php if(Configure::read('Config.language') == 'eng'){ echo __d('users', 'english'); }else {echo __d('users', 'russian');} ;?></span>
                </span>
                    <ul class="dropdown-menu langList s6">
                        <li ><a href="#" data="ru"><?php echo __d('users', 'russian'); ?></a></li>
                        <li class="divider"></li>
                        <li ><a href="#" data="en"><?php echo __d('users', 'english'); ?></a></li>
                   </ul>
             </span>  
            <?php echo $this->Html->link(__d('pages', 'Register'), array('controller' => 'users', 'action' => 'register'), array('class'=> 'btn btn-success')); ?>
            <?php echo $this->Html->link(__d('pages', 'Login'), array('controller' => 'users', 'action' => 'login'), array('class'=> 'btn btn-primary')); ?> 
        </div> 
      </div>
    
  </div>
</div>
</div>