<?php

use Models\Formelement;

/**
 * Class Forms
 * Database interface for fetching the survey form
 * @package Feedback
 * @subpackage Models
 * @category Database
 * @author Ben Swierzy
 */
class Forms extends CI_Model
{
    /**
     * Form constructor.
     */
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
