<?php

class Setters_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('SettersSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Setters');
    }

    public function testGetSetters()
    {

        $this->assertIsArray($this->obj->get_setters(), 'Setters::get_setters()');
        $this->assertCount(count(SettersSeeder::getData()), $this->obj->get_setters(), 'Setters::get_setters()');
        foreach (SettersSeeder::getData() as $data) {
            $setter = new Models\Setter();
            $setter->id = $data['id'];
            $setter->name = $data['name'];
            $this->assertContains($setter, $this->obj->get_setters(), 'Setters::get_setters()', false, false);
        }

    }

    public function testGetSetter()
    {

        $this->assertNull($this->obj->get_setter(-1), 'Setters:get_setter()');
        $this->assertNull($this->obj->get_setter('Non existent'), 'Setters:get_setter()');

        foreach (SettersSeeder::getData() as $data) {
            $setter = new Models\Setter();
            $setter->id = $data['id'];
            $setter->name = $data['name'];
            $this->assertEquals($setter, $this->obj->get_setter($setter->id), 'Setters:get_setter()');
            $this->assertEquals($setter, $this->obj->get_setter($setter->name), 'Setters:get_setter()');
        }

    }

    /**
     * @depends testGetSetter
     */
    public function testAddSetter()
    {

        $setter = new Models\Setter();
        $setter->id = -1;
        $setter->name = 'Person X';

        $this->assertFalse($this->obj->add_setter($setter), 'Setters::add_setter()');
        $setter->id = 2;
        $setter->name = 'Person Y';
        $this->assertFalse($this->obj->add_setter($setter), 'Setters::add_setter()');
        $setter->id = 100;
        $setter->name = 'Person Z';
        $this->assertTrue($this->obj->add_setter($setter), 'Setters::add_setter()');
        $this->assertNotNull($this->obj->get_setter($setter->id), 'Setters::add_setter()');

    }

}
