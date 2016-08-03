<?php 
   /**
     * Opauth strategy configurations
     */
	// Facebook strategy
	Configure::write('Opauth.Strategy.Facebook', array(
		'app_id' => '356477577804825',
		'app_secret' => 'edac3685bef259e17d8492dd25b9342c',
        'scope' => 'email'
	));

	// Google strategy
	Configure::write('Opauth.Strategy.Google', array(
		'client_id' => '226306736178.apps.googleusercontent.com',
		'client_secret' => '0POD3XzFffwWTi039KmA-cej'
	));

	// Twitter strategy
	Configure::write('Opauth.Strategy.Twitter', array(
		'key' => 'u7RZQjVggN9ispoxUOZWQ',
		'secret' => 'ADYeFj5v40IFeF9zGRx1HyZynBWI6XZAsD8KbiezFk'
        
	));

	// LinkedIn strategy
	Configure::write('Opauth.Strategy.LinkedIn', array(
	    'api_key' => 'd8b85xxfrttx',
		'secret_key' => 'smwNsYgK34mh5SN5',
        'scope' => 'r_emailaddress r_basicprofile'  
        
    ));
   
   // Vkontakte strategy
	Configure::write('Opauth.Strategy.VKontakte', array(
	    'app_id' => '3682682',
		'app_secret' => 'pUxgCOliewOaI5Az4xAt',
        
    ));
