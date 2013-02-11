<?php
class AllTest extends CakeTestSuite {

    public static function suite() {
        $suite = new CakeTestSuite('All tests (with plugins)');
        //All application tests
        $suite->addTestDirectory(TESTS . 'Case');
        //All plugin tests 
        //$PluginPath = CakePlugin::path('Plugin') . DS . 'Test' . DS . 'Case' . DS;
        //$suite->addTestDirectory($PluginPath . 'Controller' . DS);
        //$suite->addTestDirectory($PluginPath . 'Model' . DS);
        //$suite->addTestDirectory($PluginPath . 'View' . DS);
        
        //Return test suite
        return $suite;
    }
}
