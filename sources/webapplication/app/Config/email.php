<?php

class EmailConfig {
    /**
     * 
     * @var array
     */
    public $default = array(
			'transport' => 'Smtp',
			'host' => 'smtp.sparkpostmail.com',
			'port' => 587,
			'username' => 'SMTP_Injection',
			'password' => 'c8610c7f6ab6c42f0fb313a027f03beb9892a47e',
			'tls' => true,

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
			'host' => 'smtp.sparkpostmail.com',
			'port' => 587,
			'username' => 'SMTP_Injection',
			'password' => 'c8610c7f6ab6c42f0fb313a027f03beb9892a47e',
			'tls' => true,

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
			'host' => 'smtp.sparkpostmail.com',
			'port' => 587,
			'username' => 'SMTP_Injection',
			'password' => 'c8610c7f6ab6c42f0fb313a027f03beb9892a47e',
			'tls' => true,

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
			'host' => 'smtp.sparkpostmail.com',
			'port' => 587,
			'username' => 'SMTP_Injection',
			'password' => 'c8610c7f6ab6c42f0fb313a027f03beb9892a47e',
			'tls' => true,

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
     * This config is used for error email
     *
     * @var array
     */
    public $error = array(
			'transport' => 'Smtp',
			'host' => 'smtp.sparkpostmail.com',
			'port' => 587,
			'username' => 'SMTP_Injection',
			'password' => 'c8610c7f6ab6c42f0fb313a027f03beb9892a47e',
			'tls' => true,

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
