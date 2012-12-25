<?php
/*
CakePHP captcha Component :: Cakecaptcha
Website		:	http://www.designaeon.com
Description	:
This Component is used to generate captchas in cakePHP.

*/
App::uses('Component', 'Controller');

class CaptchaComponent extends Component {
   
    private $controller = null;
	
    public $components = array('Session', 'RequestHandler');
	
	public $width  = 284;

    /** Height of the image */
    public $height = 70;

    /**
     * Path for resource files (fonts, words, etc.)
     *
     * "resources" by default. For security reasons, is better move this
     * directory to another location outise the web server
     *
     */
	public $pathType=1; 
	public $resourcesPath = 'cakecaptcha/resources';

    /** Min word length (for non-dictionary random text generation) */
    public $minWordLength = 5;

    /**
     * Max word length (for non-dictionary random text generation)
     * 
     * Used for dictionary words indicating the word-length
     * for font-size modification purposes
     */
    public $maxWordLength = 6;

    /** Sessionname to store the original text */
    public $session_var = 'captcha';
    
    /** Background color in RGB-array */
    public $backgroundColor = array(255, 255, 255);

    /** Foreground colors in RGB-array */
    public $colors = array(
        array(27,78,181), // blue
        array(22,163,35), // green
        array(214,36,7),  // red
    );

    /** Shadow color in RGB-array or null */
    public $shadowColor = null; //array(0, 0, 0);

    /**
     * Font configuration
     *
     * - font: TTF file
     * - spacing: relative pixel space between character
     * - minSize: min font size
     * - maxSize: max font size
     */
    public $fonts = array(
        'Antykwa'  => array('spacing' => -3, 'minSize' => 27, 'maxSize' => 30, 'font' => 'AntykwaBold.ttf'),
        'Candice'  => array('spacing' =>-1.5,'minSize' => 28, 'maxSize' => 31, 'font' => 'Candice.ttf'),
        'DingDong' => array('spacing' => -2, 'minSize' => 24, 'maxSize' => 30, 'font' => 'Ding-DongDaddyO.ttf'),
        'Duality'  => array('spacing' => -2, 'minSize' => 30, 'maxSize' => 38, 'font' => 'Duality.ttf'),
        'Jura'     => array('spacing' => -2, 'minSize' => 28, 'maxSize' => 32, 'font' => 'Jura.ttf'),
        'StayPuft' => array('spacing' =>-1.5,'minSize' => 28, 'maxSize' => 32, 'font' => 'StayPuft.ttf'),
        'Times'    => array('spacing' => -2, 'minSize' => 28, 'maxSize' => 34, 'font' => 'TimesNewRomanBold.ttf'),
        'VeraSans' => array('spacing' => -1, 'minSize' => 20, 'maxSize' => 28, 'font' => 'VeraSansBold.ttf'),
    );

    /** Wave configuracion in X and Y axes */
    public $Yperiod    = 12;
    public $Yamplitude = 14;
    public $Xperiod    = 11;
    public $Xamplitude = 5;

    /** letter rotation clockwise */
    public $maxRotation = 8;

    /**
     * Internal image size factor (for better image quality)
     * 1: low, 2: medium, 3: high
     */
    public $scale = 2;

    /** 
     * Blur effect for better image quality (but slower image processing).
     * Better image results with scale=3
     */
    public $blur = false;

    /** Debug? */
    public $debug = false;
    
    /** Image format: jpeg or png */
    public $imageFormat = 'jpeg';

    /** GD image */
    public $im;

	 
    public function initialize(Controller $controller, $config = null){
        $this->controller = $controller;	
		$this->resourcesPath = $this->webroot.'cakecaptcha/resources';	
	}
    	
	public function getCaptcha(){
		$this->controller->autoRender = false; 
        $this->CreateImage();
        exit;
       
	}
    
	public function configCaptcha($config){
	if(is_array($config)){
		foreach($config as $key => $value){
			switch($key){
				case 'blur' :
					if($value==true || $value==false){
						$this->blur=$value;						
					}					
					break;	
				case 'quality' :
					if($value==1 || $value==2 || $value==3){
						$this->scale=$value;
					}					
					break;
				case 'format' :
					if($value=='jpeg' || $value=='png'){
						$this->imageFormat=$value;
					}
					break;
				case 'minLength' :
					if(is_int($value)){
						$this->minWordLength=$value;
					}
					break;
				case 'maxLenght' :
					if(is_int($value)){
						$this->maxWordLength=$value;
					}
					break;
				case 'width' :
					if(is_int($value)){
						$this->width=$value;
					}
					break;
				case 'height' :	
					if(is_int($value)){
						$this->height=$value;
					}
					break;
				case 'background' :
					if(is_array($value)){
						if(count($value)==3){
							foreach($value as $k=>$v){
								$this->backgroundColor[$k]=$v;
								
							}							
						}
					}
					break;
				case 'color' :
					if(is_array($value)){
						if(in_array(true,$value,true)){
							$this->colors=array();
							foreach($value as $k=>$v){
								if(is_array($v) && count($v)==3){
								if(gettype($v[0])=='integer' & gettype($v[1])=='integer' & gettype($v[2])=='integer')
									$this->colors[]=$v;
								}
							}
						}
						else{
							foreach($value as $k=>$v){
								if(is_array($v) && count($v)==3){
									if(gettype($v[0])=='integer' & gettype($v[1])=='integer' & gettype($v[2])=='integer')
										$this->colors[]=$v;
								}
							}							
						}
					}
					break;
				case 'pathType' :
					if($value==1){
						$this->resourcesPath=$this->controller->webroot.'cakecaptcha/resources';
					}
					else if($value=2){
						$this->resourcesPath=realpath('.').'/cakecaptcha/resources';
					}
					else{
					}
			}
		}		
	}	
	}
    
	public function validateCaptcha($model = "cakecaptcha"){
		$model = $this->controller->modelClass;
		if(isset($this->controller->data[$model]['captcha']) && !empty($this->controller->data[$model]['captcha'])){
			if($this->Session->check("cakecaptcha.".$this->session_var)){
				if($this->Session->read("cakecaptcha.".$this->session_var) == $this->controller->data[$model]['captcha']){
					$this->Session->delete("cakecaptch.".$this->session_var);
					$this->controller->set('captchaerror', false);	
					return true;
				} else {
					$this->controller->set('captchaerror', __d('captcha', 'Wrong Captcha Entered'));	
					return false;
				}				
			}
		} else {
			$this->controller->set('captchaerror',__d('captcha', 'You Must Enter captcha Code'));	
			return false;
		}			
	}	 
    
    //check captcha all method
	public function validateGetCaptcha($model = "cakecaptcha"){
	//debug($this->controller->params['url']['data'][$model]);
		if(isset($this->controller->params['url']['data'][$model]['captcha']) ){
			if(empty($this->controller->params['url']['data'][$model]['captcha'])){ 
				$this->controller->set('captchaerror','You Must Enter Captcha Code');	
				return false;
			}
			if($this->Session->check("cakecaptcha.".$this->session_var)){
				if($this->Session->read("cakecaptcha.".$this->session_var)==$this->controller->params['url']['data'][$model]['captcha']){
					$this->Session->delete("cakecaptch.".$this->session_var);
					$this->controller->set('captchaerror',false);	
					return true;
				}
				else{
					$this->Session->setFlash("Wrong captcha");
					//debug($this->controller);
					$this->controller->set('captchaerror','Wrong Captcha Entered');	
					return false;
				}
			}
		}
		else{
			$this->controller->set('captchaerror',false);	
			return false;
		}
	}

    //public function __construct($config = array()) {
//    }


    protected function CreateImage() {
        $ini = microtime(true);
        
        /** Initialization */
        $this->ImageAllocate();
        
        /** Text insertion */
        $text = $this->GetCaptchaText();
        
        $fontcfg  = $this->fonts[array_rand($this->fonts)];
        $this->WriteText($text, $fontcfg);

      //  $_SESSION[$this->session_var] = $text;
	   $this->Session->write('cakecaptcha.'.$this->session_var, $text);

        /** Transformations */
        $this->WaveImage();
        if ($this->blur && function_exists('imagefilter')) {
            imagefilter($this->im, IMG_FILTER_GAUSSIAN_BLUR);
        }
        $this->ReduceImage();


        if ($this->debug) {
            imagestring($this->im, 1, 1, $this->height-8,
                "$text {$fontcfg['font']} ".round((microtime(true)-$ini)*1000)."ms",
                $this->GdFgColor
            );
        }


        /** Output */
        $this->WriteImage();
        $this->Cleanup();
        
    }
    /**
     * Creates the image resources
     */
    protected function ImageAllocate() {
        // Cleanup
        if (!empty($this->im)) {
            imagedestroy($this->im);
        }

        $this->im = imagecreatetruecolor($this->width*$this->scale, $this->height*$this->scale);

        // Background color
        $this->GdBgColor = imagecolorallocate($this->im,
            $this->backgroundColor[0],
            $this->backgroundColor[1],
            $this->backgroundColor[2]
        );
        imagefilledrectangle($this->im, 0, 0, $this->width*$this->scale, $this->height*$this->scale, $this->GdBgColor);

        // Foreground color
        $color           = $this->colors[mt_rand(0, sizeof($this->colors)-1)];
        $this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);

        // Shadow color
        if (!empty($this->shadowColor) && is_array($this->shadowColor) && sizeof($this->shadowColor) >= 3) {
            $this->GdShadowColor = imagecolorallocate($this->im,
                $this->shadowColor[0],
                $this->shadowColor[1],
                $this->shadowColor[2]
            );
        }
    }
    /**
     * Text generation
     *
     * @return string Text
     */
    protected function GetCaptchaText() {
        return $this->GetRandomCaptchaText();
    }
    /**
     * Random text generation
     *
     * @return string Text
     */
    protected function GetRandomCaptchaText($length = null) {
        if (empty($length)) {
            $length = rand($this->minWordLength, $this->maxWordLength);
        }

        //$words  = "abcdefghijlmnopqrstvwyz";
        $words  = "12345678904652341552634845";
        $vocals = "15790";

        $text  = "";
        $vocal = rand(0, 1);
        for ($i=0; $i<$length; $i++) {
            if ($vocal) {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            } else {
                $text .= substr($words, mt_rand(0, 22), 1);
            }
            $vocal = !$vocal;
        }
        return $text;
    }

    /**
     * Text insertion
     */
    protected function WriteText($text, $fontcfg = array()) {
        if (empty($fontcfg)) {
            // Select the font configuration
            $fontcfg  = $this->fonts[array_rand($this->fonts)];
        }

        // Full path of font file
        $fontfile = $this->resourcesPath.'/fonts/'.$fontcfg['font'];


        /** Increase font-size for shortest words: 9% for each glyp missing */
        $lettersMissing = $this->maxWordLength-strlen($text);
        $fontSizefactor = 1+($lettersMissing*0.09);

        // Text generation (char by char)
        $x      = 20*$this->scale;
        $y      = round(($this->height*27/40)*$this->scale);
        $length = strlen($text);
        for ($i=0; $i<$length; $i++) {
            $degree   = rand($this->maxRotation*-1, $this->maxRotation);
            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize'])*$this->scale*$fontSizefactor;
            $letter   = substr($text, $i, 1);

            if ($this->shadowColor) {
                $coords = imagettftext($this->im, $fontsize, $degree,
                    $x+$this->scale, $y+$this->scale,
                    $this->GdShadowColor, $fontfile, $letter);
            }
            $coords = imagettftext($this->im, $fontsize, $degree,
                $x, $y,
                $this->GdFgColor,$fontfile, $letter);
            $x += ($coords[2]-$x) + ($fontcfg['spacing']*$this->scale);
        }
    }

    /**
     * Wave filter
     */
    protected function WaveImage() {
        // X-axis wave generation
        $xp = $this->scale*$this->Xperiod*rand(1,3);
        $k = rand(0, 100);
        for ($i = 0; $i < ($this->width*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                $i-1, sin($k+$i/$xp) * ($this->scale*$this->Xamplitude),
                $i, 0, 1, $this->height*$this->scale);
        }

        // Y-axis wave generation
        $k = rand(0, 100);
        $yp = $this->scale*$this->Yperiod*rand(1,2);
        for ($i = 0; $i < ($this->height*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                sin($k+$i/$yp) * ($this->scale*$this->Yamplitude), $i-1,
                0, $i, $this->width*$this->scale, 1);
        }
    }


    /**
     * Reduce the image to the final size
     */
    protected function ReduceImage() {
        // Reduzco el tamaño de la imagen
        $imResampled = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($imResampled, $this->im,
            0, 0, 0, 0,
            $this->width, $this->height,
            $this->width*$this->scale, $this->height*$this->scale
        );
        imagedestroy($this->im);
        $this->im = $imResampled;
    }

    /**
     * File generation
     */
    protected function WriteImage() {
        if ($this->imageFormat == 'png' && function_exists('imagepng')) {
            header("Content-type: image/png");
            imagepng($this->im);
        } else {
            header('Content-Type: image/jpeg');
            imagejpeg($this->im, null, 80);
        }
    }
    /**
     * Cleanup
     */
    protected function Cleanup() {
        imagedestroy($this->im);
    }
   
}
?>