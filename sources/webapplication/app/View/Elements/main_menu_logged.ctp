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
          <?php if ($currentUser): ?>
          <li class="tasks <? if($this->params['action'] == "index" and strtolower($this->params['controller']) == "tasks") echo 'active'; ?>">
                <?php echo $this->Html->link(
                                __d('pages', 'Tasks'),
                                array('controller' => 'tasks', 'action' => 'index', '#' => 'day-'.$this->Time->format('Y-m-d', time()))
                );?>    
          </li>
         <!-- <?php //if ($isBetaUser):?>
          <li class="<? //if($this->params['action'] == "index" and strtolower($this->params['controller']) == "calendar") echo 'active'; ?>">
              <?php //echo $this->Html->link(
                    //__d('pages', Calendar'),
                   // array('controller' => 'calendar', 'action' => 'index')
                //);?>  
          </li>
          <?php //endif;?>
          -->
          <li class="agenda <? if($this->params['action'] == "agenda" and strtolower($this->params['controller']) == "tasks") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('pages', 'Agenda'),
                    array('controller' => 'tasks', 'action' => 'index', '#' => 'day-future')
                    //array('controller' => 'tasks', 'action' => 'agenda')
                );?>
          </li>
          <?php endif;?>
          <li class="<? if($this->params['action'] == "journal" and strtolower($this->params['controller']) == "days") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    __d('days', 'Journal'),
                    array('controller' => 'days', 'action' => 'journal')
                );?>
          </li>

        </ul>
        <?php echo $this->element('current_user'); ?> 
         
      </div>
    
  </div>
</div>
</div>