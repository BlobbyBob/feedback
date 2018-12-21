<?php

class FeedbackSeeder extends Seeder
{

    private $table = 'feedback';

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
                'route' => 1,
                'author_id' => 'cf770fba6ebbd328fb8c833cce588100',
                'date' => '2019-01-01 00:00:00',
                'questions' => 7,
                'total' => 7,
                'data' => '{"1":"0","2":"18","3":"1","4":"3","5":"0","6":"abc","7":"abcdefg hijkl"}'
            ],
            [
                'id' => 2,
                'route' => 1,
                'author_id' => 'cf770fba6ebbd318fb8c833cce588100',
                'date' => '2019-01-02 00:00:00',
                'questions' => 7,
                'total' => 7,
                'data' => '{"1":"0","2":"18","3":"1","4":"3","5":"0","6":"abc","7":"abcdefg hijkl"}'
            ],
            [
                'id' => 3,
                'route' => 1,
                'author_id' => 'cf770fba6e4bd328fb8c833cce588100',
                'date' => '2019-01-03 00:00:00',
                'questions' => 0,
                'total' => 7,
                'data' => '{}'
            ],
            [
                'id' => 4,
                'route' => 2,
                'author_id' => 'cf770fba6ebbd328fb8c838cce588100',
                'date' => '2019-01-04 00:00:00',
                'questions' => 7,
                'total' => 7,
                'data' => '{"1":"0","2":"18","3":"1","4":"3","5":"0","6":"abc","7":"abcdefg hijkl"}'
            ],
        ];
        return $data;
    }

}