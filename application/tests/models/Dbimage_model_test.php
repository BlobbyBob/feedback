<?php

class Dbimage_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('DbimageSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Dbimage');
    }

    public function test_get_image()
    {

        $this->assertNull($this->obj->get_image(), 'Dbimage::get_image() should return null');
        $this->assertNull($this->obj->get_image(0), 'Dbimage::get_image(0) should return null');

        foreach (DbimageSeeder::getData() as $data) {
            $id = $data['id'];
            $this->assertTrue($this->obj->get_image($id) instanceof Models\Image, 'Dbimage::get_image('.$id.') should return Models\Image instance');
            $this->assertEquals($data['id'], $this->obj->get_image($id)->id, 'Dbimage::get_image('.$id.') property should match');
            $this->assertEquals($data['data'], $this->obj->get_image($id)->data, 'Dbimage::get_image('.$id.') property should match');
            $this->assertEquals($data['mime'], $this->obj->get_image($id)->mime, 'Dbimage::get_image('.$id.') property should match');
        }

    }

}