<?php
   echo $this->Html->css('start/start.'.Configure::read('App.version'), null, array('block' => 'toHead'));
 ?>
<div class="intro-header-divider"></div>

    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="intro-message">
                        <h1><strong>Prettytasks</strong>  - самый удобный онлайн органайзер. Задачи, списки, дневник, заметки всегда под рукой.</h1>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3>Задачи</h3>
                            <ul class="list-unstyled intro-list tasks">
                                <li><i class="fa fa-check fa-2"></i>Планируйте дела на каждый день</li>
                                <li><i class="fa fa-check fa-2"></i>Переносите задачи между днями</li>
                            </ul>
                            <h3>Списки</h3>
                            <ul class="list-unstyled intro-list tasks">
                                <li><i class="fa fa-check fa-2"></i>Составляйте тематические списки задач</li>
                                <li><i class="fa fa-check fa-2"></i>Смотрите будущие и просроченные задачи</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3>Дневник</h3>
                            <ul class="list-unstyled intro-list ">
                                <li><i class="fa fa-check fa-2"></i>Отмечайте дни как удачные</li>
                                <li><i class="fa fa-check fa-2"></i>Пишите историю своих успехов и достижений</li>
                            </ul>
                            <h3>Заметки</h3>
                            <ul class="list-unstyled intro-list ">
                                <li><i class="fa fa-check fa-2"></i>Запоминайте нужную информацию</li>
                                <li><i class="fa fa-check fa-2"></i>Заносите заметки в избранное</li>
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
                            <h4>Календарное планирование</h4>
                            <p>Планирование задач на каждый день<br/> 
                            Перенос и копирование задач
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/diary.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Дневник</h4>
                            <p>Записи ежедневных событий
                            <br/>
                            Выделение успешных дней
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/list.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Списки задач</h4>
                            <p>
                                Тематическая группировка задач
                                <br/>
                                Множественная привязка к спискам
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/note.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Заметки</h4>
                            <p>
                                Блокнот для заметок
                                <br/>
                                Список избранных заметок
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/search.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Автоматические списки</h4>
                            <p>Быстрый доступ к планируемым, просроченным, завершенным, будущим, длительным и удаленным задачам</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 left-icon">
                            <?php echo $this->Html->image('start/available.png', array('width' => 66, 'height' => 66)); ?>
                            <h4>Доступность</h4>
                            <p>Доступ к информации 24/7 с помощью сайта, мобильных приложений, браузерных плагинов</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div id="testimonials">
                        <ul class="slides">
                            <li>
                                <p>Хороший сервис, люблю его.  Очень удобно, когда все задачи и заметки в одном месте.</p>
                                <span class="author"><strong>Татьяна К.</strong> </span>
                            </li>
                        </ul>
                    </div>
                    <div class="google-play-widget">
                        <a href="https://play.google.com/store/apps/details?id=com.prettytasks.prettytaskswidget" target="_blank">
                          <img alt="Get it on Google Play"
                               src="https://developer.android.com/images/brand/ru_generic_rgb_wo_45.png" />
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
            