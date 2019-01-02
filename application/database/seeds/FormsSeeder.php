<?php

class FormsSeeder extends Seeder
{

    private $table = 'formelements';

    public function run()
    {
        $this->db->truncate($this->table);

        foreach (self::getData() as $data)
            $this->db->insert($this->table, $data);
    }

    public static function getData()
    {
        $data = array(
            array('id' => '1','type' => 'select','data' => '{"label":"Wie oft bist du die Route geklettert?","options":["Einmal im Semester","Einmal im Monat","Mehrmals im Monat","Einmal pro Woche","Mehrmals pro Woche","Einmal pro Session","Mehrmals pro Session"]}','index' => '9','version' => '1'),
            array('id' => '2','type' => 'rating','data' => '{"label":"Wie gut hat dir die Route gefallen?","count":"6","label_before":"Gar nicht","label_after":"Super gut"}','index' => '2','version' => '1'),
            array('id' => '3','type' => 'checkbox','data' => '{"label":"Bist du die Route durchgestiegen?","label_position":"0"}','index' => '3','version' => '1'),
            array('id' => '4','type' => 'text','data' => '{"label":"Und falls ja, nach wie vielen Versuchen?","placeholder":"","maxlength":"512"}','index' => NULL,'version' => '-1'),
            array('id' => '5','type' => 'text','data' => '{"label":"Wie hast du dich beim Erklimmen der mit Plastikgriffen gespickten Holzwand gef\\u00fchlt?","placeholder":"Beispielsweise erf\\u00fcllt oder gedem\\u00fctigt","maxlength":"512"}','index' => '7','version' => '0'),
            array('id' => '6','type' => 'numeric','data' => '{"label":"Und falls ja, nach wie vielen Versuchen?"}','index' => '4','version' => '1'),
            array('id' => '7','type' => 'radio','data' => '{"main_label":"Die Route war","labels":["interessant","merkw\\u00fcrdig","komisch","toll","lebendig","witzig"]}','index' => '5','version' => '1'),
            array('id' => '8','type' => 'pagebreak','data' => '[]','index' => '6','version' => '1'),
            array('id' => '9','type' => 'textarea','data' => '{"label":"Was kann man bei der Route verbessern?","placeholder":""}','index' => '8','version' => '1'),
            array('id' => '10','type' => 'pagebreak','data' => '[]','index' => '1','version' => '1'),
            array('id' => '11','type' => 'rating','data' => '{"label":"Wie fandest du die Route im Vergleich zu anderen Routen?","count":"6","label_before":"Gar nicht sch\\u00f6n","label_after":"Supa sch\\u00f6n"}','index' => '10','version' => '1'),
            array('id' => '12','type' => 'checkbox','data' => '{"label":"Ich w\\u00fcnsche mir n\\u00e4chstes Semester eine Route im gleichen Stil","label_position":"0"}','index' => '11','version' => '1')
        );
        return $data;
    }

}