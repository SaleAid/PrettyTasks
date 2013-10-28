<?php
App::import('Vendor', 'POParser/POParser');

/**
 */
class JsI18nTask extends Shell {
    protected $_templateJsPath = "/js/pos/%s/%s.js";

    public function execute() {
        $availableLocales = Configure::read('Config.lang.available');
        $domains = array();
        foreach ( $availableLocales as $value ) {
            $locale = $value['lang'];
            if ($handle = opendir(APP . "Locale/{$locale}/LC_MESSAGES/")) {
                while ( false !== ($entry = readdir($handle)) ) {
                    if ($entry != "." && $entry != "..") {
                        $pi = pathinfo($entry);
                        if ($pi['extension'] === 'po') {
                            $domains[] = $pi['filename'];
                        }
                    }
                }
                closedir($handle);
            }
            foreach ( $domains as $domain ) {
                $this->_parsePO($domain, $locale);
            }
        }
    }

    protected function _parsePO($domain, $locale, $jsFile = '') {
        $filename = APP . "Locale/{$locale}/LC_MESSAGES/{$domain}.po";
        if (file_exists($filename)) {
            $parser = new POParser();
            $result = $parser->parse($filename);
            $translations = array();
            foreach ( $result[1] as $key => $value ) {
                if (isset($value['msgid']) && isset($value['msgstr']) && $value['msgid']) {
                    $translations[$value['msgid']] = $value['msgstr'];
                }
            }
            
            $content = "var translations = (translations === null || translations === undefined)?{}:translations;\n";
            $content .= "translations.{$locale} = (translations.{$locale} === null || translations.{$locale} === undefined)?{}:translations.{$locale};\n";
            $content .= "translations.{$locale}.{$domain} = " . json_encode($translations) . ";";
            if (! $jsFile) {
                $jsFile = APP . WEBROOT_DIR . sprintf($this->_templateJsPath, $locale, $domain);
            }
            if (! file_exists($jsFile) || is_writable($jsFile)) {
                if (! file_exists(dirname($jsFile)))
                    mkdir(dirname($jsFile), 0755, 1);
                $fp = fopen($jsFile, 'w');
                if (! $fp) {
                    $this->out('Cannot open file ' . $jsFile);
                    die(2);
                }
                fwrite($fp, $content);
                fclose($fp);
                $this->out('all good for file ' . $jsFile);
                return 0;
            }
        }
        return 1;
    }
}
