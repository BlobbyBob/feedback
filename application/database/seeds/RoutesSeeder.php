<?php

class RoutesSeeder extends Seeder
{

    private $table = 'routes';

    public function run()
    {
        $this->db->truncate($this->table);

        foreach (self::getData() as $data)
            $this->db->insert($this->table, $data);
    }

    public static function getData()
    {
        $data = [
            [
                'id' => 1,
                'name' => '',
                'grade' => 'VI+',
                'color' => 1,
                'setter' => 1,
                'wall' => 0,
                'image' => 1
            ],
            [
                'id' => 2,
                'name' => 'Route B',
                'grade' => 'VII-',
                'color' => 1,
                'setter' => 1,
                'wall' => 0,
                'image' => 1
            ],
            [
                'id' => 3,
                'name' => 'Route C',
                'grade' => 'VII',
                'color' => 1,
                'setter' => 1,
                'wall' => 0,
                'image' => 1
            ],
            [
                'id' => 4,
                'name' => 'Route D',
                'grade' => 'VII+',
                'color' => 1,
                'setter' => 1,
                'wall' => 0,
                'image' => 1
            ],
        ];
        return $data;
    }

}