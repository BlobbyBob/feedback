<?php

class DbimageSeeder extends Seeder
{

    private $table = 'images';

    public function run()
    {
        $this->db->truncate($this->table);

        foreach (self::getData() as $data)
            $this->db->insert($this->table, $data);
    }

    public static function getData()
    {
        $data[] = [
            'id' => 1,
            'data' => hex2bin('ffd8ffe000104a4649460001'),
            'mime' => 'img/jpg'
        ];

        $data[] = [
            'id' => 2,
            'data' => hex2bin('ffd8ffe000104a4649460002'),
            'mime' => 'img/jpg'
        ];

        $data[] = [
            'id' => 3,
            'data' => hex2bin('ffd8ffe000104a4649460003'),
            'mime' => 'img/jpg'
        ];
        return $data;
    }

}