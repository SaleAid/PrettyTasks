<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
    
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <?php echo $this->Html->link(
                            'Besttask ...pre-alpha version',
                            array('controller' => 'tasks', 'action' => 'index'),
                            array('class' => 'brand')
      );?>

      <div class="nav-collapse">
        <ul class="nav">
          <li class="<? if($this->params['action'] == "index" and $this->params['controller'] == "Tasks") echo 'active'; ?>">
                <?php echo $this->Html->link(
                                'Tasks',
                                array('controller' => 'Tasks', 'action' => 'index')
                );?>    
          </li>
          <li class="<? if($this->params['action'] == "index" and $this->params['controller'] == "Calendar") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    'Calendar',
                    array('controller' => 'Calendar', 'action' => 'index')
                );?>  
          </li>
          <li class="<? if($this->params['action'] == "agenda" and $this->params['controller'] == "Tasks") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    'Agenda',
                    array('controller' => 'Tasks', 'action' => 'agenda')
                );?>
          </li>
          <li class="<? if($this->params['action'] == "contact" and $this->params['controller'] == "Pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    'Contact',
                    array('controller' => 'Pages', 'action' => 'contact')
                );?>
          </li>
          <li class="<? if($this->params['action'] == "about" and $this->params['controller'] == "Pages") echo 'active'; ?>">
              <?php echo $this->Html->link(
                    'About',
                    array('controller' => 'Pages', 'action' => 'about')
                );?>
          </li>
        </ul>
        <?php echo $this->element('current_user'); ?> 
         
      </div>
    
  </div>
</div>
</div>