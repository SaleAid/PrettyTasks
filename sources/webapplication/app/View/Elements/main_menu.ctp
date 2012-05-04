<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
    <div class="span12">
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
          <li class="active">
            <?php 
            //TODO SELECT ITEMS
            echo $this->Html->link(
                            'Tasks',
                            array('controller' => 'Tasks', 'action' => 'index')
                        );?>    
          </li>
          <li>            <?php echo $this->Html->link(
                            'Calendar',
                            array('controller' => 'Calendar', 'action' => 'index')
                        );?>  </li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <?php echo $this->element('current_user'); ?>  
      </div>
    </div>
  </div>
</div>
</div>