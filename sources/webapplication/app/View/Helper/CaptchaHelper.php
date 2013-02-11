<?php
/*
CakePHP captcha Helper for Captcha Component :: Cakecaptcha

Description	:
This Helper is used with cakePHP captcha component to generate captchas.

*/
App::uses('AppHelper', 'View/Helper');
class CaptchaHelper extends AppHelper{

	public $helpers = array('Html', 'Form');
    
	private $captchaerror;	
	
    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
    	$this->captchaerror = isset($view->viewVars['captchaerror']) ? $view->viewVars['captchaerror'] : false;
	}

	public function input($controller = null){
		if(is_null($controller)) { 
            $controller = $this->params['controller']; 
        } 
        $output = $this->writeCaptcha($controller);
		return $output;
	}
    
	protected function writeCaptcha($controller){
	    $model = Inflector::classify($controller);
        $error = $this->captchaerror ? 'error': '';
		$out = '<div class="control-group required '.$error.'">';
        $out .= $this->Html->image($this->Html->url(array('controller' => $controller, 'action' => 'captcha'), true), array('id' => 'cakecaptcha'));
		$out .= "<br/>";
		
        $out .= '<a href="#" onclick="document.getElementById(\'cakecaptcha\').src=\'' 
             . $this->Html->url(array('controller' => $controller, 'action' => 'captcha')) 
             . '?\'+Math.random(); document.getElementById(\'captcha-form\').focus();" id="change-image"> '
             .'Not readable?</a>';
		
		$out .= $this->Form->input('cakecaptcha', array('id ' => 'captcha-form',
                                                        'name' => 'data['.$model.'][captcha]',
                                                        'label' => '',
                                                        'div' => false,
                                                        'class' => 'input-xlarge'
        ));
	   if($this->captchaerror) {
    	    $out .= "<span class='help-inline'>".$this->captchaerror."</span>";
       }
       $out .= "</div>";
       return $out;
	}
}
?>