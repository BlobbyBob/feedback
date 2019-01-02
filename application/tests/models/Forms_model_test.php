<?php

use Models\AnonymousElement;

class Forms_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('FormsSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Forms');
    }

    public function testMaxVersion()
    {
        $name = 'Forms::max_version()';

        $this->assertIsInt($this->obj->max_version(), $name);
        $this->assertEquals(1, $this->obj->max_version(), $name);
    }

    /**
     * @@depends testMaxVersion
     */
    public function testGetForm()
    {
        $name = 'Forms::get_form()';
        $this->assertIsArray($this->obj->get_form(), $name);

        $index = 0;
        $old = [];
        foreach (FormsSeeder::getData() as $data)
            if ($data['version'] < $this->obj->max_version())
                $old[] = $data['id'];

        foreach ($this->obj->get_form() as $elem) {
            $this->assertInstanceOf('Models\Formelement', $elem, $name);
            $this->assertGreaterThanOrEqual($index, $elem->index, $name);
            $index = $elem->index;
            $this->assertFalse(in_array($elem->id, $old), $name);
        }
    }

    /**
     * @depends testMaxVersion
     */
    public function testGetType()
    {
        $name = 'Forms::get_type()';
        $this->assertIsArray($this->obj->get_type(''), $name);

        $map = [
            'checkbox' => 'is_checkbox',
            'numeric' => 'is_numeric',
            'text' => 'is_text',
            'textarea' => 'is_textarea',
            'select' => 'is_select',
            'radio' => 'is_radio',
            'rating' => 'is_rating',
            'pagebreak' => ''
        ];

        foreach ($map as $type => $method) {
            $count = 0;
            foreach (FormsSeeder::getData() as $data) {
                if ($data['type'] == $type && ! $data['version'] < $this->obj->max_version())
                    $count++;
            }
            $result = $this->obj->get_type($type);
            foreach ($result as $elem) {
                $this->assertInstanceOf('\Models\Formelement', $elem, $name);
                $this->assertInstanceOf(\Models\Formelement::getFormelementClassName($type), $elem, $name);
                if ( ! empty($method))
                    $this->assertTrue($elem->$method(), $name);
                $this->assertCount($count, $result, $name);
            }
        }
    }

    /**
     * @depends testMaxVersion
     * @depends testGetForm
     */
    public function testUpdate()
    {
        $name = 'Forms::update()';

        $id = 7;
        $version = 50;
        $data = [];
        $data[] = [
            'id' => $id,
            'version' => $version
        ];

        $count = count($this->obj->get_form());

        $update = $this->obj->update($data);
        $this->assertIsInt($update, $name);
        $this->assertEquals(count($data), $update, $name);
        $this->assertEquals($version, $this->obj->max_version(), $name);
        $this->assertCount(1, $this->obj->get_form(), $name);

        $this->assertEquals(0, $this->obj->update([]), $name);
        $this->assertEquals(0, $this->obj->update($data), $name);

        $data = [];
        $data[] = [
            'id' => $id,
            'version' => 1
        ];

        $update = $this->obj->update($data);
        $this->assertEquals(count($data), $update, $name);
        $this->assertEquals(1, $this->obj->max_version(), $name);
        $this->assertCount($count, $this->obj->get_form(), $name);

    }

    /**
     * @depends testGetForm
     * @depends testGetType
     * @depends testUpdate
     */
    public function testAddFormelement()
    {
        $name = 'Forms::add_formelement()';

        $map = [
            'checkbox',
            'numeric',
            'text',
            'textarea',
            'select',
            'radio',
            'rating',
            'pagebreak'
        ];

        $total = count($this->obj->get_form());
        foreach ($map as $type) {
            $count = count($this->obj->get_type($type));
            $elem = $this->obj->add_formelement($type);
            $this->assertInstanceOf(\Models\Formelement::getFormelementClassName($type), $elem, $name);
            $data = [[
                'id' => $elem->id,
                'version' => $this->obj->max_version()
            ]];
            $this->assertEquals(1, $this->obj->update($data), $name);
            $this->assertCount($count+1, $this->obj->get_type($type));
            $this->assertCount(++$total, $this->obj->get_form(), $name);
        }

        $this->expectException('RuntimeException');
        $this->obj->add_formelement('');
    }

    /**
     * @depends testGetForm
     */
    public function testDelete()
    {
        $name = 'Forms::delete()';

        $elem = new AnonymousElement();
        $elem->id = -1;
        $this->assertEquals(0, $this->obj->delete($elem), $name);
        $elem->id = $this->obj->get_form()[0]->id;
        $count = count($this->obj->get_form());
        $delete = $this->obj->delete($elem);
        $this->assertIsInt($delete, $name);
        $this->assertEquals(1, $delete, $name);
        $this->assertCount($count - 1, $this->obj->get_form(), $name);
        $this->assertEquals(0, $this->obj->delete($elem), $name);
    }

    /**
     * @depends testGetForm
     * @depends testUpdate
     */
    public function testRemoveOldElements()
    {
        $name = 'Forms::remove_old_elements()';

        $data = [[
            'id' => $this->obj->get_form()[0]->id,
            'version' => 0
        ],[
            'id' => $this->obj->get_form()[1]->id,
            'version' => -1
        ]];

        $this->assertEquals(2, $this->obj->update($data), $name);
        $this->obj->remove_old_elements();

        $data[0]['version'] = 1;
        $data[1]['version'] = 1;

        $this->assertEquals(1, $this->obj->update($data), $name);
    }

    /**
     * @depends testGetForm
     */
    public function testGetFormElements()
    {
        $name = 'Forms::get_form_elements()';

        $data = [[
            'ids' => [],
            'count' => 0
        ],[
            'ids' => [-1, -2, -3],
            'count' => 0
        ],[
            'ids' => [$this->obj->get_form()[0]->id, $this->obj->get_form()[1]->id, $this->obj->get_form()[2]->id],
            'count' => 3
        ]];

        foreach ($data as $test) {
            $this->assertIsArray($this->obj->get_form_elements($test['ids']), $name);
            $this->assertCount($test['count'], $this->obj->get_form_elements($test['ids']), $name);

            if ($test['count'] > 0) {
                $ids = [];
                foreach ($this->obj->get_form_elements($test['ids']) as $elem) {
                    $this->assertInstanceOf('\Models\Formelement', $elem, $name);
                    $ids[] = $elem->id;
                }
                sort($ids);
                sort($test['ids']);
                $this->assertEquals($test['ids'], $ids, $name);
            }
        }
    }

}
