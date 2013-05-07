<?php
App::uses('Goal', 'Model');

/**
 * Goal Test Case
 *
 * @property Goal $Goal
 */
class GoalTest extends CakeTestCase {
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
            'app.goal',
            'app.user'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Goal = ClassRegistry::init('Goal');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Goal);
        
        parent::tearDown();
    }

    public function testEmpty() {
    }

    public function _testGetGoals() {
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        $goals = $this->Goal->getCurrent($user_id);
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe8',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 9',
                                'comment' => 'Goal 9 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => date("Y-m-d"),
                                'todate' => date("Y-m-d"),
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => '0',
                                'deleted' => '0'
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        // With dates, empty results
        $goals = $this->Goal->getCurrent($user_id, '2013-01-01', '2013-01-11');
        $expected = array();
        $this->assertEqual($goals, $expected);
        // With dates, not empty results
        // $goals = $this->Goal->getGoals($user_id, '2013-02-01', '2013-02-30');
        // debug($goals);
        // $expected = array();
        // $this->assertEqual($goals, $expected);
    }

    public function testFindCurrent() {
        // die();
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('current', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe8',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 9',
                                'comment' => 'Goal 9 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => date("Y-m-d"),
                                'todate' => date("Y-m-d"),
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => '0',
                                'deleted' => '0'
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        
        // Second test
        $this->Goal->contain();
        $goals = $this->Goal->find('current', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodFrom' => '2013-01-01',
                        $this->Goal->alias . '.periodTo' => '2013-01-11'
                )
        ));
        $expected = array();
        $this->assertEqual($goals, $expected);
        // TODO: Test all other cases
    }

    public function testFindExpired() {
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('expired', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        // echo serialize($goals);
        $expected = unserialize('a:4:{i:0;a:1:{s:4:"Goal";a:9:{s:2:"id";s:36:"51223d84-365c-419b-8705-20a9b43b9fe0";s:5:"title";s:6:"Goal 1";s:7:"comment";s:362:"Goal 1 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.";s:8:"fromdate";s:10:"2013-02-01";s:6:"todate";s:10:"2013-02-10";s:8:"datedone";s:19:"2013-02-10 14:41:08";s:4:"done";s:1:"0";s:7:"deleted";s:1:"0";s:7:"user_id";s:36:"510ff517-ba68-4b27-86f5-2651b43b9fe0";}}i:1;a:1:{s:4:"Goal";a:9:{s:2:"id";s:36:"51223d84-365c-419b-8705-20a9b43b9fe1";s:5:"title";s:6:"Goal 2";s:7:"comment";s:362:"Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.";s:8:"fromdate";s:10:"2013-02-11";s:6:"todate";s:10:"2013-02-20";s:8:"datedone";s:19:"2013-02-11 14:41:08";s:4:"done";s:1:"0";s:7:"deleted";s:1:"0";s:7:"user_id";s:36:"510ff517-ba68-4b27-86f5-2651b43b9fe0";}}i:2;a:1:{s:4:"Goal";a:9:{s:2:"id";s:36:"51223d84-365c-419b-8705-20a9b43b9fe3";s:5:"title";s:6:"Goal 4";s:7:"comment";s:362:"Goal 4 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.";s:8:"fromdate";s:10:"2013-02-11";s:6:"todate";s:10:"2013-02-20";s:8:"datedone";s:19:"2013-02-11 14:41:08";s:4:"done";s:1:"0";s:7:"deleted";s:1:"1";s:7:"user_id";s:36:"510ff517-ba68-4b27-86f5-2651b43b9fe0";}}i:3;a:1:{s:4:"Goal";a:9:{s:2:"id";s:36:"51223d84-365c-419b-8705-20a9b43b9fe7";s:5:"title";s:6:"Goal 8";s:7:"comment";s:362:"Goal 8 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.";s:8:"fromdate";N;s:6:"todate";s:10:"2013-02-20";s:8:"datedone";N;s:4:"done";s:1:"0";s:7:"deleted";s:1:"0";s:7:"user_id";s:36:"510ff517-ba68-4b27-86f5-2651b43b9fe0";}}}');
        $this->assertEqual($goals, $expected);
        
        $this->Goal->contain();
        $goals = $this->Goal->find('expired', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodTo' => '2013-02-11'
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe0',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 1',
                                'comment' => 'Goal 1 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-01',
                                'todate' => '2013-02-10',
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 0,
                                'deleted' => 0
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
    }

    public function testFindClosed() {
        // die();
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('closed', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9f12',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 12',
                                'comment' => 'Goal 12 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => date("Y-m-d", strtotime("+1 month")),
                                'todate' => date("Y-m-d", strtotime("+2 month")),
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                ),
                1 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe2',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 3',
                                'comment' => 'Goal 3 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-11',
                                'todate' => '2013-02-20',
                                'datedone' => '2013-02-11 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                ),
                2 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe4',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 5',
                                'comment' => 'Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-01',
                                'todate' => '2013-02-20',
                                'datedone' => '2013-02-11 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        
        // Second test
        $this->Goal->contain();
        $goals = $this->Goal->find('closed', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodFrom' => '2013-01-01',
                        $this->Goal->alias . '.periodTo' => '2013-01-11'
                )
        ));
        $expected = array();
        $this->assertEqual($goals, $expected);
        //
        $this->Goal->contain();
        $goals = $this->Goal->find('closed', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodFrom' => '2013-02-05',
                        $this->Goal->alias . '.periodTo' => '2013-02-15'
                )
        ));
        $expected = array(
                array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe2',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 3',
                                'comment' => 'Goal 3 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-11',
                                'todate' => '2013-02-20',
                                'datedone' => '2013-02-11 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                ),
                array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe4',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 5',
                                'comment' => 'Goal 2 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-01',
                                'todate' => '2013-02-20',
                                'datedone' => '2013-02-11 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                )
        );
        $this->assertEqual($goals, $expected);
    }

    public function testFindFuture() {
        // die();
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('future', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9f10',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 10',
                                'comment' => 'Goal 10 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2043-02-01',
                                'todate' => '2043-02-10',
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 0,
                                'deleted' => 0
                        )
                ),
                1 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9f11',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 11',
                                'comment' => 'Goal 11 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => date("Y-m-d", strtotime("+1 month")),
                                'todate' => date("Y-m-d", strtotime("+2 month")),
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 0,
                                'deleted' => 0
                        )
                ),
                2 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9f12',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 12',
                                'comment' => 'Goal 12 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => date("Y-m-d", strtotime("+1 month")),
                                'todate' => date("Y-m-d", strtotime("+2 month")),
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 1,
                                'deleted' => 0
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        
        // Second test
        $this->Goal->contain();
        $goals = $this->Goal->find('future', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodFrom' => '2043-01-01'
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9f10',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 10',
                                'comment' => 'Goal 10 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2043-02-01',
                                'todate' => '2043-02-10',
                                'datedone' => '2013-02-10 14:41:08',
                                'done' => 0,
                                'deleted' => 0
                        )
                )
        );
        $this->assertEqual($goals, $expected);
        // Third test
        $this->Goal->contain();
        $goals = $this->Goal->find('future', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id,
                        $this->Goal->alias . '.periodFrom' => '2045-01-01'
                )
        ));
        $expected = array();
        $this->assertEqual($goals, $expected);
    }

    public function testFindPlanned() {
        // die();
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        $user_id1 = '510ff8c2-2470-4ded-860a-274db43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('planned', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe6',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 7',
                                'comment' => 'Goal 7 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => null,
                                'todate' => null,
                                'datedone' => null,
                                'done' => 0,
                                'deleted' => 0
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        
        // Second test
        $this->Goal->contain();
        $goals = $this->Goal->find('planned', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id1
                )
        ));
        $expected = array();
        $this->assertEqual($goals, $expected);
    }

    public function testFindDeleted() {
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        $user_id1 = '510ff8c2-2470-4ded-860a-274db43b9fe0';
        
        $this->Goal->contain();
        $goals = $this->Goal->find('deleted', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id
                )
        ));
        $expected = array(
                0 => array(
                        $this->Goal->alias => array(
                                'id' => '51223d84-365c-419b-8705-20a9b43b9fe3',
                                'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                                'title' => 'Goal 4',
                                'comment' => 'Goal 4 Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                                'fromdate' => '2013-02-11',
                                'todate' => '2013-02-20',
                                'datedone' => '2013-02-11 14:41:08',
                                'done' => 0,
                                'deleted' => 1
                        )
                )
        );
        // debug($goals);
        $this->assertEqual($goals, $expected);
        
        // Second test
        $this->Goal->contain();
        $goals = $this->Goal->find('deleted', array(
                'conditions' => array(
                        $this->Goal->alias . '.user_id' => $user_id1
                )
        ));
        $expected = array();
        $this->assertEqual($goals, $expected);
    }
}
