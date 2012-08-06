<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
        </a>
        <?php if ($currentUser): ?>
        <?php echo $this->Html->link(
                            '',
                            array('controller' => 'tasks', 'action' => 'index', '#' => 'day-'.$this->Time->format('Y-m-d', time())),
                            array('class' => 'brand')
        );?>
        <?php else: ?>
        <?php echo $this->Html->link(
                            '',
                            array('controller' => 'pages', 'action' => 'index'),
                            array('class' => 'brand')
        );?>
        <?php endif;?>

      <div class="nav-collapse">
        <ul class="nav">
          <?php if ($currentUser): ?>
          <li class="tasks <? if($this->params['action'] == "index" and strtolower($this->params['controller']) == "tasks") echo 'active'; ?>">
                <?php echo $this->Html->link(
                                __('Tasks'),
                                array('controller' => 'tasks', 'action' => 'index', '#' => 'day-'.$this->Time->format('Y-m-d', time()))
                );?>    
          </li>
         <!-- <?php //if ($isBetaUser):?>
          <li class="<? //if($this->params['action'] == "index" and strtolower($this->params['controller']) == "calendar") echo 'active'; ?>">
              <?php //echo $this->Html->link(
                    //__('Calendar'),
                   // array('controller' => 'calendar', 'action' => 'index')
                //);?>  
          </li>
          <?php //endif;?>
          -->
          <li class="agenda <? if($this->params['action'] == "agenda" and strtolower($this->params['controller']) == "tasks") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('Agenda'),
                    array('controller' => 'tasks', 'action' => 'index', '#' => 'day-future')
                    //array('controller' => 'tasks', 'action' => 'agenda')
                );?>
          </li>
          <?php endif;?>
          <li class="<? if( isset($this->params['pass'][0]) and $this->params['pass'][0] == "contact" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __('Contact'),
                    array('controller' => 'pages', 'action' => 'contact')
                );?>
          </li>
          <li class="<? if(isset($this->params['pass'][0]) and $this->params['pass'][0] == "about" and strtolower($this->params['controller']) == "pages") echo 'active'; ?>">
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