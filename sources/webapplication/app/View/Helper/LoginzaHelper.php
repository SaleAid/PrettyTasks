<?php
App::uses('AppHelper', 'View/Helper');
class LoginzaHelper extends AppHelper {

    public function getCssUrl() {
        return 'loginza/widget_style.css';
    }
    public function getJs(){
        return 'http://loginza.ru/js/widget.js';
    }

    public function ico($provider) {
        if (! $provider) {
            return '';
        }
        return "<span class=\"providers_ico_sprite {$provider}_ico\">&nbsp;</span>";
    }

    public function logo($provider) {
        if (! $provider) {
            return '';
        }
        return "<span class=\"providers_sprite {$provider}\">&nbsp;</span>";
    }
    
    public function buttonWidget($token_url){
       $str = '<a href="http://loginza.ru/api/widget?token_url='.$token_url;
       $str .=' &providers_set=vkontakte,facebook,twitter,google';
       $str .='&lang='.Configure::read('Config.langURL');
       $str .='" class="loginza">';
       $str .= '<img src="http://loginza.ru/img/sign_in_button_gray.gif" alt="Войти через loginza"/>';
       $str .= '</a>';
       return $str;
    }
    
    public function iframeWidget($token_url){
        $str = ' <iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url='.$token_url;
        $str .='&lang='.Configure::read('Config.langURL');
        $str .=' &providers_set=vkontakte,facebook,twitter,google"'; 
        $str .=' style="width:330px;height:244px;" scrolling="no" frameborder="no">';
        $str .=' </iframe>';
        return $str;
    }
    public function iconsWidget($token_url, $provider){
        $str = '<a href="https://loginza.ru/api/widget?provider='.$provider.'&token_url='.$token_url;
        $str .='&providers_set=vkontakte,facebook,twitter,google'; 
        $str .='&lang='.Configure::read('Config.langURL');
        $str .='" class="loginza">';
        $str .='<img src="http://loginza.ru/img/providers/'.$provider.'.png" alt="'.$provider.'" title="'.$provider.'">';
        $str .='</a>';
        return $str;
    }
}