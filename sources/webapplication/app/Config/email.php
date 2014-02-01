<?php

class EmailConfig {
    /**
     * 
     * @var array
     */
    public $default = array(
            'transport' => 'Smtp',
            'host' => 'smtp.mandrillapp.com',
            'port' => 587,
            'username' => 'prettytasks@gmail.com',
            'password' => 'PG8cWfu51HWrQeLn6UJZ5Q',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'from' => array(
                    'info@prettytasks.com' => 'PrettyTasks Online Organizer'
            ),
            'replyTo' => array(
                    'info@prettytasks.com' => 'PrettyTasks Online Organizer'
            )
    );
    
    /**
     * This config is used for Account email
     *
     * @var array
     */
    public $account = array(
            'transport' => 'Smtp',
            'host' => 'smtp.mandrillapp.com',
            'port' => 587,
            'username' => 'prettytasks@gmail.com',
            'password' => 'PG8cWfu51HWrQeLn6UJZ5Q',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'from' => array(
                    'info@prettytasks.com' => 'PrettyTasks Online Organizer'
            ),
            'replyTo' => array(
                    'info@prettytasks.com' => 'PrettyTasks Online Organizer'
            )
    );
    
    /**
     * This config is used for Feedback email
     *
     * @var array
     */
    public $feedback = array(
    		'transport' => 'Smtp',
    		'host' => 'smtp.mandrillapp.com',
    		'port' => 587,
    		'username' => 'prettytasks@gmail.com',
    		'password' => 'PG8cWfu51HWrQeLn6UJZ5Q',
    		'charset' => 'utf-8',
    		'headerCharset' => 'utf-8',
    		'from' => array(
    				'info@prettytasks.com' => 'PrettyTasks Online Organizer'
    		),
    		'replyTo' => array(
    				'info@prettytasks.com' => 'PrettyTasks Online Organizer'
    		)
    );

    /**
     * This config is used for invitation email
     *
     * @var array
     */
    public $invitation = array(
    		'transport' => 'Smtp',
    		'host' => 'smtp.mandrillapp.com',
    		'port' => 587,
    		'username' => 'prettytasks@gmail.com',
    		'password' => 'PG8cWfu51HWrQeLn6UJZ5Q',
    		'charset' => 'utf-8',
    		'headerCharset' => 'utf-8',
    		'from' => array(
    				'info@prettytasks.com' => 'PrettyTasks Online Organizer'
    		),
    		'replyTo' => array(
    				'info@prettytasks.com' => 'PrettyTasks Online Organizer'
    		)
    );

}
