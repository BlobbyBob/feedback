<?php

class Feedback_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('FeedbackSeeder');
        $CI->seeder->call('RoutesSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Feedback');
    }

    public function testOverview()
    {
        $this->assertIsArray($this->obj->overview(), 'Feedback::overview()');
        $this->assertCount(2, $this->obj->overview(), 'Feedback::overview()');
        $this->assertEquals(14, $this->obj->overview()[0]->q_answered, 'Feedback::overview()');
        $this->assertEquals(1, $this->obj->overview()[1]->count, 'Feedback::overview()');
    }

    public function testGet()
    {

        $this->assertCount(count(FeedbackSeeder::getData()), $this->obj->get(), 'Feedback::get() should return everything');

        $count = 0;
        $id = null;
        $route = null;
        foreach (FeedbackSeeder::getData() as $data) {
            if (is_null($id)) {
                $id = $data['id'];
                $route = $data['route'];
            }
            if ($route == $data['route']) $count++;
        }

        $this->assertCount($count, $this->obj->get($route), 'Feedback::get('.$route.') should return all matching elements');

        $feedback = $this->obj->get($route)[0];
        foreach (FeedbackSeeder::getData()[0] as $key => $val) {
            $this->assertEquals($val, $feedback->$key, 'Feedback::get('.$route.') should return all values');
        }

    }

    public function testGetFeedback()
    {

        $this->assertIsArray($this->obj->get_feedback(), 'Feedback::get_feedback()');
        $this->assertIsArray($this->obj->get_feedback(-1), 'Feedback::get_feedback()');
        $this->assertCount(0, $this->obj->get_feedback(-1), 'Feedback::get_feedback()');

        $count = 0;
        $id = null;
        $route = null;
        foreach (FeedbackSeeder::getData() as $data) {
            if (is_null($id)) {
                $id = $data['id'];
                $route = $data['route'];
            }
            if ($route == $data['route']) $count++;
        }

        $this->assertCount($count, $this->obj->get_feedback($route), 'Feedback::get_feedback('.$route.') should return all matching data');
        $this->assertIsObject($this->obj->get_feedback($route)[0], 'Feedback::get_feedback('.$route.') should return array of objects');

    }

    /**
     * @depends testGet
     * @depends testGetFeedback
     * @depends testOverview
     */
    public function testStore()
    {

        $feedback = new Models\Feedback();
        $feedback->id = 100;
        $feedback->route = 100;
        $feedback->author_id = md5('');
        $feedback->questions = 3;
        $feedback->total = 5;
        $feedback->data = json_decode('{"11":"abc","12":"def","13":"100","14":"4","15":"1"}');

        $this->obj->store($feedback);

        $this->assertCount(1, $this->obj->get(100), 'Feedback::store()');
        $this->assertContains($feedback->data, $this->obj->get_feedback(100), 'Feedback::store()', false, false);

        $feedback = new Models\Feedback();
        $feedback->id = 101;
        $feedback->route = 101;
        $feedback->author_id = md5('');
        $feedback->date = '2019-01-10 00:00:00';
        $feedback->questions = 3;
        $feedback->total = 5;
        $feedback->data = json_decode('{"11":"abc","12":"def","13":"100","14":"4","15":"1"}');

        $this->obj->store($feedback);

        $this->assertCount(1, $this->obj->get(101), 'Feedback::store()');
        $this->assertContains($feedback->data, $this->obj->get_feedback(101), 'Feedback::store()', false, false);

    }
}
