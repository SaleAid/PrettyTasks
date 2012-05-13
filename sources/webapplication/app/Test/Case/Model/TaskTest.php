<?php
App::uses('Task', 'Model');
App::uses('CakeTime', 'Utility');
/**
 * Task Test Case
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
        'app.day'
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
        //Test false
        $task_id = 1;
        $user_id = 2;
        $task = $this->Task->isOwner($task_id, $user_id);
        $this->assertFalse($task);
        //Test false
        $task_id = 7;
        $user_id = 2;
        $task = $this->Task->isOwner($task_id, $user_id);
        $this->assertFalse($task);
        //Test true
        $task_id = 1;
        $user_id = 1;
        $expected['Task'] = array(
            'id' => 1, 
            'user_id' => 1, 
            'title' => 'Lorem ipsum dolor sit amet', 
            'date' => '2012-05-13', 
            'time' => '23:38:38', 
            'timeend' => '23:38:38', 
            'datedone' => '2012-05-13 23:38:38', 
            'order' => 1, 
            'done' => 1, 
            'future' => 1, 
            'repeatid' => 1, 
            'transfer' => 1, 
            'priority' => 1, 
            'day_id' => 1, 
            'dateremind' => '2012-05-13', 
            'created' => '2012-05-13 23:38:38', 
            'modified' => '2012-05-13 23:38:38'
        );
        $task = $this->Task->isOwner($task_id, $user_id);
        $this->assertEqual($task, $expected);
        //Test true
        $task_id = 3;
        $user_id = 2;
        $expected['Task'] = array(
            'id' => 3, 
            'user_id' => 2, 
            'title' => 'Lorem ipsum dolor sit amet', 
            'date' => '2012-05-13', 
            'time' => '23:38:38', 
            'timeend' => '23:38:38', 
            'datedone' => '2012-05-13 23:38:38', 
            'order' => 1, 
            'done' => 1, 
            'future' => 1, 
            'repeatid' => 1, 
            'transfer' => 1, 
            'priority' => 1, 
            'day_id' => 1, 
            'dateremind' => '2012-05-13', 
            'created' => '2012-05-13 23:38:38', 
            'modified' => '2012-05-13 23:38:38'
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
        $task1 = $this->Task->get(1);
        $this->assertEqual($task1['Task']['done'], 1);
        $this->Task->setDone(0)->save();
        $this->assertEqual($this->Task->data['Task']['done'], 0);
        $this->Task->get(1);
        $this->assertEqual($this->Task->data['Task']['done'], 0);
        $this->Task->setDone(1);
        $this->assertEqual($this->Task->data['Task']['done'], 1);
        $this->Task->save();
        $task1 = $this->Task->get(1);
        $this->assertEqual($task1['Task']['done'], 1);
        $task0 = $this->Task->get(4);
        $this->assertEqual($task0['Task']['done'], 0);
        $this->Task->setDone(0);
        $this->assertEqual($this->Task->data['Task']['done'], 0);
        $this->Task->setDone(1);
        $this->assertEqual($this->Task->data['Task']['done'], 1);
         //$this->assertEqual($task, $expected);
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
