<?php
   echo $this->Html->css('start/start.'.Configure::read('App.version'), null, array('block' => 'toHead'));
 ?>
<div class="intro-header-divider"></div>

    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="intro-message">
                        <h1><strong>Prettytasks</strong> is the most convenient online organizer. Have all your tasks, lists, notes and a diary at your fingertips.</h1>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3>Tasks</h3>
                            <ul class="list-unstyled intro-list tasks">
                                <li><i class="fa fa-check fa-2"></i>Plan your everyday affairs</li>
                                <li><i class="fa fa-check fa-2"></i>Move tasks between days</li>
                            </ul>
                            <h3>Lists</h3>
                            <ul class="list-unstyled intro-list ">
                                <li><i class="fa fa-check fa-2"></i>Make thematic task lists</li>
                                <li><i class="fa fa-check fa-2"></i>Browse future and expired tasks</li>
                            </ul>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3>Diary</h3>
                            <ul class="list-unstyled intro-list ">
                                <li><i class="fa fa-check fa-2"></i>Mark days as lucky ones</li>
                                <li><i class="fa fa-check fa-2"></i>Write a story of your own achievements</li>
                            </ul>
                            <h3>Notes</h3>
                            <ul class="list-unstyled intro-list ">
                                <li><i class="fa fa-check fa-2"></i>Remember a necessary information</li>
                                <li><i class="fa fa-check fa-2"></i>Add notes to favorites</li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                        <?php echo $this->Form->create('Account', array('action' => 'login', 'class' => 'form-horizontal form-area', 'role' => 'form')); ?>
                      <h1><?php  echo __d('accounts', 'Вход'); ?></h1>
                      <div class="form-group">
                        <div class="col-sm-12">
                        <?php  echo $this->Form->input('email', array(
                            'before' => false,
                            'after' => false,
                            'between' => false,
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Email'
                        ));?>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <?php  echo $this->Form->input('password', array(
                            'before' => false,
                            'after' => false,
                            'between' => false,
                            'type' => 'password',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Password'
                        ));?>
                        </div>
                      </div>
                    <div class="form-inline">
                            <?php echo $this->Form->submit(__d('accounts', 'Вход'), array('class' => 'btn btn-success btn-block', 'div' => false)); ?>
                            <div class="bnt-reg">
                                   <span class="social-or"><?php echo __d('accounts', 'ИЛИ'); ?></span>
                                   <?php echo $this->Html->link(__d('accounts', 'Регистрация'), array('controller' => 'accounts', 'action' => 'register'), array('class' => 'btn btn-primary btn-block', 'div' => false)); ?>
                               </div>    
                                <div class="social-bnts">
                                   <span class="social-or"><?php echo __d('accounts', 'ИЛИ'); ?></span>
                                   <div class="box center">
                                        <div class="social-buttons">
                                            <div class="s-btns">
                                            <?php
                                                echo $this->Html->link(
                                                         '<span class="google">&nbsp;</span>',
                                                         array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                                             'google'
                                                         ),
                                                         array('escape' => false, 'tabindex' => -1, "alt" => "Google", "title" => "Google")
                                                     );
                                            ?>
                                            <?php
                                                echo $this->Html->link(
                                                         '<span class="facebook">&nbsp;</span>',
                                                         array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                                             'facebook'
                                                         ),
                                                         array('escape' => false, 'tabindex' => -1, "alt" => "Facebook", "title" => "Facebook")
                                                     );
                                            ?>
                                            <?php
                                                echo $this->Html->link(
                                                         '<span class="linkedin">&nbsp;</span>',
                                                         array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                                             'linkedin'
                                                         ),
                                                         array('escape' => false, 'tabindex' => -1, "alt" => "LinkedIn", "title" => "LinkedIn")
                                                     );
                                            ?>
                                            <?php
                                                echo $this->Html->link(
                                                         '<span class="twitter">&nbsp;</span>',
                                                         array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                                             'twitter'
                                                         ),
                                                         array('escape' => false, 'tabindex' => -1, "alt" => "Twitter", "title" => "Twitter")
                                                     );
                                            ?>
                                            <?php
                                                echo $this->Html->link(
                                                         '<span class="vkontakte">&nbsp;</span>',
                                                         array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                                             'vkontakte'
                                                         ),
                                                         array('escape' => false, 'tabindex' => -1, "alt" => "ВКонтакте", "title" => "ВКонтакте")
                                                     );
                                            ?>
                                            </div>    
                                        </div>
                                   </div>
                                </div>

                        </div>
                  <div class="form-area-bottom">&nbsp;</div>
                <?php echo $this->Form->end(); ?>
</div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->
    <div class="content-section-a unique-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/calendar.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Diary Scheduling</h4>
                            <p>Everyday tasks planning<br/> 
                            Expired tasks moving
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/diary.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Diary</h4>
                            <p>Everyday events recording
                            <br/>
                            Lucky days highlighting
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/list.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Task Lists</h4>
                            <p>
                                Thematic tasks grouping
                                <br/>
                                Multiple lists binding
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/note.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Notes</h4>
                            <p>
                                A memo pad 
                                <br/>
                                A list of selected notes
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/search.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Automatic lists</h4>
                            <p>A fast access to planned, expired, completed, future, long-term and deleted tasks</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/available.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Availability</h4>
                            <p>An access to the information 24/7 with the help of a web site, mobile apps, browser plugins</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <div id="testimonials">
                        <ul class="slides">
                            <li>
                              <p>Beautiful service, great integration! Thank you for having all my highlights at my fingertips!</p>
                              <span class="author"><strong>Jessica M.</strong> </span>
                            </li>
                        </ul>
                    </div>
                    <div class="google-play-widget">
                        <a href="https://play.google.com/store/apps/details?id=com.prettytasks.prettytaskswidget" target="_blank">
                          <img alt="Get it on Google Play"
                               src="https://developer.android.com/images/brand/en_generic_rgb_wo_45.png" />
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
            