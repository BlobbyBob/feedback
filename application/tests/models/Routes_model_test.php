<?php

class Routes_model_test extends UnitTestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('RoutesSeeder');
    }

    public function setUp()
    {
        $this->obj = $this->newModel('Routes');
    }

    public function testGetRoutes()
    {
        $name = 'Routes::get_routes()';

        $this->assertIsArray($this->obj->get_routes(-1), $name);
        $this->assertIsArray($this->obj->get_routes(), $name);
        $this->assertCount(0, $this->obj->get_routes(-1), $name);
        $this->assertCount(count(RoutesSeeder::getData()), $this->obj->get_routes(), $name);

        $this->assertInstanceOf('Models\Route', $this->obj->get_routes()[0], $name);

        $this->assertEquals($this->obj->get_routes(null, false), $this->obj->get_routes(null, false), $name);
        $this->assertNotEquals($this->obj->get_routes(null, true), $this->obj->get_routes(null, true), $name); // todo: change to deterministic behaviour

        foreach (RoutesSeeder::getData() as $data) {
            $route = new stdClass();
            foreach ($data as $key => $val) {
                if (in_array($key, ['color', 'setter'])) continue;
                $route->$key = $val;
            }

            $subject = $this->obj->get_routes();
            foreach ($subject as $k => $v) {
                $o = new stdClass();
                foreach ($v as $key => $val) {
                    if (in_array($key, ['color', 'setter'])) continue;
                    $o->$key = $val;
                }
                $subject[$k] = $o;
            }

            $this->assertContains($route, $subject, $name, false, false);

            $subject = $this->obj->get_routes($route->id);
            foreach ($subject as $k => $v) {
                $o = new stdClass();
                foreach ($v as $key => $val) {
                    if (in_array($key, ['color', 'setter'])) continue;
                    $o->$key = $val;
                }
                $subject[$k] = $o;
            }

            $this->assertContains($route, $subject, $name, false, false);
        }

    }

    /**
     * @depends testGetRoutes
     */
    public function testAddRoute()
    {
        $name = 'Routes::add_route()';

        $route = new Models\Route();
        foreach (RoutesSeeder::getData()[0] as $key => $val) {
            $route->$key = $val;
        }

        $this->assertFalse($this->obj->add_route($route), $name);

        $route->id = -1;
        $route->name = 'Route X';
        $this->assertFalse($this->obj->add_route($route), $name);

        $route->id = 100;
        $route->name = 'Route Y';
        $this->assertTrue($this->obj->add_route($route), $name);
        $this->assertCount(1, $this->obj->get_routes($route->id), $name);

    }
}
