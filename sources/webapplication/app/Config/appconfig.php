<?php 
   Configure::write('loginza.id', '14377');
   Configure::write('loginza.skey', '21013aca17787a9d1b8cf4be7c7f5aeb');
   Configure::write('loginza.token_url', 'http://learning-2012.org.ua/accounts/loginzalogin');
   Configure::write('loginza.widget_url', 'http://loginza.ru/js/widget.js');
   Configure::write('Recaptcha.publicKey', '6Lff1M4SAAAAAFQKlC0j9iy4nhQnc82o-5jmGuIa');
   Configure::write('Recaptcha.privateKey', '6Lff1M4SAAAAAFbUUEYXP9c92v4fXvxf3m3BcBM3');
   Configure::write('Recaptcha.theme', 'white');
   Configure::write('Config.language', 'rus');
   
   Configure::write('Site.name', 'BestTasks best task service');
   Configure::write('Site.url', 'http://'.$_SERVER["HTTP_HOST"].'/');
   Configure::write('Site.title', 'BestTasks');
   Configure::write('Site.keywords', 'BestTasks, tasks, forget about milk');
   Configure::write('Site.description', 'BestTasks is the best personal tasks management service');
   
   Configure::write('User.default.beta', false);
   Configure::write('User.default.pro', false);
   
   Configure::write('Email.global.from', 'noreplay@besttasks.com');
   Configure::write('Email.global.format', 'html');
   Configure::write('Email.user.invitation.subject', __('Приглашение на сервис %s', Configure::read('Site.name')));
   Configure::write('Email.user.activateAccount.subject', __('Активация аккаунта на сервисе %s', Configure::read('Site.name')));
   Configure::write('Email.user.passwordResend.subject', __('Сбросить пароль на сервисе %s', Configure::read('Site.name')));
   Configure::write('App.version', '1.0.1');
   //Cache
   //Cache::config('elements', array(
//	'engine' => 'File',
//	'prefix' => 'el_',
//	'serialize' => false,
//	'duration' => '+999 days'
//));

