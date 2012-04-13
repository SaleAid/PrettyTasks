<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
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
            <?php echo $this->Html->link(
                            'Tasks',
                            array('controller' => 'tasks', 'action' => 'index')
            );?>    
          </li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      <?php echo $this->element('current_user'); ?>  
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
