<?php
App::uses('AppHelper', 'View/Helper');

class LoginzaHelper extends AppHelper {
    
    public function getCssUrl(){
        return 'loginza/widget_style.css?v1.0.9';
    }
    
    public function ico($provider) {
        if(!$provider){
            return '';
        }
        return "<span class=\"providers_ico_sprite {$provider}_ico\">&nbsp;</span>";    
    }
    
    public function logo($provider) {
        return "<span class=\"providers_sprite {$provider}\">&nbsp;</span>";    
    }
    
}