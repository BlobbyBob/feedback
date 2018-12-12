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
        parent::__construct(); // Only because IDE marks this...
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

    /**
     * Add a formelement to the current form.
     *
     * @param string $type
     * @return Formelement
     */
    public function add_formelement($type)
    {
        $class = Formelement::getFormelementClassName($type);
        $formelement = new $class(new stdClass());
        $obj = $formelement->export();
        $obj->id = null;
        $query = $this->db->query("SELECT MAX(`index`) AS `index`, MAX(`version`) AS `version` FROM formelements WHERE version=(SELECT MAX(version) FROM formelements)");
        $obj->type = $type;
        $result = $query->result()[0];
        $obj->index = $result->index + 1;
        $obj->version = 0;

        $this->db->insert('formelements', $obj);
        $formelement->id = $this->db->insert_id();
        $formelement->index = $obj->index;

        return $formelement;
    }

}
