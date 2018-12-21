<?php

class Colors_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ColorsSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Colors');
    }

    public function testGetColor()
    {

        $this->assertNull($this->obj->get_color(-1), 'Colors::getColor(-1) should return null');
        $this->assertNull($this->obj->get_color(0), 'Colors::getColor(-1) should return null');
        $this->assertNull($this->obj->get_color(100), 'Colors::getColor(-1) should return null');

        foreach (ColorsSeeder::getData() as $data) {
            $id = $data['id'];
            $this->assertTrue($this->obj->get_color($id) instanceof Models\Color, 'Colors::getColor('.$id.') should return Color object');

            $this->assertEquals($data['id'], $this->obj->get_color($id)->id, 'Colors::getColor('.$id.') should property should match');
            $this->assertEquals($data['name'], $this->obj->get_color($id)->name, 'Colors::getColor('.$id.') should property should match');
            $this->assertEquals($data['german'], $this->obj->get_color($id)->german, 'Colors::getColor('.$id.') should property should match');
        }

    }

    public function testGetColors()
    {

        $this->assertCount(count(ColorsSeeder::getData()), $this->obj->get_colors(), 'Colors::getColors() should return all row');
        foreach ($this->obj->get_colors() as $color)
            $this->assertTrue($color instanceof Models\Color, 'Colors::getColors() should return Color instances');

    }
}
