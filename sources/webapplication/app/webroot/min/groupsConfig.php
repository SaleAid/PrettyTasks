<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/
$ver = '1.0.5';
return array(
     
     'journal.js.v='.$ver => array('//js/main.js', '//js/journal.js', '//js/print.js'),
     'journal.css.v='.$ver => array('//css/main.css', '//css/journal.css', '//css/print.css'),
     
     'tasks.js.v='.$ver => array(
                                '//js/jquery-ui-i18n.min.js',
                                '//js/jquery.inline-confirmation.js',
                                '//js/jquery.timepicker-1.2.2.min.js',
                                '//js/jquery.ba-hashchange.min.js',
                                '//js/jquery.jeditable.mini.js', 
                                '//js/jquery.jgrowl.min.js', 
                                '//js/print.js', 
                                '//js/main.js', 
                                '//js/tasks.js'
                            ),
     'tasks.css.v='.$ver => array(
                                '//css/jquery.timepicker-1.2.2.css',
                                '//css/jquery.jgrowl.css',
                                '//css/ui-lightness/jquery-ui-1.8.18.custom.css',
                                '//css/main.css', 
                                '//css/tasks.css', 
                                '//css/print.css'
                            ),
     'start.js.v='.$ver => array('//js/main.js'),
     
     'pages.css.v='.$ver => array('//css/main.css', '//css/pages.css'),
     
     
    // 'css' => array('//css/file1.css', '//css/file2.css'),
    
);
//http://stackoverflow.com/questions/470880/rewriterule-checking-file-in-rewriten-file-path-exists
//change Minify.php line 586