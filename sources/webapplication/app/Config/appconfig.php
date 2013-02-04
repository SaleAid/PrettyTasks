<?php 
   Configure::write('loginza.id', '14377');
   Configure::write('loginza.skey', '21013aca17787a9d1b8cf4be7c7f5aeb');
   Configure::write('loginza.token_url', 'http://learning-2012.org.ua/accounts/loginzalogin');
   Configure::write('loginza.widget_url', 'http://loginza.ru/js/widget.js');
   
   Configure::write('loginza.provider', array('facebook' => 'http://www.facebook.com/',
                                              'twitter' => 'http://twitter.com/',
                                              'vkontakte' => 'http://vk.com/',
                                              'google' => 'https://www.google.com/accounts/o8/ud',
                                              'linkedin' => 'http://www.linkedin.com/'
                                        )
            );
   
   
   Configure::write('Recaptcha.publicKey', '6Lff1M4SAAAAAFQKlC0j9iy4nhQnc82o-5jmGuIa');
   Configure::write('Recaptcha.privateKey', '6Lff1M4SAAAAAFbUUEYXP9c92v4fXvxf3m3BcBM3');
   Configure::write('Recaptcha.theme', 'white');
   Configure::write('Recaptcha.tabindex', 2);
   
   Configure::write('GoogleAnalytics.ID', 'UA-29304740-1');
   
   // default timezone
   Configure::write('Config.timezone', 'UTC');
   
   Configure::write('Config.language', 'rus');
   Configure::write('Config.langURL', 'ru');
   
   Configure::write('Config.lang.available.ru', array('lang' => 'rus', 'name' => __d('users', 'Russian')));
   Configure::write('Config.lang.available.en', array('lang' => 'eng', 'name' => __d('users', 'English')));
   
   define('FULL_BASE_URL', 'http://prettytasks.lcom');
   
   Configure::write('Site.name', 'Pretty Tasks');
   Configure::write('Site.url', 'http://'.@$_SERVER["HTTP_HOST"].'/');
   Configure::write('Site.title', 'Pretty Tasks');
   Configure::write('Site.keywords', 'Pretty Tasks, tasks, gtd, goals, aims, success, schedule, time management');
   Configure::write('Site.description', 'Pretty Tasks is the prettiest personal tasks management service');
   //SEO ru
   Configure::write('SEO.Registration.title.ru', 'Регистрация на сайте');
   Configure::write('SEO.Registration.keywords.ru', 'Pretty Tasks, gtd, tasks management, registration, управление временем, списки задач, регистрация');
   Configure::write('SEO.Registration.description.ru', 'Страница регистрации на сервисе PrettyTasks. На этой странице вы можете создать свой аккаунт');
   
   Configure::write('SEO.Login.title.ru', 'Вход на сайт');
   Configure::write('SEO.Login.keywords.ru', 'Pretty Tasks, gtd, tasks management, login, управление временем, списки задач, вход на сайт');
   Configure::write('SEO.Login.description.ru', 'Страница входа(логина) на сервис PrettyTasks');
   
   Configure::write('SEO.Pages.title.ru', 'Приятный личный сервис управления задачами');
   Configure::write('SEO.Pages.keywords.ru', 'Pretty Tasks, gtd, tasks management, todo list, управление временем, списки задач, удобная система');
   Configure::write('SEO.Pages.description.ru', 'PrettyTasks - сервис управления личными задачами с максимальной удобностью использования. Пользуйтесь лучшей системой интуитивно и с удовольствием!');
   
   //SEO en
   Configure::write('SEO.Registration.title.en', 'Registering on the site');
   Configure::write('SEO.Registration.keywords.en', 'Pretty Tasks, gtd, tasks management, todo list, registration, time management, task lists, registration');
   Configure::write('SEO.Registration.description.en', 'Registration page at the service PrettyTasks. We create your account at this page');
   
   Configure::write('SEO.Login.title.en', 'Login');
   Configure::write('SEO.Login.keywords.en', 'Pretty Tasks, gtd, tasks management, todo list, login, time management, task lists, login to site');
   Configure::write('SEO.Login.description.en', 'Login page of PrettyTasks service');
   
   Configure::write('SEO.Pages.title.en', 'Pleasant personal service for task management');
   Configure::write('SEO.Pages.keywords.en', 'Pretty Tasks, gtd, tasks management, todo list, time management, task lists, easy-to-use system');
   Configure::write('SEO.Pages.description.en', 'PrettyTasks - a service of personal task management with maximum usability. Use the best system intuitively!');
   
   Configure::write('Share.description', __d('appconfig', 'PrettyTasks - сервис управления личными задачами с максимальной удобностью использования.'));
   
   Configure::write('User.default.beta', false);
   Configure::write('User.default.pro', false);
   
   Configure::write('Email.global.from', array('noreply@prettytasks.com' => 'Pretty Tasks'));
   Configure::write('Email.global.format', 'html');
   Configure::write('Email.user.invitation.subject', __d('mail', 'Приглашение на сервис %s'));
   Configure::write('Email.user.activateAccount.subject', __d('mail', 'Активация аккаунта на сервисе %s'));
   Configure::write('Email.user.passwordResend.subject', __d('mail', 'Сбросить пароль на сервисе %s'));
   Configure::write('Email.user.todayDigest.subject', __d('mail', 'Today digest on Pretty Tasks'));
   
   //app version 
   //Configure::write('App.version', '1.0.5');
   Configure::write('App.version', trim(array_pop(file(dirname(__FILE__) . DS . 'appVERSION.txt'))));
   
   Configure::write('App.Minify.css', false);
   Configure::write('App.Minify.js', false);
      
   Configure::write('Session.cookie', 'PrettyTasks');
   
   
   
   //Cache
   //Cache::config('elements', array(
//	'engine' => 'File',
//	'prefix' => 'el_',
//	'serialize' => false,
//	'duration' => '+999 days'
//  ));

