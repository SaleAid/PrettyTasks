<?php 
   Configure::write('loginza.id', '14377');
   Configure::write('loginza.skey', '21013aca17787a9d1b8cf4be7c7f5aeb');
   Configure::write('loginza.token_url', 'http://learning-2012.org.ua/accounts/loginzalogin');
   Configure::write('loginza.widget_url', 'http://loginza.ru/js/widget.js');
   
   Configure::write('Recaptcha.publicKey', '6Lff1M4SAAAAAFQKlC0j9iy4nhQnc82o-5jmGuIa');
   Configure::write('Recaptcha.privateKey', '6Lff1M4SAAAAAFbUUEYXP9c92v4fXvxf3m3BcBM3');
   Configure::write('Recaptcha.theme', 'white');
   Configure::write('Recaptcha.tabindex', 2);
   
   Configure::write('GoogleAnalytics.ID', 'UA-29304740-1');
   
   Configure::write('Config.language', 'rus');
   Configure::write('Config.langURL', 'ru');
   
   Configure::write('Config.lang.available.ru', array('lang' => 'rus', 'name' => __d('users', 'Russian')));
   Configure::write('Config.lang.available.en', array('lang' => 'eng', 'name' => __d('users', 'English')));
   
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
   Configure::write('SEO.Pages.keywords.ru', 'Pretty Tasks, gtd, tasks management, управление временем, списки задач, удобная система');
   Configure::write('SEO.Pages.description.ru', 'PrettyTasks - сервис управления личными задачами с максимальной удобностью использования. Пользуйтесь интуитивно лучшей системой!');
   
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
   
   Configure::write('User.default.beta', false);
   Configure::write('User.default.pro', false);
   
   Configure::write('Email.global.from', 'noreply@prettytasks.com');
   Configure::write('Email.global.format', 'html');
   Configure::write('Email.user.invitation.subject', 'Приглашение на сервис %s');
   Configure::write('Email.user.activateAccount.subject', 'Активация аккаунта на сервисе %s');
   Configure::write('Email.user.passwordResend.subject', 'Сбросить пароль на сервисе %s');
   Configure::write('App.version', '1.0.5');
   
   Configure::write('App.Minify.css', true);
   Configure::write('App.Minify.js', true);
      
   Configure::write('Session.cookie', 'PrettyTasks');
   
   //Cache
   //Cache::config('elements', array(
//	'engine' => 'File',
//	'prefix' => 'el_',
//	'serialize' => false,
//	'duration' => '+999 days'
//  ));

