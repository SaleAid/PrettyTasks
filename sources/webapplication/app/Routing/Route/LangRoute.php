<?php

class LangRoute extends CakeRoute {
    
    static private $lang = null;

    public function match($url) {
        //debug(LangRoute::$lang);
        if (LangRoute::$lang) {
            $url['lang'] = LangRoute::$lang;
        }
        //print_r($url);
        return parent::match($url);
    }

    public function parse($url) {
        //print_r($url);
        $route = parent::parse($url);
        //print_r($route);
        if ($route && is_array($route) && isset($route['lang'])) {
            $languages = Configure::read('Config.langListURL');
            if (isset($languages[$route['lang']])) {
                LangRoute::$lang = $route['lang'];
            }
        }
        //print_r(LangRoute::$lang);
        return $route;
    }

}