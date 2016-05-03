<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');
App::uses('ErrorHandler', 'Error');

class AppErrorHandler extends ErrorHandler {

/**
 * Set as the default exception handler by the CakePHP bootstrap process.
 *
 * This will either use custom exception renderer class if configured,
 * or use the default ExceptionRenderer.
 *
 * @param Exception $exception
 * @return void
 * @see http://php.net/manual/en/function.set-exception-handler.php
 */
	public static function handleException(Exception $exception) {
		$config = Configure::read('Exception');
		self::_sendMailException($exception, $config);
		parent::handleException($exception);
	}

/**
 * Set as the default error handler by CakePHP. Use Configure::write('Error.handler', $callback), to use your own
 * error handling methods. This function will use Debugger to display errors when debug > 0. And
 * will log errors to CakeLog, when debug == 0.
 *
 * You can use Configure::write('Error.level', $value); to set what type of errors will be handled here.
 * Stack traces for errors can be enabled with Configure::write('Error.trace', true);
 *
 * @param integer $code Code of error
 * @param string $description Error description
 * @param string $file File on which error occurred
 * @param integer $line Line that triggered the error
 * @param array $context Context
 * @return boolean true if error was handled
 */
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {
		$config = Configure::read('Error');
		$logMessage = 'Error (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']';
		self::_sendMailError($logMessage, $config);
		parent::handleError($code, $description, $file, $line, $context);
	}

/**
 * send mail for exception
 *
 * @param Exception $exception
 * @param array $config
 * @return boolean
 */
	protected static function _sendMailException(Exception $exception, $config) {
		if (empty($config['sendMail']) || (CakeSession::check('Exception.send.time') && CakeTime::wasWithinLast("15 minutes", CakeSession::read('Exception.send.time'))) ) {
			return false;
		}
		CakeSession::write('Exception.send.time', time());
		$Email = new CakeEmail('error');
		$Email->from(Configure::read('Email.global.from'))
		    ->to(Configure::read('App.support.mail'))
		    ->subject(sprintf("[%s] %s",
				get_class($exception),
				$exception->getMessage())
			)
		    ->send(self::_getMessage($exception));
		return; 
	}

/**
 * send mail for Error
 *
 * @param string $message
 * @param array $config
 * @return boolean
 */
	protected static function _sendMailError($message, $config) {
		if (empty($config['sendMail']) || (CakeSession::check('Error.send.time') && CakeTime::wasWithinLast("15 minutes", CakeSession::read('Error.send.time'))) ) {
			return false;
		}
		CakeSession::write('Error.send.time', time());

		$Email = new CakeEmail('error');
		$Email->from(Configure::read('Email.global.from'))
		    ->to(Configure::read('App.support.mail'))
		    ->subject("[Error]")
		    ->send($message);
		return; 
	}

}