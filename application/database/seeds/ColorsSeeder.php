<?php

class ColorsSeeder extends Seeder
{

    private $table = 'color';

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
                'name' => 'black',
                'german' => 'img/jpg'
            ],
            [
                'id' => 2,
                'name' => 'white',
                'german' => 'Weiß'
            ],
            [
                'id' => 3,
                'name' => 'blue',
                'german' => 'Blau'
            ],
        ];
        return $data;
    }

}