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

    public function test_is_image()
    {

        $this->assertFalse($this->obj->is_image(), 'Dbimage::is_image() should return false');
        $this->assertFalse($this->obj->is_image(0), 'Dbimage::is_image(0) should return false');
        $this->assertFalse($this->obj->is_image(100), 'Dbimage::is_image(100) should return false');

        foreach (DbimageSeeder::getData() as $data) {
            $id = $data['id'];
            $this->assertTrue($this->obj->is_image($id), 'Dbimage::is_image('.$id.') should return true');
        }

    }

    public function test_get_ids()
    {

        $this->assertIsArray($this->obj->get_ids(), 'Dbimage::get_ids() should be an array');

        foreach (DbimageSeeder::getData() as $data) {
            $id = $data['id'];
            $this->assertContains($id, $this->obj->get_ids(), 'Dbimage::get_ids() should contain value ' . $id);
        }

    }

    /**
     * @depends test_get_image
     */
    public function test_save_image()
    {

        $image = new \Models\Image();
        $image->id = 10;
        $image->data = hex2bin('ffe8');
        $image->mime = 'image/jpeg';

        $this->obj->save_image($image);
        $actual = $this->obj->get_image(10);

        $this->assertNotNull($actual, 'Dbimage::save() should save data in persistent storage');
        $this->assertEquals($image->id, $actual->id, 'Dbimage::save() should not alter data before saving');
        $this->assertEquals($image->data, $actual->data, 'Dbimage::save() should not alter data before saving');
        $this->assertEquals($image->mime, $actual->mime, 'Dbimage::save() should not alter data before saving');

    }

    /**
     * @depends test_save_image
     * @depends test_is_image
     */
    public function test_delete_image()
    {

        $this->assertTrue($this->obj->is_image(10), 'Dbimage_model_test::test_save() should add image with ID 10');
        $this->assertTrue($this->obj->delete_image(10), 'Dbimage::delete() should delete image from persistent storage');
        $this->assertFalse($this->obj->is_image(10), 'Dbimage::delete() should delete image from persistent storage');
        $this->assertFalse($this->obj->delete_image(10), 'Dbimage::delete() should return false, since image got removed from persistent storage');

    }

}