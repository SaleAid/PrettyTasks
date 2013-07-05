<?php

class LangRoute extends CakeRoute {
    
    static private $lang = null;

    public function match($url) {
        //debug(LangRoute::$lang);
        if (LangRoute::$lang && !isset($url['lang'])) {
           if(empty($url['plugin'])){
                $url['lang'] = LangRoute::$lang;
           } 
        }
        //print_r($url);
        return parent::match($url);
    }

    public function parse($url) {
        $route = parent::parse($url);
        if ($route && is_array($route) && isset($route['lang'])) {
            $languages = Configure::read('Config.lang.available');
            if (isset($languages[$route['lang']])) {
                LangRoute::$lang = $route['lang'];
            }
        }
        //print_r($route);
        return $route;
    }
}