<?php 
   //AutoLogin key
   
   Configure::write('AutoLogin.hash.key', 'DYhG91a3b0qyJf6Isxfs2guVoUubWw2vniR2G0FgaC9mi');
   Configure::write('AutoLogin.cookie.key', '762s852342393096574123125535496749683645');
   Configure::write('AutoLogin.rmb.key', '176859309634235745535424967496845121');
   
   Configure::write('GoogleAnalytics.ID', 'UA-29304740-1');
   
   // default timezone
   Configure::write('Config.timezone', 'UTC');
   
   Configure::write('Config.language', 'rus');
   Configure::write('Config.langURL', 'ru');
   
   Configure::write('Config.lang.available.ru', array('lang' => 'rus', 'name' => __d('users', 'Russian')));
   Configure::write('Config.lang.available.en', array('lang' => 'eng', 'name' => __d('users', 'English')));
   
   //define('FULL_BASE_URL', 'http://learning-2012.org.ua');
   if (isset($_SERVER['REQUEST_URI']))
        $_SERVER['REQUEST_URI'] = str_replace('://', ':%2F%2F', $_SERVER['REQUEST_URI']);

   Configure::write('Site.name', 'PrettyTasks');
   Configure::write('Site.url', 'http://'.@$_SERVER["HTTP_HOST"].'/');
   Configure::write('Site.title', 'PrettyTasks');
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
   Configure::write('Email.global.domain', 'prettytasks.com');
   Configure::write('Email.user.invitation.subject', __d('mail', 'Приглашение на сервис %s'));
   Configure::write('Email.user.activateAccount.subject', __d('mail', 'Активация аккаунта на сервисе %s'));
   Configure::write('Email.user.passwordResend.subject', __d('mail', 'Восстановление пароля на сервисе %s'));
   Configure::write('Email.user.todayDigest.subject', __d('mail', 'Today digest on Pretty Tasks'));
   
   //app version 
   //Configure::write('App.version', '1.0.5');
   $v =  trim(file_get_contents(dirname(__FILE__) . DS . 'appVERSION.txt'));
   Configure::write('App.version', $v);
   
   Configure::write('App.Minify.css', false);
   Configure::write('App.Minify.js', false);
   
   //
   Configure::write('App.allowHTTPS', false);
   Configure::write('App.maintenanceMode', false);
      
   Configure::write('Session.cookie', 'PrettyTasks');
   
   //repeated tasks
   Configure::write('Repeated.MaxCount', 360);
   
   //limits queries
   Configure::write('Tasks.Lists.Default.limit', 15);
   Configure::write('Tasks.Lists.Expired.limit', 10);
   Configure::write('Tasks.Lists.Continued.limit', 10);
   Configure::write('Tasks.Lists.Deleted.limit', 10);
   Configure::write('Tasks.Lists.Future.limit', 10);
   Configure::write('Tasks.Lists.Completed.limit', 10);
   Configure::write('Tasks.Lists.Planned.limit', 10);
   
   Configure::write('Notes.Lists.limit', 20);
   Configure::write('Days.journal.pagination.limit', 20);
   
   
   //Cache
   //Cache::config('elements', array(
//	'engine' => 'File',
//	'prefix' => 'el_',
//	'serialize' => false,
//	'duration' => '+999 days'
//  ));

