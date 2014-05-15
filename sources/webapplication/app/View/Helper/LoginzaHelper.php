<?php
App::uses('AppHelper', 'View/Helper');
class LoginzaHelper extends AppHelper {

    protected function _providers(){
        return implode(",", array_keys(Configure::read('loginza.provider')));
    }
    public function getCssUrl() {
        return 'sprite/widget_style.'.Configure::read('App.version').'.css';
    }
    public function getJs(){
        return 'http://loginza.ru/js/widget.js';
    }

    public function ico($provider) {
        if (! $provider) {
            return '';
        }
        if ($provider == 'local') {
            return "<span class=\"prettytasks\">&nbsp;</span>";
        }
        return "<span class=\"providers_ico_sprite {$provider}_ico\">&nbsp;</span>";
    }

    protected function providerTitle($provider){
        switch ($provider) {
            case 'local':
                return 'PrettyTasks';
                break;
            case 'google':
                return 'Google';
                break;
            case 'twitter':
                return 'Twitter';
                break;
            case 'facebook':
                return 'Facebook';
                break;
            case 'linkedin':
                return 'LinkedIn';
                break;
            case 'vkontakte':
                return 'ВКонтакте';
                break;
            default:
                return '';
                break;
        }
    }

    public function logo($provider) {
        if (! $provider) {
            return '';
        }
        $title = $this->providerTitle($provider);
        if ($provider == 'local') {
           return "<span class=\"prettytasks_logo\" alt=\"".$title."\" title=\"".$title."\">&nbsp;</span>";
        }
        return "<span class=\"providers_sprite {$provider}\" alt=\"".$title."\" title=\"".$title."\">&nbsp;</span>";
    }
    
    public function buttonWidget($token_url){
       $str =  '<a href="http://loginza.ru/api/widget?token_url='.urlencode($token_url);
       $str .= '&providers_set=' . $this->_providers();
       $str .= '&lang='.Configure::read('Config.langURL');
       $str .= '" class="loginza">';
       $str .= '<img src="http://loginza.ru/img/sign_in_button_gray.gif" alt="Войти через loginza"/>';
       $str .= '</a>';
       return $str;
    }
    
    public function iframeWidget($token_url){
        $str = ' <iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url='.urlencode($token_url);
        $str .= '&lang='.Configure::read('Config.langURL');
        $str .= '&providers_set=' . $this->_providers() . '"'; 
        $str .= ' style="width:330px;height:206px;" scrolling="no" frameborder="no">';
        $str .= '</iframe>';
        return $str;
    }
    public function iconsWidget($token_url, $provider){
        $str = '<a href="https://loginza.ru/api/widget?provider='.$provider.'&token_url='.urlencode($token_url);
        $str .='&providers_set=' . $this->_providers(); 
        $str .='&lang='.Configure::read('Config.langURL');
        $str .='" class="loginza">';
        $str .= $this->ico($provider);
        //$str .='<img src="http://loginza.ru/img/providers/'.$provider.'.png" alt="'.$provider.'" title="'.$provider.'">';
        $str .='</a>';
        return $str;
    }
    public function listIconWidget($token_url){
        $str = '';
        foreach(Configure::read('loginza.provider') as $key => $value){
            $str .= $this->iconsWidget($token_url, $key);
        }
        return $str;
    }
}