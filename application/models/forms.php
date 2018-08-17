<?php

use Models\Formelement;

class Form extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Output all form elements of the latest form
     * @return Formelement[]
     */
    public function get_form()
    {
        /** @var CI_DB_result $query */
        $query = $this->db->query("SELECT * FROM formelements WHERE version=(SELECT MAX(version) FROM formelements) ORDER BY `index` ASC");
        $elements = [];
        foreach ($query->result() as $row) {
            $elements[] = Formelement::create($row);
        }
        return $elements;
    }

}
