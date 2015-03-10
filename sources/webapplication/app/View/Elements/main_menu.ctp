<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <?php
        if (Configure::read('debug') > 0) {
            echo $this->element('test_server', array(), array(
                "cache" => array('config' => 'elements', 'key' => Configure::read('Config.language'))
            ));
        }
    ?>

    <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
        </button>
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
        <ul class="nav top">
          <li class="<?php if( isset($this->params['pass'][0]) and $this->params['pass'][0] == "contacts" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'Contact'),
                    array('controller' => 'pages', 'action' => 'contacts')
                );?>
          </li>
          <li class="<?php if(isset($this->params['pass'][0]) and $this->params['pass'][0] == "about" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'About'),
                    array('controller' => 'pages', 'action' => 'about')
                );?>
          </li>
        </ul>
        <div class="pull-right menu-lang">
            <span class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#">
                    <span class="lang-top">
                        <?php echo Configure::read('Config.lang.available.'. Configure::read('Config.langURL') .'.name'); ?>
                    </span>
                </a>
                   <ul class="dropdown-menu langList s6" role="menu" aria-labelledby="dLabel">
                    <?php foreach(Configure::read('Config.lang.available') as $key => $lang) : ?>
                        <li><a href="/<?php echo h($key); ?>" data="<?php echo h($lang['lang']); ?>"><?php echo h($lang['name']); ?><?php if(Configure::read('Config.language') == $lang['lang']) : ;?>&nbsp;&nbsp;<i class="icon-ok"></i><?php endif;?></a></li>
                    <?php endforeach; ?> 
                   </ul>
             </span>  
            <?php echo $this->Html->link(__d('pages', 'Register'), array('controller' => 'accounts', 'action' => 'register'), array('class'=> 'btn btn-success')); ?>
            <?php echo $this->Html->link(__d('pages', 'Login'), array('controller' => 'accounts', 'action' => 'login'), array('class'=> 'btn btn-primary')); ?> 
        </div> 
      </div>
    
  </div>
</div>
</div>