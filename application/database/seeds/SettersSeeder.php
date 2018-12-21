<?php

class SettersSeeder extends Seeder
{

    private $table = 'setter';

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
                'name' => 'Person A'
            ],
            [
                'id' => 2,
                'name' => 'Person B'
            ],
            [
                'id' => 3,
                'name' => 'Person C'
            ],
        ];
        return $data;
    }

}