<?php
class AllAppTest extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All application tests');
        $suite->addTestDirectory(TESTS . 'Case' );
        return $suite;
    }
}