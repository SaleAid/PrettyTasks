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
          <li class="<? if( isset($this->params['pass'][0]) and $this->params['pass'][0] == "contacts" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'Contact'),
                    array('controller' => 'pages', 'action' => 'contacts')
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
                    <span class="lang-top">
                        <?php echo Configure::read('Config.lang.available.'. Configure::read('Config.langURL') .'.name'); ?>
                    </span>
                </span>
                   <ul class="dropdown-menu langList s6">
                    <?php foreach(Configure::read('Config.lang.available') as $lang) : ?>
                        <li><a  href="#" data="<?php echo h($lang['lang']); ?>"><?php echo h($lang['name']); ?><?php if(Configure::read('Config.language') == $lang['lang']) : ;?>&nbsp;&nbsp;<i class="icon-ok"></i><?php endif;?></a></li>
                    <?php endforeach; ?> 
                   </ul>
               
             </span>  
            <?php echo $this->Html->link(__d('pages', 'Register'), array('controller' => 'users', 'action' => 'register'), array('class'=> 'btn btn-success')); ?>
            <?php echo $this->Html->link(__d('pages', 'Login'), array('controller' => 'users', 'action' => 'login'), array('class'=> 'btn btn-primary')); ?> 
        </div> 
      </div>
    
  </div>
</div>
</div>