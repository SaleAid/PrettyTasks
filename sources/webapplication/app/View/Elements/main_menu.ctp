<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
        </a>
      <?php echo $this->Html->link(
                            '',
                            array('controller' => 'Pages', 'action' => 'index'),
                            array('class' => 'brand')
      );?>

      <div class="nav-collapse" >
        <ul class="nav">
          <?php if ($currentUser): ?>
          <li class="<? if($this->params['action'] == "index" and strtolower($this->params['controller']) == "tasks") echo 'active'; ?>">
                <?php echo $this->Html->link(
                                __('Tasks'),
                                array('controller' => 'Tasks', 'action' => 'index')
                );?>    
          </li>
          <?php if ($isBetaUser):?>
          <li class="<? if($this->params['action'] == "index" and strtolower($this->params['controller']) == "calendar") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('Calendar'),
                    array('controller' => 'calendar', 'action' => 'index')
                );?>  
          </li>
          <?php endif;?>
          <li class="<? if($this->params['action'] == "agenda" and strtolower($this->params['controller']) == "pasks") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('Agenda'),
                    '/tasks#day-future'
                    //array('controller' => 'tasks', 'action' => 'agenda')
                );?>
          </li>
          <?php endif;?>
          <li class="<? if($this->params['action'] == "contact" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('Contact'),
                    array('controller' => 'pages', 'action' => 'contact')
                );?>
          </li>
          <li class="<? if($this->params['action'] == "about" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('About'),
                    array('controller' => 'pages', 'action' => 'about')
                );?>
          </li>
        </ul>
        <?php echo $this->element('current_user'); ?> 
         
      </div>
    
  </div>
</div>
</div>