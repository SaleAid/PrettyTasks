<?php
App::uses('Task', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * Task Test Case
 *
 * @property Task $Task
 *          
 */
class TaskTestCase extends CakeTestCase {
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
            'app.task',
            'app.user',
            'app.account',
            'app.day',
            'app.tag',
            'app.tagged'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Task = ClassRegistry::init('Task');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Task);
        parent::tearDown();
    }

    /**
     * testIsOwner method
     *
     * @return void
     */
    public function testIsOwner() {
        // die();
        // Test false
        $task_id = '51228719-0bb4-446c-8319-3259b43b9fe0';
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe1';
        $task = $this->Task->isOwner($task_id, $user_id);
        
        $this->assertFalse($task);
        // Test false
        $task_id = '51228719-0bb4-446c-8319-3259b43b9fe0';
        $user_id = '510ff517-ba68-4b27-86f5-2651b43b9fe0';
        $task = $this->Task->isOwner($task_id, $user_id);
        // debug($task);
        $expected = array(
                'Task' => array(
                        'id' => '51228719-0bb4-446c-8319-3259b43b9fe0',
                        'user_id' => '510ff517-ba68-4b27-86f5-2651b43b9fe0',
                        'title' => 'Lorem ipsum dolor sit amet',
                        'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                        'date' => '2013-02-18',
                        'time' => '19:55:05',
                        'timeend' => '19:55:05',
                        'datedone' => '2013-02-18 19:55:05',
                        'order' => '1',
                        'done' => '1',
                        'future' => '1',
                        'deleted' => '1',
                        'repeatid' => '1',
                        'transfer' => '1',
                        'priority' => '1',
                        'day_id' => 'Lorem ipsum dolor sit amet',
                        'dateremind' => '2013-02-18',
                        'created' => '2013-02-18 19:55:05',
                        'modified' => '2013-02-18 19:55:05',
                        'tags' => ''
                ),
                'Tag' => array()
        );
        $task = $this->Task->isOwner($task_id, $user_id);
        $this->assertEqual($task, $expected);
    }

    /**
     * testGetLastOrderByUserIdAndDate method
     *
     * @return void
     */
    public function testGetLastOrderByUserIdAndDate() {
    }

    /**
     * testGetAllForDate method
     *
     * @return void
     */
    public function testGetAllForDate() {
    }

    /**
     * testSetEdit method
     *
     * @return void
     */
    public function testSetEdit() {
    }

    /**
     * testSetTime method
     *
     * @return void
     */
    public function testSetTime() {
    }

    /**
     * testSetDate method
     *
     * @return void
     */
    public function testSetDate() {
    }

    /**
     * testSetOrder method
     *
     * @return void
     */
    public function testSetOrder() {
    }

    /**
     * testSetFuture method
     *
     * @return void
     */
    public function testSetFuture() {
    }

    /**
     * testSetTitle method
     *
     * @return void
     */
    public function testSetTitle() {
    }

    /**
     * testSetDone method
     *
     * @return void
     */
    public function testSetDone() {
        /*
         * $task1 = $this->Task->get(1); $this->assertEqual($task1['Task']['done'], 1); $this->Task->setDone(0)->save(); $this->assertEqual($this->Task->data['Task']['done'], 0); $this->Task->get(1);
         * $this->assertEqual($this->Task->data['Task']['done'], 0); $this->Task->setDone(1); $this->assertEqual($this->Task->data['Task']['done'], 1); $this->Task->save(); $task1 =
         * $this->Task->get(1); $this->assertEqual($task1['Task']['done'], 1); $task0 = $this->Task->get(4); $this->assertEqual($task0['Task']['done'], 0); $this->Task->setDone(0);
         * $this->assertEqual($this->Task->data['Task']['done'], 0); $this->Task->setDone(1); $this->assertEqual($this->Task->data['Task']['done'], 1); //$this->assertEqual($task, $expected);
         */
    }

    /**
     * testGetAllExpired method
     *
     * @return void
     */
    public function testGetAllExpired() {
    }

    /**
     * testGetAllFuture method
     *
     * @return void
     */
    public function testGetAllFuture() {
    }

    /**
     * testGetDays method
     *
     * @return void
     */
    public function testGetDays() {
    }

    /**
     * testGetTasksForDay method
     *
     * @return void
     */
    public function testGetTasksForDay() {
    }

    /**
     * testDeleteDayFromConfig method
     *
     * @return void
     */
    public function testDeleteDayFromConfig() {
    }
}
